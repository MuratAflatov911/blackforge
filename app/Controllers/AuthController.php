<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Validator;
use App\Models\User;

final class AuthController extends Controller
{
    public function loginForm(): void
    {
        $a = random_int(2, 9);
        $b = random_int(2, 9);
        $c = random_int(1, 5);
        $_SESSION['captcha_login_answer'] = ($a * $b) - $c;

        $this->view('auth/login', [
            'captchaQuestion' => "({$a} × {$b}) - {$c}",
            'meta' => ['title' => 'Вход'],
        ]);
    }

    public function login(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $captcha = (int) ($_POST['captcha'] ?? -1);

        if ($captcha !== (int) ($_SESSION['captcha_login_answer'] ?? -999)) {
            $_SESSION['flash'] = 'Неверная CAPTCHA';
            $this->redirect('/login');
        }

        $user = (new User())->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['flash'] = 'Неверный email или пароль';
            $this->redirect('/login');
        }

        Auth::login($user);
        $this->redirect('/profile');
    }

    public function registerForm(): void
    {
        $a = random_int(3, 12);
        $b = random_int(2, 9);
        $c = random_int(1, 4);
        $_SESSION['captcha_register_answer'] = ($a + $b) * $c;

        $this->view('auth/register', [
            'captchaQuestion' => "({$a} + {$b}) × {$c}",
            'meta' => ['title' => 'Регистрация'],
        ]);
    }

    public function register(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $firstName = trim((string) ($_POST['first_name'] ?? ''));
        $lastName = trim((string) ($_POST['last_name'] ?? ''));
        $phone = trim((string) ($_POST['phone'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $confirm = (string) ($_POST['password_confirm'] ?? '');
        $captcha = (int) ($_POST['captcha'] ?? -1);

        $phoneValid = (bool) preg_match('/^[+0-9()\-\s]{8,20}$/', $phone);
        if (!Validator::email($email)
            || !Validator::minLength($password, 8)
            || $password !== $confirm
            || !Validator::minLength($firstName, 2)
            || !Validator::minLength($lastName, 2)
            || !$phoneValid
            || $captcha !== (int) ($_SESSION['captcha_register_answer'] ?? -999)
        ) {
            $_SESSION['flash'] = 'Ошибка валидации регистрации. Проверьте поля формы и CAPTCHA.';
            $this->redirect('/register');
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $_SESSION['flash'] = 'Пользователь с таким email уже существует';
            $this->redirect('/register');
        }

        $userModel->create($email, password_hash($password, PASSWORD_DEFAULT), $firstName, $lastName, $phone);
        $_SESSION['flash'] = 'Регистрация успешна. Подтверждение email: демо-режим.';
        $this->redirect('/login');
    }

    public function forgotForm(): void
    {
        $this->view('auth/forgot', ['meta' => ['title' => 'Восстановление пароля']]);
    }

    public function sendReset(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $_SESSION['reset_email'] = trim((string) ($_POST['email'] ?? ''));
        $_SESSION['flash'] = 'Ссылка для восстановления отправлена на email (демо).';
        $this->redirect('/reset-password');
    }

    public function resetForm(): void
    {
        $this->view('auth/reset', ['meta' => ['title' => 'Новый пароль']]);
    }

    public function resetPassword(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $email = (string) ($_SESSION['reset_email'] ?? '');
        $new = (string) ($_POST['password'] ?? '');
        if ($email === '' || !Validator::minLength($new, 8)) {
            $_SESSION['flash'] = 'Ошибка восстановления пароля';
            $this->redirect('/reset-password');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if ($user) {
            $userModel->changePassword((int) $user['id'], password_hash($new, PASSWORD_DEFAULT));
        }
        $_SESSION['flash'] = 'Пароль изменён. Войдите в систему.';
        $this->redirect('/login');
    }

    public function verifyEmail(): void
    {
        $_SESSION['flash'] = 'Email подтвержден (демо-режим).';
        $this->redirect('/login');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/');
    }
}

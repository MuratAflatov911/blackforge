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
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        $_SESSION['captcha_login_answer'] = $a + $b;

        $this->view('auth/login', [
            'captchaQuestion' => "{$a} + {$b}",
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
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        $_SESSION['captcha_register_answer'] = $a + $b;

        $this->view('auth/register', [
            'captchaQuestion' => "{$a} + {$b}",
            'meta' => ['title' => 'Регистрация'],
        ]);
    }

    public function register(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $captcha = (int) ($_POST['captcha'] ?? -1);

        if (!Validator::email($email) || !Validator::minLength($password, 8) || $captcha !== (int) ($_SESSION['captcha_register_answer'] ?? -999)) {
            $_SESSION['flash'] = 'Ошибка валидации (email/пароль/CAPTCHA)';
            $this->redirect('/register');
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $_SESSION['flash'] = 'Пользователь с таким email уже существует';
            $this->redirect('/register');
        }

        $userModel->create($email, password_hash($password, PASSWORD_DEFAULT));
        $_SESSION['flash'] = 'Регистрация успешна. Подтверждение email: демо-режим.';
        $this->redirect('/login');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/');
    }
}

<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Order;
use App\Models\Product;

final class CheckoutController extends Controller
{
    public function create(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $phone = trim((string) ($_POST['phone'] ?? ''));
        $address = trim((string) ($_POST['address'] ?? ''));
        $delivery = trim((string) ($_POST['delivery'] ?? 'Курьер'));
        $payment = trim((string) ($_POST['payment'] ?? 'Карта'));
        $promo = trim((string) ($_POST['promo'] ?? '')) ?: null;

        $items = [];
        $total = 0.0;
        $model = new Product();
        foreach ($_SESSION['cart'] ?? [] as $pid => $qty) {
            $product = $model->findById((int) $pid);
            if (!$product) {
                continue;
            }
            $items[] = ['id' => $product['id'], 'price' => (float) $product['price'], 'quantity' => (int) $qty];
            $total += (float) $product['price'] * (int) $qty;
        }

        if ($promo === 'BLACK10') {
            $total *= 0.9;
        }

        $orderId = (new Order())->create(Auth::user()['id'] ?? null, $email, $items, round($total, 2), $promo);
        $_SESSION['cart'] = [];
        $_SESSION['last_order'] = [
            'id' => $orderId,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'delivery' => $delivery,
            'payment' => $payment,
        ];
        $_SESSION['flash'] = "Заказ #{$orderId} подтверждён. Email-уведомление отправлено (демо).";
        $this->redirect('/profile');
    }
}

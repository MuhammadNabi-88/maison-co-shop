<?php require __DIR__ . '/includes/bootstrap.php';
login_required();
$a = items($pdo);
if (!$a) {
    notice('Your bag is empty.', 'error');
    go('shop.php');
}
$sum = total_items($a);
$ship = $sum >= 75 ? 0 : 4.9;
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $addr = trim($_POST['address'] ?? '');
    $zip = trim($_POST['postal'] ?? '');
    $city = trim($_POST['city'] ?? '');
    if (!$name || !$email || !$addr || !$zip || !$city)
        $err = 'Please complete all delivery details.';
    else {
        try {
            $pdo->beginTransaction();
            $fresh = [];
            foreach ($a as $p) {
                $s = $pdo->prepare('SELECT * FROM products WHERE id=? FOR UPDATE');
                $s->execute([$p['id']]);
                $x = $s->fetch();
                if (!$x || (int) $x['stock'] < (int) $p['quantity'])
                    throw new RuntimeException('Stock changed for an item. Please update your bag.');
                $fresh[] = [$x, $p['quantity']];
            }
            $s = $pdo->prepare("INSERT INTO orders(user_id,customer_name,email,address,postal_code,city,subtotal,shipping,total,payment_method,status) VALUES(?,?,?,?,?,?,?,?,?,'demo','new')");
            $s->execute([user()['id'], $name, $email, $addr, $zip, $city, $sum, $ship, $sum + $ship]);
            $oid = (int) $pdo->lastInsertId();
            foreach ($fresh as [$p, $q]) {
                $pdo->prepare('INSERT INTO order_items(order_id,product_id,product_name,unit_price,quantity) VALUES(?,?,?,?,?)')->execute([$oid, $p['id'], $p['name'], $p['price'], $q]);
                $pdo->prepare('UPDATE products SET stock=stock-? WHERE id=?')->execute([$q, $p['id']]);
            }
            $pdo->commit();
            $_SESSION['cart'] = [];
            $_SESSION['last_order'] = $oid;
            go('order-success.php');
        } catch (Throwable $e) {
            if ($pdo->inTransaction())
                $pdo->rollBack();
            $err = $e->getMessage();
        }
    }
}
$pageTitle = 'Checkout';
require __DIR__ . '/includes/header.php'; ?>
<section class="page-banner compact"><small class="eyebrow">ALMOST YOURS</small>
    <h1>Make it <em>yours.</em></h1>
    <p>A few details and your selection is on its way.</p>
</section>
<section class="checkout">
    <form method="post" class="auth-card"><?= csrf() ?>
        <h2>01 — Delivery details</h2><?php if ($err): ?>
            <p class="error"><?= e($err) ?></p><?php endif; ?>
        <div class="fields"><label>Full name<input name="name" required
                    value="<?= e($_POST['name'] ?? user()['name']) ?>"></label><label>Email<input type="email" name="email"
                    required value="<?= e($_POST['email'] ?? user()['email']) ?>"></label><label class="wide">Street and
                house number<input name="address" required></label><label>Postal code<input name="postal"
                    required></label><label>City<input name="city" required></label></div>
        <h2>02 — Payment</h2>
        <p class="payment">Demo checkout only. No card details are collected and no payment is taken.</p><button
            class="btn dark full">Place demo order ↗</button>
    </form>
    <aside class="summary"><small class="eyebrow">YOUR SELECTION</small>
        <h2>Order summary</h2><?php foreach ($a as $p): ?>
            <div><span><?= $p['quantity'] ?> × <?= e($p['name']) ?></span><b><?= money($p['line_total']) ?></b></div>
        <?php endforeach; ?>
        <div><span>Shipping</span><b><?= $ship ? money($ship) : 'Complimentary' ?></b></div>
        <div class="grand"><span>Total</span><b><?= money($sum + $ship) ?></b></div>
    </aside>
</section><?php require __DIR__ . '/includes/footer.php'; ?>
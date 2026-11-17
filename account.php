<?php require __DIR__ . '/includes/bootstrap.php';
login_required();
$s = $pdo->prepare('SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC');
$s->execute([user()['id']]);
$orders = $s->fetchAll();
$pageTitle = 'Your account';
require __DIR__ . '/includes/header.php'; ?>
<section class="page-banner compact"><small class="eyebrow">YOUR MAISON ACCOUNT</small>
    <h1>Hello, <em><?= e(explode(' ', user()['name'])[0]) ?>.</em></h1>
    <p>Your details and the things you have chosen to bring home.</p>
</section>
<section class="account">
    <div class="summary"><small class="eyebrow">ACCOUNT DETAILS</small>
        <h2><?= e(user()['name']) ?></h2>
        <p><?= e(user()['email']) ?></p><a class="text-link" href="logout.php">Sign out ↗</a>
    </div>
    <div><small class="eyebrow">YOUR ORDER HISTORY</small>
        <h2>Orders</h2><?php if (!$orders): ?>
            <p>No orders yet. Explore the collection.</p><a class="text-link" href="shop.php">Shop now
                ↗</a><?php else:
            foreach ($orders as $o): ?>
                <div class="order">
                    <b>#MC-<?= $o['id'] ?></b><span><?= e(date('d M Y', strtotime($o['created_at']))) ?></span><span><?= e(ucfirst($o['status'])) ?></span><b><?= money($o['total']) ?></b>
                </div><?php endforeach; endif; ?>
    </div>
</section><?php require __DIR__ . '/includes/footer.php'; ?>
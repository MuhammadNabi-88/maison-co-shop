<?php require dirname(__DIR__) . '/includes/bootstrap.php';
admin_required();
$p = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$o = (int) $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
$u = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn();
$pageTitle = 'Store administration';
require dirname(__DIR__) . '/includes/header.php'; ?>
<section class="page-banner compact"><small class="eyebrow">MAISON & CO. · BACK OFFICE</small>
    <h1>Store <em>overview.</em></h1>
    <p>Manage the collection and keep an eye on the details.</p>
</section>
<section class="admin-cards">
    <div><small>Products</small><b><?= $p ?></b></div>
    <div><small>Orders</small><b><?= $o ?></b></div>
    <div><small>Customers</small><b><?= $u ?></b></div>
</section>
<section class="admin-links"><a href="products.php"><b>Manage products ↗</b><span>Create products and update
            inventory.</span></a><a href="orders.php"><b>Manage orders ↗</b><span>Review orders and change fulfilment
            status.</span></a></section><?php require dirname(__DIR__) . '/includes/footer.php'; ?>
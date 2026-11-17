<?php require __DIR__ . '/includes/bootstrap.php';
login_required();
$id = (int) ($_SESSION['last_order'] ?? 0);
if (!$id)
    go('account.php');
unset($_SESSION['last_order']);
$pageTitle = 'Order received';
require __DIR__ . '/includes/header.php'; ?>
<section class="success">
    <div>✓</div><small class="eyebrow">THANK YOU FOR YOUR ORDER</small>
    <h1>Well chosen.<br><em>Well on its way.</em></h1>
    <p>Your demo order <b>#MC-<?= $id ?></b> was created. No payment has been collected.</p><a class="btn dark"
        href="account.php">View your orders ↗</a>
</section><?php require __DIR__ . '/includes/footer.php'; ?>
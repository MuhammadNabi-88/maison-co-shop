<?php require dirname(__DIR__) . '/includes/bootstrap.php';
admin_required();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $st = $_POST['status'] ?? '';
    if (in_array($st, ['new', 'processing', 'shipped', 'completed', 'cancelled'], true))
        $pdo->prepare('UPDATE orders SET status=? WHERE id=?')->execute([$st, (int) $_POST['id']]);
    notice('Order status updated.');
    go('admin/orders.php');
}
$orders = $pdo->query('SELECT * FROM orders ORDER BY created_at DESC')->fetchAll();
$pageTitle = 'Manage orders';
require dirname(__DIR__) . '/includes/header.php'; ?>
<section class="page-banner compact"><small class="eyebrow">BACK OFFICE</small>
    <h1>Order <em>desk.</em></h1>
</section>
<section class="admin-area"><?php if (!$orders): ?>
        <p>No orders yet.</p><?php endif; ?><?php foreach ($orders as $o): ?>
        <article class="admin-row order-row">
            <div><b>#MC-<?= $o['id'] ?> · <?= e($o['customer_name']) ?></b><small><?= e($o['email']) ?> · <?= e($o['city']) ?> ·
                    <?= e(date('d M Y', strtotime($o['created_at']))) ?></small></div><b><?= money($o['total']) ?></b>
            <form method="post"><?= csrf() ?><input type="hidden" name="id" value="<?= $o['id'] ?>"><select
                    name="status"><?php foreach (['new', 'processing', 'shipped', 'completed', 'cancelled'] as $st): ?>
                        <option <?= $o['status'] === $st ? 'selected' : '' ?>><?= $st ?></option><?php endforeach; ?>
                </select><button class="btn small">Save</button></form>
        </article><?php endforeach; ?>
</section><?php require dirname(__DIR__) . '/includes/footer.php'; ?>
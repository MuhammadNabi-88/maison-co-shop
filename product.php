<?php require __DIR__ . '/includes/bootstrap.php';
$s = $pdo->prepare('SELECT * FROM products WHERE id=? AND is_active=1');
$s->execute([(int) ($_GET['id'] ?? 0)]);
$p = $s->fetch();
if (!$p) {
    http_response_code(404);
    $pageTitle = 'Not found';
    require __DIR__ . '/includes/header.php';
    echo '<div class="empty"><h1>Piece not found.</h1><a href="shop.php">Back to shop</a></div>';
    require __DIR__ . '/includes/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    if ($p['stock'] < 1) {
        notice('This piece is out of stock.', 'error');
    } else {
        $qty = max(1, min(10, (int) $_POST['quantity']));
        $_SESSION['cart'][$p['id']] = min($p['stock'], ($_SESSION['cart'][$p['id']] ?? 0) + $qty);
        notice('Added to your bag.');
    }
    go('cart.php');
}
$pageTitle = $p['name'];
require __DIR__ . '/includes/header.php'; ?>
<div class="crumb"><a href="<?= e(url('shop.php')) ?>">Shop</a> / <?= e($p['category']) ?> / <?= e($p['name']) ?></div>
<section class="detail">
    <div class="detail-photo"><img src="<?= e(image_url($p['image'])) ?>" alt="<?= e($p['name']) ?>"></div>
    <div class="detail-copy"><small class="eyebrow"><?= e(strtoupper($p['category'])) ?> · MAISON EDITION</small>
        <h1><?= e($p['name']) ?></h1><b class="price"><?= money($p['price']) ?></b>
        <p><?= nl2br(e($p['description'])) ?></p>
        <hr><small><?= $p['stock'] ? '● In stock · ' . (int) $p['stock'] . ' available' : 'Currently unavailable' ?></small>
        <form method="post" class="add-form"><?= csrf() ?><label>Quantity <input type="number" name="quantity" value="1"
                    min="1" max="<?= max(1, (int) $p['stock']) ?>"></label><button class="btn dark"
                <?= $p['stock'] < 1 ? 'disabled' : '' ?>>Add to bag ↗</button></form>
        <div class="perks">↗ Thoughtfully selected<br>↗ Secure checkout demo<br>↗ Free shipping over €75</div>
    </div>
</section><?php require __DIR__ . '/includes/footer.php'; ?>
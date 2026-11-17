<?php require __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Shop the collection';
$cat = trim($_GET['category'] ?? '');
$q = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'featured';
$sql = 'SELECT * FROM products WHERE is_active=1';
$args = [];
if ($cat) {
    $sql .= ' AND category=?';
    $args[] = $cat;
}
if ($q) {
    $sql .= ' AND (name LIKE ? OR description LIKE ?)';
    $args[] = "%$q%";
    $args[] = "%$q%";
}
$sql .= match ($sort) { 'low' => ' ORDER BY price ASC', 'high' => ' ORDER BY price DESC', 'new' => ' ORDER BY created_at DESC', default => ' ORDER BY is_featured DESC,name'};
$s = $pdo->prepare($sql);
$s->execute($args);
$products = $s->fetchAll();
$cats = $pdo->query('SELECT DISTINCT category FROM products WHERE is_active=1 ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);
require __DIR__ . '/includes/header.php'; ?>
<section class="page-banner"><small class="eyebrow">THE MAISON COLLECTION</small>
    <h1>Find your <em>everyday.</em></h1>
    <p>Useful things, beautiful details. Selected to be lived with.</p>
</section>
<section class="shop">
    <aside class="filters"><small class="eyebrow">CATEGORIES</small><a href="<?= e(url('shop.php')) ?>"
            class="<?= $cat ? '' : 'chosen' ?>">All pieces</a><?php foreach ($cats as $c): ?><a
                class="<?= $cat === $c ? 'chosen' : '' ?>"
                href="<?= e(url('shop.php?category=' . urlencode($c))) ?>"><?= e($c) ?></a><?php endforeach; ?>
        <p>A considered collection of pieces for home, work and everything between.</p>
    </aside>
    <div>
        <div class="toolbar"><span><?= count($products) ?> considered pieces</span>
            <form method="get"><?php if ($cat): ?><input type="hidden" name="category"
                        value="<?= e($cat) ?>"><?php endif; ?><label>Sort by <select name="sort" onchange="this.form.submit()">
                        <option value="featured">Featured</option>
                        <option value="new" <?= $sort === 'new' ? 'selected' : '' ?>>Newest</option>
                        <option value="low" <?= $sort === 'low' ? 'selected' : '' ?>>Price: low to high</option>
                        <option value="high" <?= $sort === 'high' ? 'selected' : '' ?>>Price: high to low</option>
                    </select></label></form>
        </div>
        <form class="search" method="get"><input name="q" value="<?= e($q) ?>"
                placeholder="Search the collection…"><button>Search ↗</button></form>
        <div class="grid shop-grid"><?php foreach ($products as $p): ?>
                <article class="product"><a class="photo" href="<?= e(url('product.php?id=' . $p['id'])) ?>"><img loading="lazy"
                            src="<?= e(image_url($p['image'])) ?>" alt="<?= e($p['name']) ?>"></a>
                    <div class="product-meta">
                        <div><small><?= e($p['category']) ?></small>
                            <h3><a href="<?= e(url('product.php?id=' . $p['id'])) ?>"><?= e($p['name']) ?></a></h3>
                        </div><b><?= money($p['price']) ?></b>
                    </div>
                </article><?php endforeach; ?>
        </div><?php if (!$products): ?>
            <div class="empty">
                <h2>No pieces found.</h2><a class="btn dark" href="<?= e(url('shop.php')) ?>">View all pieces</a>
            </div><?php endif; ?>
    </div>
</section><?php require __DIR__ . '/includes/footer.php'; ?>
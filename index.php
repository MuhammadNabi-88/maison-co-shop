<?php require __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Thoughtful goods for everyday living';
$featured = $pdo->query('SELECT * FROM products WHERE is_active=1 ORDER BY is_featured DESC,id DESC LIMIT 4')->fetchAll();
require __DIR__ . '/includes/header.php'; ?>
<section class="hero">
    <div class="hero-copy"><small class="eyebrow">THE EVERYDAY EDIT · 2026</small>
        <h1>Make room for<br><em>the meaningful.</em></h1>
        <p>Considered objects, honest materials and little details that make everyday life feel a little more like
            yours.</p><a class="btn dark" href="<?= e(url('shop.php')) ?>">Explore the collection ↗</a><small
            class="hero-note">A slower kind of shopping. A better kind of everyday.</small>
    </div>
    <div class="hero-photo"><img
            src="https://images.unsplash.com/photo-1490312278390-ab64016e0aa9?auto=format&fit=crop&w=1500&q=90"
            alt="Sunlit contemporary interior"><span>01 / Objects with purpose</span></div>
    <div class="stamp">GOOD<br>THINGS<br>TAKE<br>THOUGHT.</div>
</section>
<div class="ribbon"><span>DESIGNED TO LAST</span> ✳ <span>MADE FOR DAILY RITUALS</span> ✳ <span>LESS, BUT BETTER</span>
</div>
<section class="section">
    <div class="section-head">
        <div><small class="eyebrow">A FEW GOOD THINGS</small>
            <h2>Objects worth<br><em>keeping close.</em></h2>
        </div><a class="text-link" href="<?= e(url('shop.php')) ?>">View all products ↗</a>
    </div>
    <div class="grid"><?php foreach ($featured as $i => $p): ?>
            <article class="product"><a class="photo" href="<?= e(url('product.php?id=' . $p['id'])) ?>"><img
                        src="<?= e(image_url($p['image'])) ?>" alt="<?= e($p['name']) ?>"><small>0<?= $i + 1 ?></small></a>
                <div class="product-meta">
                    <div><small><?= e($p['category']) ?></small>
                        <h3><a href="<?= e(url('product.php?id=' . $p['id'])) ?>"><?= e($p['name']) ?></a></h3>
                    </div><b><?= money($p['price']) ?></b>
                </div>
            </article><?php endforeach; ?>
    </div>
</section>
<section class="story"><img
        src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1100&q=85"
        alt="Warm natural interior">
    <div><small class="eyebrow">OUR PHILOSOPHY</small>
        <h2>Not more things.<br><em>Better things.</em></h2>
        <p>We believe the objects around us should earn their place. Through considered design, useful details and
            materials that feel good to live with, we bring intention to the everyday.</p><a class="text-link"
            href="<?= e(url('shop.php')) ?>">Find your everyday ↗</a>
    </div>
</section>
<section class="newsletter"><small class="eyebrow">A NOTE FROM US</small>
    <h2>Good things, occasionally.</h2>
    <p>New arrivals, thoughtful ideas and no unnecessary noise.</p>
    <form onsubmit="event.preventDefault();this.querySelector('button').textContent='You’re on the list ✓'"><input
            type="email" placeholder="Your email address" required><button>Sign me up ↗</button></form><small>Newsletter
        demo — no email is stored.</small>
</section><?php require __DIR__ . '/includes/footer.php'; ?>
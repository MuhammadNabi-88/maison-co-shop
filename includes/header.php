<?php $n = $_SESSION['notice'] ?? null;
unset($_SESSION['notice']);
$u = user(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Thoughtful objects for everyday living.">
    <title><?= e($pageTitle ?? APP_NAME) ?> · <?= e(APP_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>">
</head>

<body>
    <div class="announce">A little more considered. Complimentary shipping over €75.</div>
    <header class="header"><a class="logo" href="<?= e(url()) ?>">maison<span>&</span>co.</a><button class="nav-toggle"
            aria-label="Toggle menu">☰</button>
        <nav><a href="<?= e(url('shop.php')) ?>">Shop all</a><a href="<?= e(url('shop.php?category=Home')) ?>">Home</a><a
                href="<?= e(url('shop.php?category=Everyday')) ?>">Everyday</a><a
                href="<?= e(url('index.php#story')) ?>">Our philosophy</a></nav>
        <div class="tools"><a
                href="<?= e(url($u ? 'account.php' : 'login.php')) ?>"><?= $u ? e(explode(' ', $u['name'])[0]) : 'Account' ?></a><a
                href="<?= e(url('cart.php')) ?>">Bag <i><?= count_cart() ?></i></a></div>
    </header>
    <?php if ($n): ?>
        <div class="notice <?= e($n[1]) ?>"><?= e($n[0]) ?></div><?php endif; ?>
    <main>
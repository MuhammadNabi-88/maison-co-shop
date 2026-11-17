<?php require __DIR__ . '/includes/bootstrap.php';
if (user())
    go('account.php');
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $s = $pdo->prepare('SELECT * FROM users WHERE email=?');
    $s->execute([strtolower(trim($_POST['email'] ?? ''))]);
    $u = $s->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => (int) $u['id'], 'name' => $u['name'], 'email' => $u['email'], 'role' => $u['role']];
        go('account.php');
    } else
        $err = 'Email or password is incorrect.';
}
$pageTitle = 'Sign in';
require __DIR__ . '/includes/header.php'; ?>
<section class="auth">
    <div><small class="eyebrow">WELCOME BACK</small>
        <h1>Your everyday,<br><em>in good hands.</em></h1>
        <p>Sign in to see your account and order history.</p>
    </div>
    <form method="post" class="auth-card"><?= csrf() ?>
        <h2>Sign in</h2><?php if ($err): ?>
            <p class="error"><?= $err ?></p><?php endif; ?><label>Email address<input name="email" type="email"
                required></label><label>Password<input name="password" type="password" required></label><button
            class="btn dark full">Sign in ↗</button>
        <p>New here? <a href="register.php">Create an account</a></p>
    </form>
</section><?php require __DIR__ . '/includes/footer.php'; ?>
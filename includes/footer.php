</main>
<footer class="footer" id="story">
    <div class="footer-grid">
        <div><a class="logo light" href="<?= e(url()) ?>">maison<span>&</span>co.</a>
            <p>Thoughtful objects for a life well lived.</p>
        </div>
        <div><b>Explore</b><a href="<?= e(url('shop.php')) ?>">Shop all</a><a
                href="<?= e(url('shop.php?category=Home')) ?>">Home</a></div>
        <div><b>Help</b><a href="<?= e(url('account.php')) ?>">Your account</a><a
                href="mailto:hello@example.com">Contact</a></div>
        <div class="footer-phrase">Less noise.<br>More meaning.</div>
    </div>
    <div class="footer-bottom">© <?= date('Y') ?> Maison & Co. · Portfolio demonstration <span>Built with PHP &
            MySQL</span></div>
</footer>
<script src="<?= e(url('assets/js/app.js')) ?>"></script>
</body>

</html>
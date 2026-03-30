<footer class="front-footer">
    <div class="container footer-grid">
        <div class="footer-column">
            <h3>Pet Animixon</h3>
            <p>Your trusted partner for premium pet supplies.</p>
            <div class="social">
                <a href="#" aria-label="Facebook">🐶</a>
                <a href="#" aria-label="Instagram">📸</a>
                <a href="#" aria-label="Twitter">🐦</a>
            </div>
        </div>
        <div class="footer-column">
            <h4>Shop</h4>
            <a href="<?php echo e(route('shop')); ?>">All Products</a>
            <a href="<?php echo e(route('categories')); ?>">Categories</a>
            <a href="<?php echo e(route('brands')); ?>">Brands</a>
        </div>
        <div class="footer-column">
            <h4>Info</h4>
            <a href="<?php echo e(route('faq')); ?>">FAQ</a>
            <a href="<?php echo e(route('contact')); ?>">Contact</a>
            <a href="#">About</a>
        </div>
        <div class="footer-column">
            <h4>Newsletter</h4>
            <p>Get the latest deals and pet care tips.</p>
            <form class="newsletter-form" action="#" method="POST">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© <?php echo e(date('Y')); ?> Pet Animixon. All rights reserved.</p>
    </div>
</footer>
<?php /**PATH C:\xampp\htdocs\Petverse\petverse\resources\views/frontend/partials/footer.blade.php ENDPATH**/ ?>
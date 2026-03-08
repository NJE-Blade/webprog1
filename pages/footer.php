<footer class="border-top border-danger bg-black bg-opacity-75 text-center text-secondary py-3">
    <div class="container-xxl">
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-8">
                <p class="mb-0">&copy; 2026 Vaszilij EDC. Minden jog fenntartva.
                    <a href="https://www.facebook.com/VaszilijEdc/" target="_blank" rel="noopener noreferrer" class="text-danger opacity-75">
                        <i class="bi bi-facebook"></i>
                    </a>
                </p>
                <div>
                    <a href="<?php echo BASE_URL; ?>pages/blades_intro.html"><img src="<?php echo BASE_URL; ?>/assets/blades_logo.svg" alt="teeth" width="36px"></a>
                    Blades | Web developement Team's demo
                </div>
            </div>
            <div class="col-2">
                <?php if (!$app->isLoggedIn()): ?>
                    <a href="<?php echo BASE_URL; ?>belepes" class="nav-link">
                        Belépés
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>
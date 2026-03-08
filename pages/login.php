<?php 
    // Kezeljük a sikeres regisztráció üzenetét
    $successMsg = $_SESSION['login_msg'] ?? '';
    unset($_SESSION['login_msg']); 

    // Kezeljük a bejelentkezési hibát (ha van a sessionben)
    $loginHiba = $_SESSION['login_error'] ?? '';
    unset($_SESSION['login_error']);
?>

<section class="bg-black py-5">
    <div class="container" style="max-width: 450px;">
        <?php if ($successMsg): ?>
            <div class="alert alert-success rounded-4 mb-3 border-0 shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo $successMsg; ?>
            </div>
        <?php endif; ?>

        <div class="page-header mb-4">
            <h1>Bejelentkezés <i class="bi bi-lock text-danger page-icon"></i></h1>
        </div>

        <?php if ($loginHiba !== ''): ?>
            <div class="alert alert-danger rounded-4 mb-3 border-0 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo htmlspecialchars($loginHiba); ?>
            </div>
        <?php endif; ?>

        <div class="card bg-dark bg-opacity-75 border border-secondary rounded-4 shadow-lg">
            <div class="card-header bg-danger border-bottom border-secondary py-3 rounded-top-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock"></i>
                    <small class="text-uppercase">Admin belépés</small>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>login-process">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label small text-secondary-emphasis text-uppercase">E-mail *</label>
                        <input id="email" name="email" type="email" class="form-control bg-black bg-opacity-50 border-secondary"
                               placeholder="admin@email.hu" required
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label small text-secondary-emphasis text-uppercase">Jelszó *</label>
                        <input id="password" name="password" type="password" class="form-control bg-black bg-opacity-50 border-secondary"
                               placeholder="Jelszó" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100"><i class="bi bi-box-arrow-in-right"></i> BELÉPÉS</button>
                </form>
            </div>
        </div>
    </div>
</section>
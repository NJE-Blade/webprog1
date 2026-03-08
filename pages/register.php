<?php 
    $regHiba = $_SESSION['reg_error'] ?? '';
    $oldData = $_SESSION['reg_post'] ?? [];
    
    unset($_SESSION['reg_error'], $_SESSION['reg_post']); 
?>

<section class="bg-black py-5">
    <div class="container" style="max-width: 500px;">
        <div class="page-header mb-4">
            <h1>Regisztráció <i class="bi bi-person-plus text-danger page-icon"></i></h1>
        </div>

        <?php if ($regHiba !== ''): ?>
            <div class="alert alert-danger rounded-4 mb-3">
                <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($regHiba); ?>
            </div>
        <?php endif; ?>

        <div class="card bg-dark bg-opacity-75 border border-secondary rounded-4 shadow-lg">
            <div class="card-header bg-danger border-bottom border-secondary py-3 rounded-top-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-shield-plus text-white"></i>
                    <small class="text-uppercase text-white fw-bold">Új fiók létrehozása</small>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>register-process">
                    <div class="mb-3">
                        <label for="fullname" class="form-label small text-secondary-emphasis text-uppercase">Teljes név *</label>
                        <input id="fullname" name="fullname" type="text" class="form-control bg-black bg-opacity-50 border-secondary text-white"
                               placeholder="Vaszilij" required
                               value="<?php echo htmlspecialchars($oldData['fullname'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small text-secondary-emphasis text-uppercase">E-mail cím *</label>
                        <input id="email" name="email" type="email" class="form-control bg-black bg-opacity-50 border-secondary text-white"
                               placeholder="pelda@email.hu" required
                               value="<?php echo htmlspecialchars($oldData['email'] ?? ''); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label small text-secondary-emphasis text-uppercase">Jelszó *</label>
                            <input id="password" name="password" type="password" class="form-control bg-black bg-opacity-50 border-secondary text-white"
                                   placeholder="••••••••" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirm" class="form-label small text-secondary-emphasis text-uppercase">Jelszó újra *</label>
                            <input id="password_confirm" name="password_confirm" type="password" class="form-control bg-black bg-opacity-50 border-secondary text-white"
                                   placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label small text-secondary" for="terms">
                            Elfogadom a felhasználási feltételeket.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 fw-bold">
                        <i class="bi bi-check-circle"></i> REGISZTRÁCIÓ
                    </button>
                    
                    <div class="mt-3 text-center">
                        <small class="text-secondary">Már van fiókod? 
                            <a href="<?php echo BASE_URL; ?>belepes" class="text-danger text-decoration-none">Jelentkezz be!</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<nav class="navbar navbar-expand-md navbar-dark bg-black pt-1 pb-1 navbar-blur border-danger border-bottom sticky-top">
            <div class="container-xxl">
                <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                    <img src="<?php echo BASE_URL; ?>assets/Logo_icon.png" alt="Vaszilij EDC Logo" class="nav-icon">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" 
                aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="main-nav">
                    <ul class="navbar-nav mx-auto">
                        <?php
                            foreach($publicMenuItems as $item) {
                        ?>
                        <li class="nav-item text-uppercase"><a href="<?php echo BASE_URL; ?><?php echo $item['ekezettelen_nev']; ?>" class="nav-link text-decoration-underline link-underline-danger link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"><?php echo $item["megjelenitesi_nev"]; ?></a></li>
                        <?php } ?>
                        <li class="nav-item d-md-none"><a href="https://www.facebook.com/VaszilijEdc/" class="nav-link text-decoration-underline link-underline-danger link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover">FACEBOOK OLDALUNK</a></li>
                        
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-3 d-none d-md-inline">
                    <a href="https://www.facebook.com/VaszilijEdc/" target="_blank" rel="noopener noreferrer" class="text-secondary-emphasis opacity-75"><i class="bi bi-facebook"></i></a>
                </div>

            </div>
        </nav>
        <?php if ($app->isLoggedIn()): ?>
<div class="bg-dark border-bottom border-secondary py-1 shadow-sm">
    <div class="container-xxl">
        <div class="d-flex align-items-center overflow-x-auto no-scrollbar">
            <div class="me-3 border-end border-secondary pe-3 d-flex align-items-center">
                <i class="bi bi-shield-lock text-danger me-2"></i>
                <small class="text-uppercase fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">Adminisztráció</small>
            </div>
            <ul class="nav small flex-nowrap">
                <li class="nav-item">
                    <a class="nav-link text-light opacity-75 link-danger" href="<?php echo BASE_URL; ?>admin/bejegyzesek">
                        <i class="bi bi-journal-text me-1"></i> Bejegyzések
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light opacity-75 link-danger" href="<?php echo BASE_URL; ?>admin/irasok">
                        <i class="bi bi-file-earmark-richtext me-1"></i> Írások
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light opacity-75 link-danger" href="<?php echo BASE_URL; ?>admin/uzenetek">
                        <i class="bi bi-envelope-paper me-1"></i> Üzenetek
                    </a>
                </li>
            </ul>
            <div class="ms-auto ps-3 border-start border-secondary d-none d-sm-block">
                <small class="text-muted">Üdv, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</small>
                <a href="<?php echo BASE_URL; ?>kilepes" class="ms-2 text-danger text-decoration-none small"><i class="bi bi-box-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
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
                        <li class="nav-item"><a href="<?php echo BASE_URL; ?><?php echo $item['ekezettelen_nev']; ?>" class="nav-link text-decoration-underline link-underline-danger link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover"><?php echo $item["megjelenitesi_nev"]; ?></a></li>
                        <?php } ?>
                        <li class="nav-item d-md-none"><a href="https://www.facebook.com/VaszilijEdc/" class="nav-link text-decoration-underline link-underline-danger link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover">FACEBOOK OLDALUNK</a></li>
                        
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-3 d-none d-md-inline">
                    <a href="https://www.facebook.com/VaszilijEdc/" target="_blank" rel="noopener noreferrer" class="text-secondary-emphasis opacity-75"><i class="bi bi-facebook"></i></a>
                </div>

            </div>
        </nav>
<section class="bg-black py-4">
        <div class="container py-0">
            <div class="page-header mb-5">
                <h1>Galéria</h1>
                <p class="text-muted fst-italic mb-0">
                    Vaszilij EDC galéria
                </p>
            </div>
            <?php if ($app->isLoggedIn()): ?>
            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-danger px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-cloud-arrow-up me-2"></i> Kép feltöltése
                </button>
            </div>
            <?php endif; ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php
                /* idg. */
                $galeria = [
                    ["url" => "assets/blog_pictures/giant_mouse_ace_grand_main.jpeg", "title" => "Első kép"],
                    ["url" => "assets/blog_pictures/kanetsune_kiridashi.jpeg", "title" => "Második kép"],
                    ["url" => "assets/blog_pictures/szamurajkardok_foldjen.jpeg", "title" => "Harmadik kép"]
                ];

                /* végigdzsonizok a képeken */
                foreach ($galeria as $kep): ?>
                    <div class="col">
                        <div class="card gallery-card h-100 text-white bg-opacity-75 bg-dark">
                            <div class="gallery-img-container">
                                <img src="<?php echo $kep['url']; ?>" alt="<?php echo $kep['title']; ?>" class="zoom-img">
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between p-3">
                                <h6 class="card-title text-uppercase m-0" style="font-family: 'Rajdhani', sans-serif; letter-spacing: 1px;">
                                    <?php echo $kep['title']; ?>
                                </h6>
                                <?php if ($app->isLoggedIn()): ?>
                                <div class="d-flex justify-content-end align-items-center">
                                    <a href="https://www.youtube.com/watch?v=vAfQJhGWirA?autoplay=1&mute=0" class="btn-action text-danger" title="Kép törlése">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
</section>
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow-lg" data-bs-dismiss="modal" style="z-index: 999;"></button>
                    <img src="" id="fullImage" class="img-fluid rounded shadow-lg border border-danger border-opacity-25" alt="Nagyított kép">
                    <div id="imageCaption" class="text-white mt-3 fst-italic" style="font-family: 'Crimson Text', serif; font-size: 1.5rem;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-black border border-danger">
                <div class="modal-header border-bottom border-danger">
                    <h5 class="modal-title" style="font-family: 'Cinzel', serif;">Új kép hozzáadása</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body" style="font-family: 'Rajdhani', sans-serif;">
                        <div class="mb-4 text-center">
                            <i class="bi bi-images text-danger display-1 opacity-25"></i>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-danger fw-bold">KÉP MEGNEVEZÉSE</label>
                            <input type="text" name="img_title" class="form-control bg-dark text-white border-secondary" placeholder="Pl.: Bushcraft kés #1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-danger fw-bold">FÁJL KIVÁLASZTÁSA</label>
                            <input type="file" name="image_file" class="form-control bg-dark text-white border-secondary" accept="image/*" required>
                            <small class="text-muted">JPG, PNG vagy WEBP formátum ajánlott.</small>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Mégse</button>
                        <button type="submit" class="btn btn-danger px-4">FELTÖLTÉS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-black border border-danger shadow-lg">
                <div class="modal-header border-bottom border-danger">
                    <h5 class="modal-title" style="font-family: 'Cinzel', serif;">Kép törlése</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="font-family: 'Crimson Text', serif; font-size: 1.2rem;">
                    Biztosan törölni akarod ezt a képet a galériából?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Mégse</button>
                    <a href="" id="confirmDeleteBtn" class="btn btn-danger px-4">Törlés</a>
                </div>
            </div>
        </div>
    </div>
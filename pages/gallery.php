<?php
    $images = $db->getGalleryImages();
    $msgSiker = $_SESSION['admin_msg'] ?? null;
    $msgHiba = $_SESSION['admin_error'] ?? null;
    unset($_SESSION['admin_msg'], $_SESSION['admin_error']);
?>

<section class="bg-black py-4">
        <div class="container py-0">
            <div class="page-header mb-5">
                <h1>Galéria</h1>
                <p class="text-muted fst-italic mb-0">
                    Vaszilij EDC galéria
                </p>
            </div>
            <?php if ($msgSiker): ?>
                <div class="alert alert-success bg-dark text-success border-success"><?php echo $msgSiker; ?></div>
            <?php endif; ?>
            <?php if ($msgHiba): ?>
                <div class="alert alert-danger bg-dark text-success border-success"><?php echo $msgHiba; ?></div>
            <?php endif; ?>
            <?php if ($app->isLoggedIn()): ?>
            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-danger px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-cloud-arrow-up me-2"></i> Kép feltöltése
                </button>
            </div>
            <?php endif; ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($images as $img): ?>
                    <div class="col">
                        <div class="card gallery-card h-100 text-white bg-opacity-75 bg-dark"
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal"
                            data-bs-img="<?php echo BASE_URL . 'gallery/' . $img['fajlnev']; ?>"
                            data-bs-title="<?php echo htmlspecialchars($img['elnevezes']); ?>">

                            <div class="gallery-img-container">
                                <img src="<?php echo BASE_URL . 'gallery/' . $img['fajlnev']; ?>" alt="<?php echo htmlspecialchars($img['elnevezes']); ?>" class="zoom-img">
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between p-3">
                                <h6 class="card-title text-uppercase m-0" style="font-family: 'Rajdhani', sans-serif; letter-spacing: 1px;">
                                    <?php echo htmlspecialchars($img['elnevezes']); ?>
                                </h6>
                                <?php if ($app->isLoggedIn()): ?>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button class="btn btn-action text-danger" 
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                    data-id="<?php echo $img['id']; ?>">
                                <i class="bi bi-trash"></i>
                            </button>
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
                <form action="<?php echo BASE_URL; ?>galeria-feltoltes" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="modal-body" style="font-family: 'Rajdhani', sans-serif;">
                        <div class="mb-4 text-center">
                            <i class="bi bi-images text-danger display-1 opacity-25"></i>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-danger fw-bold">KÉP MEGNEVEZÉSE</label>
                            <input type="text" name="title" class="form-control bg-dark text-white border-secondary" placeholder="Pl.: Bushcraft kés #1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-danger fw-bold">FÁJL KIVÁLASZTÁSA</label>
                            <input type="file" name="image" class="form-control bg-dark text-white border-secondary" accept="image/*" required>
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
                    <form action="<?php echo BASE_URL; ?>galeria-torles" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="image_id" id="delete_image_id">
                        <button type="submit" class="btn btn-danger px-4">TÖRLÉS</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        document.getElementById('delete_image_id').value = id;
    });

    const imageViewerModal = document.getElementById('imageModal');
    if (imageViewerModal) {
        imageViewerModal.addEventListener('show.bs.modal', function (event) {
            // A gomb (vagy kép), amire kattintottak
            const triggerElement = event.relatedTarget;
            
            // Adatok kinyerése a data- attribútumokból
            const imgSrc = triggerElement.getAttribute('data-bs-img');
            const imgTitle = triggerElement.getAttribute('data-bs-title');
            
            // Modal elemeinek megkeresése és frissítése
            const modalImage = imageViewerModal.querySelector('#fullImage');
            const modalTitle = imageViewerModal.querySelector('#imageCaption');
            
            if (modalImage) modalImage.src = imgSrc;
            if (modalTitle) modalTitle.textContent = imgTitle;
        });
    }
</script>
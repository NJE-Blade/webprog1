<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaszilij-EDC | Galéria</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Rajdhani:wght@300;400;500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="../css/main.css">

    <style>
        /* ezt is majd bele kell írni a css-be */
        .gallery-card {
            background: rgba(0, 0, 0, 0.65);
            border: 1px solid rgba(220, 53, 69, 0.2);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .gallery-card:hover {
            border-color: #dc3545;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.1);
        }
        .gallery-img-container {
            height: 200px;
            overflow: hidden;
            border-bottom: 1px solid rgba(220, 53, 69, 0.1);
            cursor: pointer; /* kattinthatüság */
        }
        .gallery-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .gallery-card:hover img {
            transform: scale(1.1);
        }
        .form-control:focus {
            background-color: #1a1a1a !important;
            border-color: #dc3545 !important;
            color: white !important;
        }

        /* kinagyított kép stílusa */
        #fullImage {
            max-height: 85vh;
            object-fit: contain;
        }
        .modal-backdrop.show {
            opacity: 0.9 !important; /* ez arra kell, hogy a háttér elsötétüljön */
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 bg-black" data-bs-theme="dark">
    <nav class="navbar navbar-expand-md navbar-dark bg-black pt-1 pb-1 navbar-blur border-danger border-bottom sticky-top">
        <div class="container-xxl">
            <a class="navbar-brand d-flex align-items-center" href="../index.html">
                <img src="assets/Logo_icon.png" alt="Vaszilij EDC Logo" class="nav-icon" style="width: 58px !important; height: auto;">
            </a>
        </div>
    </nav>

    <main class="flex-grow-1">
        <div class="container py-5">
            <div class="p-4 border-start border-danger mb-5">
                <h1 class="display-2 mb-2" style="font-family: 'Cinzel', serif;">Galéria</h1>
                <p class="text-muted fst-italic mb-0" style="font-family: 'Crimson Text', serif; font-size: 1.4rem;">Vaszilij EDC galéria</p>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-danger px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-cloud-arrow-up me-2"></i> Kép feltöltése
                </button>
            </div>

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
                        <div class="card gallery-card h-100 text-white">
                            <div class="gallery-img-container">
                                <img src="<?php echo $kep['url']; ?>" alt="<?php echo $kep['title']; ?>" class="zoom-img">
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between p-3">
                                <h6 class="card-title text-uppercase m-0" style="font-family: 'Rajdhani', sans-serif; letter-spacing: 1px;">
                                    <?php echo $kep['title']; ?>
                                </h6>
                                <div class="d-flex justify-content-end align-items-center">
                                    <a href="https://www.youtube.com/watch?v=vAfQJhGWirA?autoplay=1&mute=0" class="btn-action text-danger" title="Kép törlése">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer class="border-top border-danger bg-black bg-opacity-75 text-secondary text-center py-3">
        <div class="container-xxl">
            <p class="mb-0">&copy; 2025 Vaszilij EDC. Minden jog fenntartva.
                <a href="https://www.facebook.com/VaszilijEdc/" target="_blank" rel="noopener noreferrer" class="text-danger opacity-75">
                <i class="bi bi-facebook"></i>
                </a></p>
            <div><a href="./blades_intro.html"><img src="assets/blades_logo.svg" alt="teeth" width="36px"></a> Blades | Web developement Team's demo</div>
        </div>
    </footer>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/scripts.js"></script>
</body>
</html>
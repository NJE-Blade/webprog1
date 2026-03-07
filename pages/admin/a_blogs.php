<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaszilij-EDC | Blogbejegyzések szerkesztése</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Rajdhani:wght@300;400;500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="../css/main.css">

    <style>
        /* ezt később majd írjuk be a main.css-be szerintem, */
        .admin-table {
            background: rgba(0, 0, 0, 0.65);
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }
        
        .table {
            margin-bottom: 0;
            color: #ccc;
            font-family: 'Rajdhani', sans-serif;
        }
        
        .table thead th {
            font-family: 'Cinzel', serif;
            color: #fff;
            border-bottom: 2px solid #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .table tbody tr {
            transition: background 0.3s;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .table tbody tr:hover {
            background: rgba(220, 53, 69, 0.05);
            color: #fff;
        }
        
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 1.1rem;
            transition: transform 0.2s;
        }
        
        .btn-action:hover {
            transform: scale(1.2);
        }
        
        /* szem ikon a cím mellett */
        .view-icon {
            font-size: 0.9rem;
            opacity: 0.5;
            transition: opacity 0.3s, color 0.3s;
            vertical-align: middle;
        }
        
        .view-icon:hover {
            opacity: 1;
            color: #dc3545 !important;
        }

        .form-control:focus {
            background-color: #1a1a1a !important;
            border-color: #dc3545 !important;
            color: white !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
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
        <section id="blog-admin" class="bg-black">
            <div class="container py-5">
                <div class="p-4 border-start border-danger mb-5">
                    <h1 class="display-2 mb-2" style="font-family: 'Cinzel', serif;">Blogbejegyzések kezelése</h1>
                    <p class="text-muted fst-italic mb-0" style="font-family: 'Crimson Text', serif; font-size: 1.4rem;">
                        Itt tudod szerkeszteni vagy törölni a meglévő bejegyzéseket.
                    </p>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <a href="#" class="btn btn-danger px-4 shadow fw-bold" data-bs-toggle="modal" data-bs-target="#newPostModal">
                        <i class="bi bi-plus-square me-2"></i> ÚJ BEJEGYZÉS
                    </a>
                </div>

                <div class="admin-table shadow-lg">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0 text-white">
                            <thead>
                                <tr>
                                    <th scope="col" class="ps-4">Dátum</th>
                                    <th scope="col">Cím</th>
                                    <th scope="col">Szerző</th>
                                    <th scope="col" class="text-center">Műveletek</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $idgadat = [
                                    ["date" => "2025.03.01", "title" => "Később ezeket az adatokat", "author" => "Selim Etkar"],
                                    ["date" => "2025.02.25", "title" => "az adatbázisból szedjük ki", "author" => "Norbert Stu"],
                                    ["date" => "2025.02.10", "title" => "Sed egestas mi nec turpis imperdiet scelerisque...", "author" => "Köröskényi István"],
                                    ["date" => "2025.01.30", "title" => "Duis aliquet lobortis nulla, eu hendrerit...", "author" => "Gáspár Laci"]
                                ];

                                foreach ($idgadat as $sor): ?>
                                    <tr>
                                        <td class="ps-4 opacity-75 small"><?php echo $sor['date']; ?></td>
                                        <td class="fw-semibold" style="font-family: 'Crimson Text', serif; font-size: 1.2rem;">
                                            <?php echo $sor['title']; ?>
                                            <a href="????" target="_blank" class="ms-2 text-white view-icon" title="Megtekintés az oldalon">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark border border-secondary fw-light">
                                                <?php echo $sor['author']; ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="https://www.youtube.com/embed/vAfQJhGWirA?autoplay=1&mute=0" target="_blank" class="btn-action text-info" title="Szerkesztés">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="https://www.youtube.com/embed/vAfQJhGWirA?autoplay=1&mute=0" class="btn-action text-danger" title="Törlés">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-top border-danger bg-black bg-opacity-75 text-secondary text-center py-4 mt-auto">
        <div class="container-xxl">
            <p class="mb-2">&copy; 2025 Vaszilij EDC. Minden jog fenntartva.
                <a href="https://www.facebook.com/VaszilijEdc/" target="_blank" rel="noopener noreferrer" class="text-danger opacity-75 ms-2">
                    <i class="bi bi-facebook"></i>
                </a>
            </p>
            <div class="small">
                <a href="./blades_intro.html" class="text-decoration-none text-secondary">
                    <img src="assets/blades_logo.svg" alt="teeth" width="24" class="me-1 opacity-75"> Blades | Web development Team's demo
                </a>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="newPostModal" tabindex="-1" aria-labelledby="newPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-black border border-danger shadow-lg">
                <div class="modal-header border-bottom border-danger p-4">
                    <h5 class="modal-title" id="newPostModalLabel" style="font-family: 'Cinzel', serif;">Új blogbejegyzés létrehozása</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="????" method="POST">
                    <div class="modal-body p-4" style="font-family: 'Rajdhani', sans-serif;">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label text-danger fw-bold small" style="letter-spacing: 1px;">BEJEGYZÉS CÍME</label>
                                <input type="text" name="title" class="form-control bg-dark text-white border-secondary py-2" placeholder="Írd ide a címet..." required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-danger fw-bold small" style="letter-spacing: 1px;">SZERZŐ</label>
                                <input type="text" name="author" class="form-control bg-dark text-white border-secondary py-2" placeholder="bejelentkezett felhasználó neve" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-danger fw-bold small" style="letter-spacing: 1px;">TARTALOM</label>
                                <textarea name="content" class="form-control bg-dark text-white border-secondary" rows="8" placeholder="Miről szóljon a mai poszt?" style="font-family: 'Crimson Text', serif; font-size: 1.1rem;" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-secondary bg-dark bg-opacity-25 p-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Mégse</button>
                        <button type="submit" class="btn btn-danger px-5 fw-bold text-uppercase">Közzététel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-black border border-danger shadow-lg">
                <div class="modal-header border-bottom border-danger">
                    <h5 class="modal-title" id="deleteModalLabel" style="font-family: 'Cinzel', serif;">Törlés megerősítése</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-light" style="font-family: 'Crimson Text', serif; font-size: 1.2rem;">
                    Biztosan véglegesen törölni akarod ezt a bejegyzést?
                </div>
                <div class="modal-footer border-top border-secondary p-3">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Mégse</button>
                    <a href="" id="confirmDeleteBtn" class="btn btn-danger px-4 fw-bold">TÖRLÉS</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/scripts.js"></script>
</body>

</html>
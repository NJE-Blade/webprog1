<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaszilij-EDC | Cikkek szerkesztése</title>

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
        .article-title-cell {
            font-family: 'Crimson Text', serif;
            font-size: 1.2rem;
            color: #fff;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 bg-black" data-bs-theme="dark">
    <nav class="navbar navbar-expand-md navbar-dark bg-black pt-1 pb-1 navbar-blur border-danger border-bottom sticky-top">
            <!-- nem teszek bele mindent, mert ez úgyis .phpval lesz :) -->
            <div class="container-xxl">
                <a class="navbar-brand d-flex align-items-center" href="../index.html">
                        <img src="assets/Logo_icon.png" alt="Vaszilij EDC Logo" class="nav-icon" style="width: 58px !important; height: auto;">
                </a>
            </div>
    </nav>

<main class="flex-grow-1">    
    <div class="container py-5">
            <div class="p-4 border-start border-danger mb-5">
                <h1 class="display-2 mb-2" style="font-family: 'Cinzel', serif;">Írások kezelése</h1>
                <p class="text-muted fst-italic mb-0" style="font-family: 'Crimson Text', serif; font-size: 1.4rem;">Itt tudod szerkeszteni vagy törölni a meglévő bejegyzéseket.</p>
            </div>
     </div>

        <div class="container mb-5">
            <div class="d-flex justify-content-end mb-3">
                <a href="#" class="btn btn-danger px-4 shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i> Új cikk
                </a>
            </div>

            <div class="admin-table shadow-lg">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col" class="ps-4">Dátum</th>
                                <th scope="col">Cikk címe</th>
                                <th scope="col">Szerző</th>
                                <th scope="col" class="text-center">Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* egyelőre így töltöm fel a tömböt, de csak, hogy lássam mi a stájsz*/
                            $idgadat = [
                                ["date" => "2025.03.01", "title" => "Később ezeket az adatokat", "author" => "Selim Etkar"],
                                ["date" => "2025.02.25", "title" => "az adatbázisból szedjük ki", "author" => "Norbert Stu"],
                                ["date" => "2025.02.10", "title" => "Sed egestas mi nec turpis imperdiet scelerisque. Duis imperdiet ut magna eu auctor. Integer faucibus, sapien quis varius efficitur, odio erat ultrices justo, in consequat est mi ac est.", "author" => "Köröskényi István"],
                                ["date" => "2025.01.30", "title" => "Duis aliquet lobortis nulla, eu hendrerit sapien hendrerit vitae. Nam ultrices fringilla neque eu luctus. Proin eget purus justo. Maecenas nulla erat, vestibulum sit amet mauris a, interdum ullamcorper urna.", "author" => "Gáspár Laci"]
                            ];
                            /* végigdzsonizok a tömbön */
                            foreach ($idgadat as $sor): ?>
                                <tr>
                                    <td class="ps-4 opacity-75"><?php echo $sor['date']; ?></td> <!-- itt kiíratom a tömb date adatát-->
                                    <td class="fw-semibold"><?php echo $sor['title']; ?></td> <!-- itt kiíratom a tömb title adatát-->
                                    <td><span class="badge bg-dark border border-secondary"><?php echo $sor['author']; ?></span></td> <!-- itt kiíratom a tömb author adatát-->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="https://www.youtube.com/watch?v=vAfQJhGWirA?autoplay=1" target="_blank" class="btn-action text-info" title="Szerkesztés"> <!-- itt pedig rickrollolok mindenkit, _blank miatt nyílik meg új oldalon-->
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="https://www.youtube.com/watch?v=vAfQJhGWirA?autoplay=1" target="_blank" class="btn-action text-danger" title="Törlés"> <!-- itt is meg a rick roll-->
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?> <!-- foreach vége-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

<!-- ── FOOTER ────────────────────────────────────────────── -->
    <footer class="border-top border-danger bg-black bg-opacity-75 text-secondary text-center py-3">
        <div class="container-xxl">
            <p class="mb-0">&copy; 2025 Vaszilij EDC. Minden jog fenntartva.
                <a href="https://www.facebook.com/VaszilijEdc/" target="_blank" rel="noopener noreferrer" class="text-danger opacity-75">
                <i class="bi bi-facebook"></i>
                </a></p>
            <div><a href="./blades_intro.html"><img src="assets/blades_logo.svg" alt="teeth" width="36px"></a> Blades | Web developement Team's demo</div>
        </div>
    </footer>
<!-- ez a felugró ablak stílusa-->

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-black border border-danger shadow-lg">
                <div class="modal-header border-bottom border-danger">
                    <h5 class="modal-title" id="deleteModalLabel" style="font-family: 'Cinzel', serif;">Törlés megerősítése</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-family: 'Crimson Text', serif; font-size: 1.2rem;"> <!-- felugró ablak törzse -->
                    Biztosan véglegesen törölni akarod ezt az írást?
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Mégse</button> <!-- mégse gomb -->
                <a href="" id="confirmDeleteBtn" class="btn btn-danger px-4">Törlés</a> <!-- törlés gomb, az id a js-re hivatkozik -->
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="assets/scripts.js"></script>
</body>
</html>
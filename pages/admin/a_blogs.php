        <section id="blog-admin" class="bg-black">
            <div class="container py-5">
                <div class="page-header mb-5">
                    <h1>Blogbejegyzések kezelése</h1>
                    <p class="text-muted fst-italic mb-0">
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
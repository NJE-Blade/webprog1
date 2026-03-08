<section id="blogs" class="bg-black bg-opacity-75 py-4">
        <div class="container-xxl">
            <div class="bg-black bg-opacity-50 border border-danger rounded-4">
                <div class="row align-items-md-center">
                    <!-- Kép: mobilon felül, desktopon jobbra -->
                    <div class="col-md-5 text-center my-3 ms-md-auto order-1 order-md-2">
                        <img class="img-fluid" src="../assets/blog_balogh.png" alt="blogger_balogh">
                    </div>
                    <!-- Szöveg: mobilon alul, desktopon balra -->
                    <div class="col px-5 py-3  text-center order-2 order-md-1">
                        <h1>
                            <div class="display-4">A Blog</div>
                            <div class="fs-5 text-muted mt-2">"NO KNIFE NO LIFE..."</div>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Szűrők ─────────────────────────────────────────────── -->
    <section id="blog-filter-bar" class="bg-black bg-opacity-75">
        <div class="container-xxl">
            <h4 class="text-muted">Kés és egyéb eszköz bemutatók, beszámolók...</h4>
            <div class="row g-2 align-items-center">
                <div class="col-sm-12 col-md-6 mb-1">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Keresés a Blogok közt...">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="d-flex flex-wrap gap-2 align-items-center" role="group" aria-label="Szűrők">
                        <input type="radio" class="btn-check" name="cat" id="cat-osszes" checked>
                        <label class="btn btn-outline-danger btn-sm text-uppercase" for="cat-osszes"><span id="blog_filter">Összes</span></label>

                        <input type="radio" class="btn-check" name="cat" id="cat-kesek">
                        <label class="btn btn-outline-danger btn-sm text-uppercase" for="cat-kesek"><span id="blog_filter">Kések</span></label>

                        <input type="radio" class="btn-check" name="cat" id="cat-felszereles">
                        <label class="btn btn-outline-danger btn-sm text-uppercase" for="cat-felszereles"><span id="blog_filter">Felszerelés</span></label>

                        <input type="radio" class="btn-check" name="cat" id="cat-beszamolok">
                        <label class="btn btn-outline-danger btn-sm text-uppercase" for="cat-beszamolok"><span id="blog_filter">Beszámolók</span></label>

                        <input type="radio" class="btn-check" name="cat" id="cat-trening">
                        <label class="btn btn-outline-danger btn-sm text-uppercase" for="cat-trening"><span id="blog_filter">Tréning</span></label>

                        <input type="radio" class="btn-check" name="cat" id="cat-kozosseg">
                        <label class="btn btn-outline-danger btn-sm text-uppercase" for="cat-kozosseg"><span id="blog_filter">Közösség</span></label>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── BLOGOK LISTA ───────────────────────────────────────── -->
    <section id="blog-posts" class="bg-black bg-opacity-75 py-4">
        <div class="container-lg">
            <div class="red-dash mb-3">
                <span>Bejegyzések</span>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <a href="./blog_giant_mouse.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/giant_mouse_ace_grand_main.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>GiantMouse Ace Grand</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. feb. 18.</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="./blog_kanetsune.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/kanetsune_kiridashi.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>Kanetsune Kiridashi- a tökéletlenség bölcsessége</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. feb. 10.</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="./blog_szamurajkardok.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/szamurajkardok_foldjen.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>A szamurájkardok földjén...</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. jan. 30.</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <a href="./blog_giant_mouse.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/giant_mouse_ace_grand_main.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>GiantMouse Ace Grand</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. feb. 18.</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="./blog_kanetsune.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/kanetsune_kiridashi.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>Kanetsune Kiridashi- a tökéletlenség bölcsessége</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. feb. 10.</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="./blog_szamurajkardok.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/szamurajkardok_foldjen.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>A szamurájkardok földjén...</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. jan. 30.</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <a href="./blog_giant_mouse.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/giant_mouse_ace_grand_main.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>GiantMouse Ace Grand</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. feb. 18.</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="./blog_kanetsune.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/kanetsune_kiridashi.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>Kanetsune Kiridashi- a tökéletlenség bölcsessége</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. feb. 10.</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="./blog_szamurajkardok.html" class="blog-card-link">
                        <div class="blog-card irasa-item-blog" style="background-image: url('../assets/blog_pictures/szamurajkardok_foldjen.jpeg');">
                            <div class="card-content">
                                <small class="text-danger text-uppercase fw-bold">Kések</small>
                                <h5>A szamurájkardok földjén...</h5>
                                <p class="text-muted">Ez egy példa bejegyzés szövege, ami kicsit hosszabb...</p>
                                <small class="text-muted">2025. jan. 30.</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
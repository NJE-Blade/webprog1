  
 <?php
    $latestBlogs = $db->getLatestBlogs(3);
    $latestWritings = $db->getLatestWritings(3);
    $carouselImages = $db->getLatestGalleryImages(4);
?>

  <!-- ── INTRO ─────────────────────────────────────────────── -->
    <section id="intro" class="py-5">
        <div class="container-xxl p-3 rounded-5 bg-black bg-opacity-50">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <h1>
                        <div class="display-4">Vaszilij|EDC</div>
                        <div class="fs-4 text-muted">Blogok - Írások és Minden ami Everyday Carry</div>
                    </h1>
                    <h6 class="my-4 text-muted">Ezeket a dolgokat cipelem...</h6>
                    <a href="<?php echo BASE_URL; ?>blog" class="btn btn-danger btn-lg">Blog</a>
                </div>
                <div class="col-md-5 text-center d-none d-md-block ms-auto">
                    <img class="img-fluid intro-logo bg-black bg-opacity-50 p-3 rounded-5" src="<?php echo BASE_URL; ?>assets/Logo_icon.png" alt="Vaszilij EDC Logo">
                </div>
            </div>
        </div>
    </section>

    <!-- ── LEGFRISSEBB BLOGOK ─────────────────────────────────── -->
    <section id="fresh-blogs" class="bg-black py-4">
        <div class="container-lg">
            <div class="red-dash mb-3">
                <span>Legfrissebb Blogok</span>
            </div>
            <div class="row g-4">
                <?php foreach ($latestBlogs as $blog): 
                    $img = $app->getFirstImageUrl($blog['tartalom']);
                    $url = BASE_URL . 'blog/' . $blog['id'] . '-' . $app->createSlug($blog['cim']);
                    $excerpt  = $app->getExcerpt($blog['tartalom'], 110);
                ?>
                    <div class="col-md-4">
                        <a href="<?php echo $url; ?>" class="blog-card-link">
                            <div class="blog-card irasa-item-blog" style="background-image: url('<?php echo $img; ?>');">
                                <div class="card-content">
                                    <h5><?php echo htmlspecialchars($blog['cim']); ?></h5>
                                    <p class="text-muted"><?php echo htmlspecialchars($excerpt); ?></p>
                                    <small class="text-muted"><?php echo date('Y. m. d.', strtotime($blog['iras_ideje'])); ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if (!empty($carouselImages)): ?>
    <!-- ── CAROUSEL / GALÉRIA ─────────────────────────────────── -->
    <section id="carousel" class="bg-black bg-opacity-75 py-4">
        <div class="container-md">
            <div class="red-dash mb-3">
                <span>Galéria</span>
            </div>
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php foreach ($carouselImages as $index => $img): ?>
                        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="<?php echo $index; ?>" <?php echo ($index === 0) ? 'class="active"' : ''; ?>></button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner rounded">
                    <?php foreach ($carouselImages as $index => $img): ?>
                        <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                            <a href="<?php echo BASE_URL; ?>galeria">
                                <div class="blog-card-carousel" style="background-image: url('<?php echo BASE_URL . 'gallery/' . $img['fajlnev']; ?>')"></div>
                            </a>
                        </div>
                    <?php endforeach; ?>    
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-danger rounded opacity-75"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-danger rounded opacity-75"></span>
                </button>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ── BEMUTATKOZÁS ───────────────────────────────────────── -->
    <section id="about" class="bg-black py-4">
        <div class="container-lg">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h2 class="mb-3"><span class="text-danger">Naplónak</span> indult.</h2>
                    <h4 class="text-muted mb-4">Bemutatató <span class="text-danger fs-3">Bloggá</span> vált.</h4>
                    <p>Aztán átalkult valami mássá. Ablakkák, amelyben kitekintek a világra, a világ meg betekinthet a gondolataimba: késekről, every day carry felszerelésekről, és az ezek mögött meghúzódó filozófiáról.</p>
                    <p>Aztán ennél is több lett. Egy közösség, amelyben együtt, hasonló értékek mentén dolgozunk azért, hogy egy minősségi, kissé talán régimódi találkahely legyen ez az online térben.</p>
                    <p>Balogh József vagyok, és azon dolgozom, hogy ez a közösség egyre nagyobba váljon, és együtt adhassunk tovább ezek az értékeket. Tarts velünk is!</p>
                </div>
                <div class="col-lg-6">
                    <img src="<?php echo BASE_URL; ?>assets/balogh.webp" class="img-fluid rounded-3 shadow-lg border-0 border-top border-danger border-3" alt="Bemutatkozás">
                </div>
            </div>
        </div>
    </section>

    <!-- ── ÍRÁSOK ─────────────────────────────────────────────── -->
    <section id="writings" class="bg-black bg-opacity-75 py-4">
        <div class="container-lg">
            <div class="red-dash mb-3">
                <span>Írások</span>
            </div>
            <div class="row g-4">
                <?php foreach ($latestWritings as $writing): 
                    $excerpt = $app->getExcerpt($writing['tartalom'], 250);
                    $url = BASE_URL . 'irasok/' . $writing['id'] . '-' . $app->createSlug($writing['cim']);
                ?>
                    <div class="col-md-4">
                        <a href="<?php echo $url; ?>" class="text-decoration-none">
                            <div class="card bg-dark bg-opacity-50 h-100 p-4 border-0 border-top border-danger border-3 irasa-item-blog">
                                <h5 class="card-title text-white"><?php echo htmlspecialchars($writing['szerzo_neve']); ?></h5>
                                <p class="card-text text-secondary"><?php echo htmlspecialchars($excerpt); ?></p>
                                <small class="text-secondary mt-auto"><?php echo date('Y. m. d.', strtotime($writing['iras_ideje'])); ?></small>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── BARÁTAINK ──────────────────────────────────────────── -->
    <section id="friends" class="bg-black py-4">
        <div class="container-lg">
            <h2 class="mb-4">Barátaink</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <div class="col">
                    <a href="https://www.bladeshop.hu/" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block h-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-3 py-3 border-top border-secondary border-opacity-25 h-100">
                            <div class="order-1 order-lg-0 flex-grow-1 text-center text-lg-start">
                                <span class="friends_names text-danger d-block mb-1">Bladeshop</span>
                                <p class="friends_desc text-muted mb-0">Késes webshop gyakori akciókkal és vevőbarát hozzáállással. Ha új kés kell, ne hagyd ki!</p>
                            </div>
                            <div class="order-0 order-lg-1 flex-shrink-0">
                                <img class="friends_logos img-thumbnail" src="<?php echo BASE_URL; ?>assets/other_edc_website_logos/bladeshop.jpg" alt="Bladeshop">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="https://elemlampablog.hu/" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block h-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-3 py-3 border-top border-secondary border-opacity-25 h-100">
                            <div class="order-1 order-lg-0 flex-grow-1 text-center text-lg-start">
                                <span class="friends_names text-danger d-block mb-1">Elemlámpa blog</span>
                                <p class="friends_desc text-muted mb-0">Minden, amit az elemlámpákról tudni szeretnél. Cikkek, bemutatók, illetve kuponok gyűjtőhelye.</p>
                            </div>
                            <div class="order-0 order-lg-1 flex-shrink-0">
                                <img class="friends_logos img-thumbnail" src="<?php echo BASE_URL; ?>assets/other_edc_website_logos/elemlampa.jpg" alt="Elemlámpa blog">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="https://www.kesvilag.hu/" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block h-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-3 py-3 border-top border-secondary border-opacity-25 h-100">
                            <div class="order-1 order-lg-0 flex-grow-1 text-center text-lg-start">
                                <span class="friends_names text-danger d-block mb-1">Késvilág</span>
                                <p class="friends_desc text-muted mb-0">Hazai bolt és webáruház, rendkívül széles termékválasztékkal. Debrecenben személyesen is válogathatsz!</p>
                            </div>
                            <div class="order-0 order-lg-1 flex-shrink-0">
                                <img class="friends_logos img-thumbnail" src="<?php echo BASE_URL; ?>assets/other_edc_website_logos/kesvilag.jpg" alt="Késvilág">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="https://www.magyarkesek.hu/" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block h-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-3 py-3 border-top border-secondary border-opacity-25 h-100">
                            <div class="order-1 order-lg-0 flex-grow-1 text-center text-lg-start">
                                <span class="friends_names text-danger d-block mb-1">Magyar kések</span>
                                <p class="friends_desc text-muted mb-0">Webshop és közösség. Elsősorban a hazai készítők termékeivel foglalkozik, de nyitott egyéb irányokba is.</p>
                            </div>
                            <div class="order-0 order-lg-1 flex-shrink-0">
                                <img class="friends_logos img-thumbnail" src="<?php echo BASE_URL; ?>assets/other_edc_website_logos/mkszoveg.png" alt="Magyar kések">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="https://kesportal.hu/" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block h-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-3 py-3 border-top border-secondary border-opacity-25 h-100">
                            <div class="order-1 order-lg-0 flex-grow-1 text-center text-lg-start">
                                <span class="friends_names text-danger d-block mb-1">Késportál</span>
                                <p class="friends_desc text-muted mb-0">Magyarország legnagyobb késes tudásbázisa. Érdemes csatlakoznod a fórumhoz is!</p>
                            </div>
                            <div class="order-0 order-lg-1 flex-shrink-0">
                                <img class="friends_logos img-thumbnail" src="<?php echo BASE_URL; ?>assets/other_edc_website_logos/kesportal.jpg" alt="Késportál">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="https://www.zboss.hu/" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block h-100">
                        <div class="d-flex flex-column flex-lg-row align-items-center gap-3 py-3 border-top border-secondary border-opacity-25 h-100">
                            <div class="order-1 order-lg-0 flex-grow-1 text-center text-lg-start">
                                <span class="friends_names text-danger d-block mb-1">ZBOSS</span>
                                <p class="friends_desc text-muted mb-0">Kések, edc felszerelések, túra és sok egyéb. Hazai webáruház, ahol a vevők elégedettsége a legfontosabb.</p>
                            </div>
                            <div class="order-0 order-lg-1 flex-shrink-0">
                                <img class="friends_logos img-thumbnail" src="<?php echo BASE_URL; ?>assets/other_edc_website_logos/zbboss.jpg" alt="ZBOSS">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <p class="text-white-50 mt-4">Facebook közösségünk:
                <a href="https://www.facebook.com/groups/434204628313605" target="_blank" rel="noopener noreferrer" class="text-danger fs-4 opacity mx-1"><i class="bi bi-facebook"></i></a>
            </p>
        </div>
    </section>
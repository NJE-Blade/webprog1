<?php
    $search      = $_GET['search'] ?? null;

    $perPage = 9;
    $totalPosts  = $db->countBlogs($search);
    $totalPages  = (int) ceil($totalPosts / $perPage);
    $currentPage = max(1, min((int)($_GET['page'] ?? 1), $totalPages ?: 1));
    $offset      = ($currentPage - 1) * $perPage;

    $blogPosts   = $db->getAllBlogs($search, $perPage, $offset);


    $queryBase = http_build_query(array_filter([
        'search'   => $search,
    ]));
    
    $queryBase = $queryBase ? '&' . $queryBase : '';
?>

<section id="blogs" class="bg-black bg-opacity-75 py-4">
        <div class="container-xxl">
            <div class="bg-black bg-opacity-50 border border-danger rounded-4">
                <div class="row align-items-md-center">
                    <!-- Kép: mobilon felül, desktopon jobbra -->
                    <div class="col-md-5 text-center my-3 ms-md-auto order-1 order-md-2">
                        <img class="img-fluid" src="<?php echo BASE_URL; ?>assets/blog_balogh.png" alt="blogger_balogh">
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
                    <form action="<?php echo BASE_URL; ?>blog" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-search"></i>
                            </button>
                            <input type="text" name="search" class="form-control bg-dark border-secondary text-white" placeholder="Keresés a bejegyzések között..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                        </div>
                        <?php if ($search): ?>
                            <a href="<?php echo BASE_URL; ?>blog" class="btn btn-outline-secondary">X</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="d-flex flex-wrap gap-2 align-items-center" role="group" aria-label="Szűrők">
                        <a href="<?php echo BASE_URL . 'blog?search=kés'; ?>" class="btn btn-outline-danger text-uppercase">KÉSEK</a>
                        <a href="<?php echo BASE_URL . 'blog?search=bicska'; ?>" class="btn btn-outline-danger text-uppercase">BICSKÁK</a>
                        <a href="<?php echo BASE_URL . 'blog?search=felszerelés'; ?>" class="btn btn-outline-danger text-uppercase">FELSZERELÉSEK</a>
                        <a href="<?php echo BASE_URL . 'blog?search=ajánl'; ?>" class="btn btn-outline-danger text-uppercase">AJÁNLÁSOK</a>
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
                <?php if (!empty($blogPosts)): ?>
                    <?php foreach ($blogPosts as $post): 
                        $firstImg = $app->getFirstImageUrl($post['tartalom']);
                        $excerpt  = $app->getExcerpt($post['tartalom'], 110);
                        $url = BASE_URL . 'blog/' . $post['id'] . '-' . $app->createSlug($post['cim']);
                    ?>
                        <div class="col-md-4">
                            <a href="<?php echo $url; ?>" class="blog-card-link">
                                <div class="blog-card irasa-item-blog" style="background-image: url('<?php echo $firstImg; ?>');">
                                    <div class="card-content">
                                        <small class="text-danger text-uppercase fw-bold"><?php echo htmlspecialchars($post['szerzo_neve']); ?></small>
                                        <h5><?php echo htmlspecialchars($post['cim']); ?></h5>
                                        <p class="text-muted"><?php echo htmlspecialchars($excerpt); ?></p>
                                        <small class="text-muted"><?php echo date('Y.m.d.', strtotime($post['iras_ideje'])); ?></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fst-italic">Hamarosan érkeznek az első bejegyzések!</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($totalPages > 1): ?>
    
    <nav aria-label="Lapozó" class="d-flex justify-content-center">
        <ul class="pagination pagination mb-0">
            <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link bg-dark border-secondary text-white" 
                   href="<?php echo BASE_URL . 'blog?page=' . ($currentPage - 1) . $queryBase; ?>">
                    &laquo;
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                    <a class="page-link <?php echo $i === $currentPage ? 'bg-danger border-danger' : 'bg-dark border-secondary text-white'; ?>"
                       href="<?php echo BASE_URL . 'blog?page=' . $i . $queryBase; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link bg-dark border-secondary text-white"
                   href="<?php echo BASE_URL . 'blog?page=' . ($currentPage + 1) . $queryBase; ?>">
                    &raquo;
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

        </div>
    </section>
<?php
    $blogPosts = $db->getAllBlogs();
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
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Keresés a Blogok közt...">
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
                                        <h5><?php echo htmlspecialchars($post['cim']); ?></h5>
                                        <p class="text-muted"><?php echo htmlspecialchars($excerpt); ?></p>
                                        <small class="text-muted"><?php echo date('Y. m. d.', strtotime($post['iras_ideje'])); ?></small>
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
        </div>
    </section>
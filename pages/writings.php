<?php
    $blogPosts = $db->getAllWritings();
?>

<section id="writings" class="bg-black py-4">
        <div class="container py-0">
            <div class="page-header">
                <h1>Írások <i class="bi bi-pen text-danger page-icon"></i></h1>
                <p class="text-muted fst-italic mb-0">Gondolatok az éterben a világról, világomról...</p>
            </div>
            <div class="red-dash mb-3 my-5">
                <span>Archívum</span>
            </div>
            
            <!-- ── Írás elemek ────────────────────────────────── -->
            <div id="writings-container">

                <?php if (!empty($blogPosts)): ?>
                    <?php foreach ($blogPosts as $post): 
                        $excerpt  = $app->getExcerpt($post['tartalom'], 400);
                        $url = BASE_URL . 'irasok/' . $post['id'] . '-' . $app->createSlug($post['cim']);
                    ?>
                        <div class="irasa-item d-flex gap-4 p-4 bg-dark bg-opacity-75 border border-secondary mb-4 align-items-start clickable-writing"
                            role="button"  data-url="<?php echo $url; ?>">
                            <div class="fs-5 text-danger flex-shrink-0">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="mt-2 mb-3"><?php echo htmlspecialchars($post['cim']); ?></h3>
                                <p class="mb-2 text-secondary fst-italic">
                                    <?php echo htmlspecialchars($excerpt); ?>
                                </p>
                                <small class="text-secondary-emphasis"><?php echo htmlspecialchars($post['szerzo_neve']); ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fst-italic">Hamarosan érkeznek az első írások!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const writingCards = document.querySelectorAll('.clickable-writing');
    
    writingCards.forEach(card => {
        card.addEventListener('click', function() {
            const targetUrl = this.getAttribute('data-url');
            if (targetUrl) {
                window.location.href = targetUrl;
            }
        });
    });
});
</script>
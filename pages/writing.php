<?php

$urlParts = $app->getUrlParts();
$slug = $urlParts[1] ?? null;

$postId = intval($slug);

$post = null;
if ($postId > 0) {
    $post = $db->getWritingWithAuthor($postId);
}

if (!$post) {
    header("Location: " . BASE_URL . "irasok");
    exit;
}
?>

<section class="bg-black py-4">
        <div class="container">
            <div class="mb-2">
                <a href="<?php echo BASE_URL; ?>irasok" class="text-danger text-decoration-none"><i class="bi bi-arrow-left"></i> Vissza az írásokhoz</a>
            </div>

            <h1 class="mt-2 mb-3"><?php echo htmlspecialchars($post['cim']); ?></h1>

            <div class="d-flex gap-3 blog-article-meta text-muted mb-4">
                <span><i class="bi bi-calendar3"></i> <?php echo date('Y.m.d.', strtotime($post['iras_ideje'])); ?></span>
                <span><i class="bi bi-person"></i> <?php echo htmlspecialchars($post['szerzo_neve'] ?? 'Admin'); ?></span>
            </div>

            <hr class="border-danger opacity-50">

            <?php echo $post['tartalom']; ?>

            <hr class="border-secondary opacity-50 mt-5">
            <div class="d-flex justify-content-between align-items-center text-muted">
                <small>Szerző: <?php echo htmlspecialchars($post['szerzo_neve'] ?? 'Admin'); ?></small>
                <a href="<?php echo BASE_URL; ?>irasok" class="btn btn-outline-danger btn-sm"><i class="bi bi-arrow-left"></i> Összes írás</a>
            </div>
        </div>
    </section>
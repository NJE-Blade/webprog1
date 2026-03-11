<?php

$blogPosts = $db->getAllBlogs();

$msgSiker = $_SESSION['admin_msg'] ?? null;
$msgHiba = $_SESSION['admin_error'] ?? null;

unset($_SESSION['admin_msg']);
unset($_SESSION['admin_error']);
?>

<section id="blog-admin" class="bg-black">
    <div class="container py-5">
        
        <?php if ($msgSiker): ?>
            <div class="alert alert-success bg-success bg-opacity-10 border-success text-success mb-4 border-0 shadow-sm rounded-3">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo $msgSiker; ?>
            </div>
        <?php endif; ?>

        <div class="page-header mb-5">
            <h1>Blogbejegyzések kezelése <i class="bi bi-journal-text text-danger ms-2"></i></h1>
            <p class="text-muted fst-italic mb-0">Itt tudod szerkeszteni vagy törölni a meglévő bejegyzéseket.</p>
        </div>
        
        <div class="d-flex justify-content-end mb-3">
            <a href="<?php echo BASE_URL; ?>admin/bejegyzes-szerkesztes" class="btn btn-danger px-4 shadow fw-bold">
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
                        <?php if (empty($blogPosts)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Nincsenek bejegyzések.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($blogPosts as $post): ?>
                                <tr>
                                    <td class="ps-4 opacity-75">
                                        <?php echo date('Y.m.d.', strtotime($post['iras_ideje'])); ?>
                                    </td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($post['cim']); ?>
                                        <a href="<?php echo BASE_URL ?>blog/<?php echo $post['id'] . "-" . $app->createSlug($post['cim']); ?>" target="_blank" class="ms-2 text-white view-icon" title="Megtekintés az oldalon">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-dark border border-secondary">
                                            <?php echo htmlspecialchars($post['szerzo_neve'] ?? 'Vaszilij'); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="<?php echo BASE_URL; ?>admin/bejegyzes-szerkesztes" method="POST" class="d-inline">
                                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    
                                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                                <button type="submit" class="btn btn-action text-info bg-transparent border-0 p-0">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </form>
                                            <button class="btn btn-action text-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal" 
                                                    data-id="<?php echo $post['id']; ?>">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-black border border-danger shadow-lg">
            <div class="modal-header border-bottom border-danger">
                <h5 class="modal-title text-white" id="deleteModalLabel" style="font-family: 'Cinzel', serif;">Törlés megerősítése</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>bejegyzes-torles" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="delete_id" id="delete_id">
                
                <div class="modal-body p-4 text-light" style="font-family: 'Crimson Text', serif; font-size: 1.2rem;">
                    Biztosan véglegesen törölni akarod ezt a blogbejegyzést? Ez a művelet nem vonható vissza.
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Mégse</button>
                    <button type="submit" class="btn btn-danger px-5 fw-bold">TÖRLÉS</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const postId = button.getAttribute('data-id');
            const inputId = deleteModal.querySelector('#delete_id');
            inputId.value = postId;
        });
    }
});
</script>
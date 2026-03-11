<?php

    $msgHiba = $_SESSION['admin_error'] ?? '';
    $old = $_SESSION['tmp_post'] ?? []; 

    $editId = $_POST['post_id'] ?? ($old['post_id'] ?? null);
    $postData = null;

    if ($editId && empty($old)) {
        $postData = $db->getPostById($editId);
    }

    $displayId      = $editId;
    $displayTitle   = $old['title'] ?? ($postData['cim'] ?? '');
    $displayContent = $old['content'] ?? ($postData['tartalom'] ?? '');

    unset($_SESSION['admin_error'], $_SESSION['admin_msg'], $_SESSION['tmp_post']);
?>


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<section id="new-post" class="bg-black py-5">
    <div class="container">
        <div class="page-header mb-5">
            <h1>Új blogbejegyzés <i class="bi bi-pen text-danger ms-2"></i></h1>
            <p class="text-muted fst-italic">Hozz létre egy új, maradandó tartalmat a Vaszilij EDC közösség számára.</p>
        </div>
        <?php if ($msgHiba): ?>
            <div class="alert alert-danger"><?php echo $msgHiba; ?></div>
        <?php endif; ?>
        
        <div class="card bg-black border-secondary border-opacity-25 shadow-lg">
            <div class="card-body p-4">
                <form action="<?php echo BASE_URL; ?>bejegyzes-mentes" method="POST" id="postForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <?php if ($displayId): ?>
                        <input type="hidden" name="post_id" value="<?php echo $displayId; ?>">
                    <?php endif; ?>
                    
                    <div class="mb-4">
                        <label for="title" class="form-label small text-secondary-emphasis text-uppercase fw-bold">Bejegyzés címe</label>
                        <input type="text" id="title" name="title" class="form-control bg-black border-secondary text-white p-3" placeholder="Add meg a cikk címét..." value="<?php echo htmlspecialchars($old['title'] ?? ($postData['cim'] ?? '')); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-secondary-emphasis text-uppercase fw-bold">Tartalom</label>
                        <div class="summernote-dark-wrapper">
                            <textarea id="summernote" name="content"><?php echo $old['content'] ?? ($postData['tartalom'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="<?php echo BASE_URL; ?>admin/irasok" class="btn btn-outline-secondary px-4">MÉGSE</a>
                        <button type="submit" class="btn btn-danger px-5 fw-bold">BEJEGYZÉS KÖZZÉTÉTELE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.note-editor.note-airframe, .note-editor.note-frame { border: 1px solid rgba(255,255,255,0.1); background: #111; color: #fff; }
.note-editable { background-color: #000 !important; color: #ccc !important; font-family: 'Crimson Text', serif; font-size: 1.2rem; }
</style>
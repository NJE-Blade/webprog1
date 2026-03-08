<?php
// Üzenetek lekérése a modell segítségével
$messages = $db->getAllMessages();

$adminMsg = $_SESSION['admin_msg'] ?? null;
$adminError = $_SESSION['admin_error'] ?? null;

unset($_SESSION['admin_msg']);
unset($_SESSION['admin_error']);
?>

<section id="messages-admin" class="bg-black">
    <div class="container py-5">
        <div class="page-header mb-5">
            <h1>Üzenetek kezelése <i class="bi bi-envelope-paper text-danger ms-2"></i></h1>
            <p class="text-muted fst-italic mb-0">Itt tekintheted meg a látogatók által küldött összes üzenetet.</p>
        </div>

        <?php if ($adminMsg): ?>
            <div class="alert alert-success alert-dismissible fade show bg-success bg-opacity-10 border-success text-success mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo $adminMsg; ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($adminError): ?>
            <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 border-danger text-danger mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $adminError; ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="container px-0 mb-5">
            <div class="admin-table shadow-lg border border-secondary border-opacity-25 rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="table-dark">
                                <th scope="col" class="ps-4">Dátum</th>
                                <th scope="col">Feladó</th>
                                <th scope="col">Üzenet (részlet)</th>
                                <th scope="col" class="text-center pe-4">Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($messages)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted fst-italic small">Nincs beérkezett üzenet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($messages as $msg): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="text-danger fw-bold small">
                                                <?php echo date('Y.m.d. H:i', strtotime($msg['bekuldes_ideje'])); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-white"><?php echo htmlspecialchars($msg['nev']); ?></div>
                                            <div class="small text-secondary"><?php echo htmlspecialchars($msg['email']); ?></div>
                                        </td>
                                        <td>
                                            <div class="text-truncate text-secondary" style="max-width: 350px;">
                                                <?php echo htmlspecialchars($msg['uzenet_szovege']); ?>
                                            </div>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" class="btn btn-outline-light btn-sm px-3" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewMessageModal" 
                                                        data-id="<?php echo htmlspecialchars($msg['id']); ?>"
                                                        data-sender="<?php echo htmlspecialchars($msg['nev']); ?>"
                                                        data-email="<?php echo htmlspecialchars($msg['email']); ?>"
                                                        data-date="<?php echo date('Y.m.d. H:i', strtotime($msg['bekuldes_ideje'])); ?>"
                                                        data-content="<?php echo htmlspecialchars($msg['uzenet_szovege']); ?>">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                        data-id="<?php echo $msg['id']; ?>">
                                                    <i class="bi bi-trash"></i>
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
    </div>
</section>

<div class="modal fade" id="viewMessageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border border-secondary shadow-lg">
            <div class="modal-header border-bottom border-danger bg-black bg-opacity-50">
                <h5 class="modal-title text-uppercase fw-bold" style="font-family: 'Cinzel', serif;">
                    <i class="bi bi-envelope-open text-danger me-2"></i> Üzenet részletei
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label class="small text-danger text-uppercase fw-bold mb-1">Küldő:</label>
                        <p id="modalSender" class="text-white fw-bold mb-0"></p>
                        <small id="modalEmail" class="text-secondary"></small>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <label class="small text-danger text-uppercase fw-bold mb-1">Dátum:</label>
                        <p id="modalDate" class="text-white mb-0 small"></p>
                    </div>
                </div>
                <hr class="border-secondary opacity-25">
                <div class="message-content bg-black bg-opacity-50 p-3 rounded-3 border border-secondary border-opacity-25" 
                     style="font-family: 'Crimson Text', serif; font-size: 1.25rem; white-space: pre-wrap; min-height: 200px;" id="modalContent">
                </div>
            </div>
            <div class="modal-footer border-top border-secondary bg-black bg-opacity-25">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Bezárás</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-black border border-danger shadow-lg">
            <div class="modal-header border-bottom border-danger">
                <h5 class="modal-title" style="font-family: 'Cinzel', serif;">Törlés megerősítése</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>admin/uzenet-torles" method="POST">
                <div class="modal-body" style="font-family: 'Crimson Text', serif; font-size: 1.2rem;">
                    Biztosan véglegesen törölni akarod ezt az elemet?
                    <input type="hidden" name="id" id="delete-id">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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

const viewModal = document.getElementById('viewMessageModal');
if (viewModal) {
    viewModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        
        const sender = button.getAttribute('data-sender');
        const email = button.getAttribute('data-email');
        const date = button.getAttribute('data-date');
        const content = button.getAttribute('data-content');

        viewModal.querySelector('#modalSender').textContent = sender;
        viewModal.querySelector('#modalEmail').textContent = email;
        viewModal.querySelector('#modalDate').textContent = date;
        viewModal.querySelector('#modalContent').textContent = content;
        viewModal.querySelector('#modalReplyBtn').href = "mailto:" + email;
    });
}

const deleteModal = document.getElementById('deleteModal');
if (deleteModal) {
    deleteModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        
        deleteModal.querySelector('#delete-id').value = id;
    });
}

</script>

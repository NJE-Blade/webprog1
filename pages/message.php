<?php 
    //captcha
    $n1 = rand(1, 10);
    $n2 = rand(1, 10);
    $_SESSION['captcha_ans'] = $n1 + $n2;

    $msgHiba = $_SESSION['msg_error'] ?? '';
    $msgSiker = $_SESSION['msg_success'] ?? '';
    $old = $_SESSION['msg_post'] ?? [];

    unset($_SESSION['msg_error'], $_SESSION['msg_success'], $_SESSION['msg_post']);
?>

<section id="messages" class="bg-black py-4">
    <div class="container">
        <div class="page-header mb-5">
            <h1>Üzenetek <i class="bi bi-envelope text-danger page-icon"></i></h1>
            <p class="text-muted fst-italic mb-0">
                Van mondanivalód? Kérdésed, együttműködés ötleted, vagy írás, amit beküldenél?
                Írj nekünk — minden üzenetet elolvasunk.
            </p>
        </div>

        <?php if ($msgHiba): ?>
            <div class="alert alert-danger rounded-4 mb-4 border-0 shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo htmlspecialchars($msgHiba); ?>
            </div>
        <?php endif; ?>

        <?php if ($msgSiker): ?>
            <div class="alert alert-success rounded-4 mb-4 border-0 shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo htmlspecialchars($msgSiker); ?>
            </div>
        <?php endif; ?>

        <div class="red-dash mb-3">
            <span>Üzenj nekünk!</span>
        </div>

        <div class="card bg-dark bg-opacity-75 border border-secondary rounded-4 shadow-lg">
            <div class="card-header bg-danger border-bottom border-secondary py-3 rounded-top-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-chat-left-text"></i>
                    <small class="text-uppercase">Új üzenet</small>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo BASE_URL; ?>message-process">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label small text-secondary-emphasis text-uppercase">Név *</label>
                            <input id="name" name="name" type="text" class="form-control bg-black bg-opacity-50 border-secondary text-white" 
                                   placeholder="Teljes neved" required value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label small text-secondary-emphasis text-uppercase">E-mail *</label>
                            <input id="email" name="email" type="email" class="form-control bg-black bg-opacity-50 border-secondary text-white" 
                                   placeholder="email@pelda.hu" required value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
                        </div>
                        <div class="col-md-12">
                            <label for="subject" class="form-label small text-secondary-emphasis text-uppercase">Tárgy</label>
                            <input id="subject" name="subject" type="text" class="form-control bg-black bg-opacity-50 border-secondary text-white" 
                                   placeholder="Miről szól az üzenet?" value="<?php echo htmlspecialchars($old['subject'] ?? ''); ?>">
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label small text-secondary-emphasis text-uppercase">Üzenet *</label>
                            <textarea id="message" name="message" class="form-control bg-black bg-opacity-50 border-secondary text-white" 
                                      rows="9" placeholder="Ide írd az üzeneted..." required><?php echo htmlspecialchars($old['message'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="captcha" class="form-label small text-secondary-emphasis text-uppercase">Ellenőrzés: Mennyi <?php echo "$n1 + $n2"; ?>? *</label>
                            <input id="captcha" name="captcha" type="number" class="form-control bg-black bg-opacity-50 border-secondary text-white" 
                                   placeholder="Írd ide az eredményt..." required>
                        </div>
                    </div>
                    
                    <hr class="border-secondary opacity-50 my-4">
                    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                        <small class="text-muted">Tiszteletben tartjuk az adataidat. Az üzenetedet nem tároljuk nyilvánosan.</small>
                        <button type="submit" class="btn btn-danger px-4"><i class="bi bi-send"></i> ÜZENET KÜLDÉSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
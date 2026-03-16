<?php

include_once("config.php");

class Controller {
    private $urlParts;
    private $model;
    
	//konstruktor
    public function __construct() {
        $this->urlParts = $this->parseSiteNames();

        require_once("model.php");
        $this->model = new Model();
    }

	//szép url vizsgálata
    private function parseSiteNames() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $fullUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $subPath = str_replace(BASE_URL, "", $fullUrl);

        $cleanPath = explode('?', $subPath)[0];

        $parts = explode('/', trim($cleanPath, '/'));

        if (empty($parts[0])) {
            return [''];
        }

        return $parts;
    }   

	//weboldal url részek
    public function getUrlParts() {
        return $this->urlParts;
    }

    //publikus menüpontok lekérdezése
    public function getPublicMenu() {
        return $this->model->getPublicMenu();
    }

    //Űrlapfeldolgozások vezérlése
    public function runAction($page) {

        //CSRF ellenőrzés
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkCsrfToken($_POST['csrf_token'] ?? '');
        }

        switch ($page) {
            case 'register-process':
                $this->handleRegistration();
                break;
            case 'login-process':
                $this->handleLogin();
                break;
            case 'message-process':
                $this->handleMessage();
                break;
            case 'kilepes':
                $this->logout();
                break;
            case 'kep-feltoltes':
                $this->handleImageUpload();
                break;
            case 'bejegyzes-mentes':
                $this->handlePostSave();
                break;
            case 'bejegyzes-torles':
                $this->handlePostDelete();
                break;
            case 'iras-mentes':
                $this->handleWritingSave();
                break;
            case 'iras-torles':
                $this->handleWritingDelete();
                break;
            case 'galeria-feltoltes':
                $this->handleGalleryUpload();
                break;
            case 'galeria-torles':
                $this->handleGalleryDelete();
                break;
            case 'admin':
                if (isset($this->urlParts[1]) && $this->urlParts[1] === 'uzenet-torles') {
                    if (!$this->isLoggedIn()) {
                        header("Location: " . BASE_URL . "belepes");
                        exit;
                    }

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $id = $_POST['id'] ?? null;
                        
                        if ($id) {
                            $this->model->deleteMessage($id);
                            $_SESSION['admin_msg'] = "Üzenet sikeresen törölve!";
                        }
                    }
        
                    header("Location: " . BASE_URL . "admin/uzenetek");
                    exit;
                }
                break;
            
        }
    }

    //weboldal title kifejtése
    public function getSiteTitle() {
        $title = "Vaszilij EDC";
        $firstPart = $this->urlParts[0];
        $secondPart = $this->urlParts[1] ?? null;

        $menuItem = $this->model->getMenuItem($firstPart);
        
        if ($menuItem) {
            $title = $menuItem["megjelenitesi_nev"];

            if ($secondPart) {
                $entryId = intval(explode('-', $secondPart)[0]);
                $entry = $this->model->getEntryById($firstPart, $entryId);
                
                if ($entry) {
                    $title .= " - " . ($entry['cim'] ?? $entry['title']);
                }
            }

            $title.= " | Vaszilij EDC";

        }
        return $title;
    }


    //Megfelelő aloldal betöltése
    public function getTemplatePath() {
        $firstPart = $this->urlParts[0] ?: '';
        $secondPart = $this->urlParts[1] ?? null;

        if ($firstPart === 'admin') {
            if (!$this->isLoggedIn()) {
                return "pages/login.php";
            }

            $adminPages = [
                'bejegyzesek' => 'pages/admin/a_blogs.php',
                'bejegyzes-szerkesztes' => 'pages/admin/a_edit_blog.php',
                'iras-szerkesztes' => 'pages/admin/a_edit_writing.php',
                'irasok'      => 'pages/admin/a_writings.php',
                'uzenetek'    => 'pages/admin/a_messages.php',
            ];

            if ($secondPart && isset($adminPages[$secondPart])) {
                return $adminPages[$secondPart];
            }
            
            return "pages/admin/a_blogs.php"; 
        }

        if ($secondPart) {
            $entryId = intval(explode('-', $secondPart)[0]);
            $entry = $this->model->getEntryById($firstPart, $entryId);
            
            if ($entry) {
                if ($firstPart == 'blog') return "pages/blog.php";
                if ($firstPart == 'irasok') return "pages/writing.php";
            }
        }

        $templates = [
            'irasok' => 'writings.php',
            'blog' => 'blogs.php',
            'tamogatas' => 'support.php',
            'uzenetkuldes' => 'message.php',
            'galeria' => 'gallery.php',
            'bolt' => 'shop.php',
            'secret' => 'secret.php',
            'belepes' => 'login.php',
            'regisztracio' => 'register.php',
        ];

        return "pages/" . ($templates[$firstPart] ?? "main.php");
    }

    // Regisztráció lekezelése
    public function handleRegistration() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass = $_POST['password'] ?? '';
        $passConfirm = $_POST['password_confirm'] ?? '';

        // Validáció
        $error = '';
        if (empty($fullname) || empty($email) || empty($pass)) {
            $error = "Minden csillaggal jelölt mező kitöltése kötelező!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Érvénytelen e-mail cím formátum!";
        } elseif ($pass !== $passConfirm) {
            $error = "A két jelszó nem egyezik meg!";
        } elseif (strlen($pass) < 8) {
            $error = "A jelszónak legalább 8 karakternek kell lennie!";
        } elseif ($this->model->emailExists($email)) {
            $error = "Ez az e-mail cím már regisztrálva van!";
        }

        if ($error) {
            $_SESSION['reg_error'] = $error;
            
            $formData = $_POST;
            unset($formData['password'], $formData['password_confirm']);
            $_SESSION['reg_post'] = $formData; 
            
            header("Location: " . BASE_URL . "regisztracio");
            exit;
       }

        // Mentés
        $success = $this->model->registerUser([
            'fullname' => $fullname,
            'email' => $email,
            'password' => $pass
        ]);

        if ($success) {
            $_SESSION['login_msg'] = "Sikeres regisztráció! A belépéshez adminisztrátori aktiválás szükséges.";
            unset($_SESSION['reg_post']);
            header("Location: " . BASE_URL . "belepes");
            exit;
        } else {
            $_SESSION['reg_error'] = "Valami hiba történt. Próbálja újra később!";
            header("Location: " . BASE_URL . "regisztracio");
            exit;
        }
    }

    //Bejelentkezés lekezelése
    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $email = trim($_POST['email'] ?? '');
        $pass = $_POST['password'] ?? '';

        $user = $this->model->getUserByEmail($email);

        // Validáció: létezik, jó a jelszó és aktív?
        if (!$user || !password_verify($pass, $user['jelszo'])) {
            $_SESSION['login_error'] = "Hibás e-mail cím vagy jelszó!";
            header("Location: " . BASE_URL . "belepes");
            exit;
        }

        if ($user['aktiv_statusz'] == 0) {
            $_SESSION['login_error'] = "A fiók még nincs aktiválva!";
            header("Location: " . BASE_URL . "belepes");
            exit;
        }

        // Sikeres belépés: Session adatok és dátum frissítés
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nev'];
        $this->model->updateLastLogin($user['id']);

        header("Location: " . BASE_URL);
        exit;
    }

    //Kijelentkezés
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }

    //Be van jeletkezve?
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    //Üzenetküldés validálása és feldolgozása
    public function handleMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $captcha_input = $_POST['captcha'] ?? '';
        $captcha_expected = $_SESSION['captcha_ans'] ?? '';

        $error = '';
        if (empty($name) || empty($email) || empty($message)) {
            $error = "Minden csillaggal jelölt mezőt ki kell tölteni!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Érvénytelen e-mail cím!";
        } elseif ($captcha_input != $captcha_expected) {
            $error = "Hibás Captcha válasz! Próbáld újra.";
        }

        if ($error) {
            $_SESSION['msg_error'] = $error;
            $_SESSION['msg_post'] = $_POST;
            header("Location: " . BASE_URL . "uzenetkuldes");
            exit;
        }

        if ($this->model->saveMessage(['name' => $name, 'email' => $email, 'message' => $message])) {
            $_SESSION['msg_success'] = "Köszönjük! Az üzenetedet sikeresen rögzítettük.";
            header("Location: " . BASE_URL . "uzenetkuldes");
            exit;
        }
    }

    //CSRF token generálás
    public function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    
    //CSRF token ellenőrzés
    /*
    public function checkCsrfToken($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            die("Biztonsági hiba: Érvénytelen CSRF token!");
        }
        return true;
    }
    */

    public function checkCsrfToken($token) {
    if (empty($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        // Ellenőrizzük, hogy AJAX kérés-e (Summernote feltöltés)
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' || 
            (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Biztonsági hiba: Érvénytelen CSRF token!']);
            exit;
        }
        
        // Sima űrlap esetén maradhat a szigorú leállás
        die("Biztonsági hiba: Érvénytelen CSRF token!");
    }
    return true;
}

    //Képfeltöltés kezelése
    public function handleImageUpload() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$this->isLoggedIn()) {
            echo json_encode(['error' => 'Illetéktelen hozzáférés']);
            exit;
        }

        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $uploadDir = 'pictures/';
            
            // Mappa ellenőrzése
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'post_' . time() . '_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                echo json_encode(['url' => BASE_URL . $targetPath]);
            } else {
                echo json_encode(['error' => 'Sikertelen fájlmozgatás']);
            }
        }
    exit;
    }
    
    //Blogbejegyzés mentése vagy frissítése
    public function handlePostSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->isLoggedIn()) {
            $id = $_POST['post_id'] ?? null;
            $title = trim($_POST['title'] ?? '');
            $content = $_POST['content'] ?? '';

            if (!empty($title) && !empty($content)) {
                if ($id) {
                    // UPDATE ág
                    $success = $this->model->updatePost([
                        'id' => $id,
                        'title' => $title,
                        'content' => $content
                    ]);
                    $msg = "Bejegyzés sikeresen frissítve!";
                } else {
                    // INSERT ág
                    $success = $this->model->savePost([
                        'title' => $title,
                        'content' => $content,
                        'user_id' => $_SESSION['user_id']
                    ]);
                    $msg = "Bejegyzés sikeresen közzétéve!";
                }

                if ($success) {
                    $_SESSION['admin_msg'] = $msg;
                    unset($_SESSION['tmp_post']);
                    header("Location: " . BASE_URL . "admin/bejegyzesek");
                    exit;
                }
            }

            $_SESSION['tmp_post'] = $_POST; 
            $_SESSION['admin_error'] = "Minden mező kitöltése kötelező!";
            
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    //Bejegyzés törlése
    public function handlePostDelete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->isLoggedIn()) {
    
            $id = $_POST['delete_id'] ?? null;
            if ($id && $this->model->deleteBlogPost($id)) {
                $_SESSION['admin_msg'] = "Bejegyzés sikeresen törölve!";
            } else {
                $_SESSION['admin_error'] = "Hiba történt a törlés során!";
            }
            header("Location: " . BASE_URL . "admin/bejegyzesek");
            exit;
        }
    }

    //Írás mentése vagy frissítése
    public function handleWritingSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->isLoggedIn()) {
            $id = $_POST['post_id'] ?? null;
            $title = trim($_POST['title'] ?? '');
            $content = $_POST['content'] ?? '';

            if (!empty($title) && !empty($content)) {
                if ($id) {
                    // UPDATE ág
                    $success = $this->model->updateWriting([
                        'id' => $id,
                        'title' => $title,
                        'content' => $content
                    ]);
                    $msg = "Írás sikeresen frissítve!";
                } else {
                    // INSERT ág
                    $success = $this->model->saveWriting([
                        'title' => $title,
                        'content' => $content,
                        'user_id' => $_SESSION['user_id']
                    ]);
                    $msg = "Írás sikeresen közzétéve!";
                }

                if ($success) {
                    $_SESSION['admin_msg'] = $msg;
                    unset($_SESSION['tmp_post']);
                    header("Location: " . BASE_URL . "admin/irasok");
                    exit;
                }
            }

            $_SESSION['tmp_post'] = $_POST; 
            $_SESSION['admin_error'] = "Minden mező kitöltése kötelező!";
            
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    //Bejegyzés törlése
    public function handleWritingDelete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->isLoggedIn()) {
    
            $id = $_POST['delete_id'] ?? null;
            if ($id && $this->model->deleteWriting($id)) {
                $_SESSION['admin_msg'] = "Írás sikeresen törölve!";
            } else {
                $_SESSION['admin_error'] = "Hiba történt a törlés során!";
            }
            header("Location: " . BASE_URL . "admin/irasok");
            exit;
        }
    }

    //Slug generálás szövegből
    public function createSlug($text) {
        $replace = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ö' => 'o', 'ő' => 'o', 
            'ú' => 'u', 'ü' => 'u', 'ű' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ö' => 'o', 'Ő' => 'o', 
            'Ú' => 'u', 'Ü' => 'u', 'Ű' => 'u'
        ];
        $text = strtr($text, $replace);

        $text = mb_strtolower($text, 'UTF-8');

        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);

        $text = preg_replace('/[\s-]+/', '-', $text);

        return trim($text, '-');
    }

    // Első kép url kinyerése bejegyzés tartalmából
    public function getFirstImageUrl($html) {
        if (preg_match('/<img.+?src=["\'](.+?)["\'].*?>/i', $html, $matches)) {
            return $matches[1];
        }
        return BASE_URL . 'assets/blog_pictures/default_cover.jpg';
    }

    // Rövid leírás a bejegyzésből
    public function getExcerpt($html, $limit = 120) {
        $text = strip_tags($html); 
        if (mb_strlen($text) > $limit) {
            return mb_substr($text, 0, $limit) . '...';
        }
        return $text;
    }

    //Képfeltöltés galériába
    private function handleGalleryUpload() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->isLoggedIn()) {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Érvénytelen biztonsági token (CSRF).");
            }

            $title = $_POST['title'] ?? 'Névtelen kép';
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                    $_SESSION['admin_error'] = "Csak JPG, PNG és WebP formátum engedélyezett!";
                    header("Location: " . BASE_URL . "galeria");
                    exit;
                }

                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newFilename = uniqid('edc_') . '.' . $ext;
                $destination = 'gallery/' . $newFilename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $this->model->saveGalleryImage($title, $newFilename, $_SESSION['user_id']);
                    $_SESSION['admin_msg'] = "Kép sikeresen feltöltve!";
                } else {
                    $_SESSION['admin_error'] = "Hiba történt a fájl mentésekor.";
                }
            }
            header("Location: " . BASE_URL . "galeria");
            exit;
        }
    }

    //Kép törlés galéria
    private function handleGalleryDelete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->isLoggedIn()) {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Érvénytelen biztonsági token (CSRF).");
            }

            $id = $_POST['image_id'] ?? null;
            $image = $this->model->getGalleryImageById($id);

            if ($image) {
                $filePath = 'gallery/' . $image['fajlnev'];
                
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                if ($this->model->deleteGalleryImage($id)) {
                    $_SESSION['admin_msg'] = "Kép sikeresen törölve!";
                } else {
                    $_SESSION['admin_error'] = "Hiba történt az adatbázisból való törléskor.";
                }
            }
            
            header("Location: " . BASE_URL . "galeria");
            exit;
        }
    }

    

}
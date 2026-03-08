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
            case 'admin':
                if (isset($this->urlParts[1]) && $this->urlParts[1] === 'uzenet-torles') {
                    if (!$this->isLoggedIn()) {
                        header("Location: " . BASE_URL . "belepes");
                        exit;
                    }

                    $id = $this->urlParts[2] ?? null;
                    if ($id) {
                        $this->model->deleteMessage($id);
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
                    $title .= " | " . ($entry['cim'] ?? $entry['title']);
                }
            }
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
                'cikkek'      => 'pages/admin/a_writings.php',
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

}
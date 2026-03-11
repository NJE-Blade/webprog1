<?php

include_once("config.php");

class Model {
    private $db;

    // A konstruktor most már maga hozza létre a kapcsolatot a config.php konstansai alapján
    public function __construct() {
        $charset = 'utf8mb4';
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . $charset;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
             $this->db = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
             // Csapatvezetői tipp: Fejlesztés alatt jó a die(), de élesben majd naplózni kell
             die("Adatbázis csatlakozási hiba a Modelben: " . $e->getMessage());
        }
    }

    // Publikus menü lekérdezése
    public function getPublicMenu() {
        try {
            $sql = "SELECT * FROM menuk WHERE admin = 0 ORDER BY id ASC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Menü lekérdezési hiba: " . $e->getMessage());
            return [];
        }
    }

    //Menupont lekérdezése url alapján
    public function getMenuItem($slug = "") {
        if (empty($slug)) return null;

        try {
            $stmt = $this->db->prepare("SELECT * FROM menuk WHERE ekezettelen_nev = ? LIMIT 1");
            $stmt->execute([$slug]); 
            $menu = $stmt->fetch();

            return $menu ? $menu : null;
        } catch (PDOException $e) {
            error_log("Menüpont lekérdezési hiba: " . $e->getMessage());
            return null;
        }
    }

    //írás vagy bejegyzés lekérdezése
    public function getEntryById($table, $id) {
        try {
            $allowedTables = ['irasok', 'blog'];
            if (!in_array($table, $allowedTables)) return null;
            $stmt = $this->db->prepare("SELECT * FROM $table WHERE id = ? LIMIT 1");
            $stmt->execute([intval($id)]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Bejegyzés lekérdezési hiba: " . $e->getMessage());
            return null;
        }
    }
    
    // létezik az email az adatbázisban?
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM felhasznalok WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch() ? true : false;
    }

    //felhasználó letárolása regisztrációkor
    public function registerUser($data) {
        try {
            $sql = "INSERT INTO felhasznalok (nev, email, jelszo, aktiv_statusz, regisztracio_datum) 
                    VALUES (:nev, :email, :jelszo, 0, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nev'    => $data['fullname'],
                ':email'  => $data['email'],
                ':jelszo' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Bejelentkezéshez: Felhasználó lekérése e-mail alapján
    public function getUserByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM felhasznalok WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    // Bejelentkezéshez: Utolsó bejelentkezés dátumának frissítése
    public function updateLastLogin($userId) {
        try {
            $stmt = $this->db->prepare("UPDATE felhasznalok SET utolso_bejel_datum = NOW() WHERE id = ?");
            $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Dátum frissítési hiba: " . $e->getMessage());
        }
    }

    //Beküldött üzenet letárolása
    public function saveMessage($data) {
        try {
            $sql = "INSERT INTO uzenetek (nev, email, uzenet_szovege, bekuldes_ideje) 
                    VALUES (:nev, :email, :uzenet, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nev'    => $data['name'],
                ':email'  => $data['email'],
                ':uzenet' => $data['message']
            ]);
        } catch (PDOException $e) {
            error_log("Üzenet mentési hiba: " . $e->getMessage());
            return false;
        }
    }

    // Beküldött üzenetek lekérdezése
    public function getAllMessages() {
        try {
            $sql = "SELECT * FROM uzenetek ORDER BY bekuldes_ideje DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Üzenetek lekérdezési hiba: " . $e->getMessage());
            return [];
        }
    }

    //Üzenet törlése
    public function deleteMessage($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM uzenetek WHERE id = ?");
            return $stmt->execute([intval($id)]);
        } catch (PDOException $e) {
            error_log("Üzenet törlési hiba: " . $e->getMessage());
            return false;
        }
    }

    //Blogbejegyzés letárolása
    public function savePost($data) {
        try {
            // Az SQL fájlod alapján a tábla 'blog', a mezők 'cim', 'tartalom', 'user_id'
            $sql = "INSERT INTO blog (cim, tartalom, user_id, iras_ideje) 
                    VALUES (:title, :content, :user_id, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':title'   => $data['title'],
                ':content' => $data['content'],
                ':user_id' => $data['user_id']
            ]);
        } catch (PDOException $e) {
            error_log("Blogger mentési hiba: " . $e->getMessage());
            return false;
        }
    }

    //Írás letárolása
    public function saveWriting($data) {
        try {
            // Az SQL fájlod alapján a tábla 'blog', a mezők 'cim', 'tartalom', 'user_id'
            $sql = "INSERT INTO irasok (cim, tartalom, user_id, iras_ideje) 
                    VALUES (:title, :content, :user_id, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':title'   => $data['title'],
                ':content' => $data['content'],
                ':user_id' => $data['user_id']
            ]);
        } catch (PDOException $e) {
            error_log("Blogger mentési hiba: " . $e->getMessage());
            return false;
        }
    }

    // Összes bejegyzés lekérdezése
    public function getAllBlogs() {
        try {
            
            $sql = "SELECT b.*, f.nev as szerzo_neve 
                    FROM blog b 
                    LEFT JOIN felhasznalok f ON b.user_id = f.id 
                    ORDER BY b.iras_ideje DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Blog lekérdezési hiba: " . $e->getMessage());
            return [];
        }
    } 
    
    // Összes írás lekérdezése
    public function getAllWritings() {
        try {
            
            $sql = "SELECT b.*, f.nev as szerzo_neve 
                    FROM irasok b 
                    LEFT JOIN felhasznalok f ON b.user_id = f.id 
                    ORDER BY b.iras_ideje DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Írás lekérdezési hiba: " . $e->getMessage());
            return [];
        }
    }  

    public function updatePost($data) {
        try {
            $sql = "UPDATE blog SET cim = :title, tartalom = :content WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':title'   => $data['title'],
                ':content' => $data['content'],
                ':id'      => $data['id']
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    //Írás frissítése id alapján
    public function updateWriting($data) {
        try {
            $sql = "UPDATE irasok SET cim = :title, tartalom = :content WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':title'   => $data['title'],
                ':content' => $data['content'],
                ':id'      => $data['id']
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    //Bejegyzés lekérése id alaőján szerkesztéshez
    public function getPostById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM blog WHERE id = ?");
            $stmt->execute([intval($id)]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    //Írás lekérése id alaőján szerkesztéshez
    public function getWritingById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM irasok WHERE id = ?");
            $stmt->execute([intval($id)]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    //Bejegyzés törlése
    public function deleteBlogPost($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM blog WHERE id = ?");
            return $stmt->execute([intval($id)]);
        } catch (PDOException $e) {
            error_log("Blog törlési hiba: " . $e->getMessage());
            return false;
        }
    }

    //Írás törlése
    public function deleteWriting($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM irasok WHERE id = ?");
            return $stmt->execute([intval($id)]);
        } catch (PDOException $e) {
            error_log("Blog törlési hiba: " . $e->getMessage());
            return false;
        }
    }

    //Bejegyzés lekérése id alapján public oldalhoz szerző nevével együtt.
    public function getPostWithAuthor($id) {
        try {
            $sql = "SELECT b.*, f.nev as szerzo_neve 
                    FROM blog b 
                    LEFT JOIN felhasznalok f ON b.user_id = f.id 
                    WHERE b.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([intval($id)]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    //Írás lekérése id alapján public oldalhoz szerző nevével együtt.
    public function getWritingWithAuthor($id) {
        try {
            $sql = "SELECT b.*, f.nev as szerzo_neve 
                    FROM irasok b 
                    LEFT JOIN felhasznalok f ON b.user_id = f.id 
                    WHERE b.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([intval($id)]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    //3 legfrissebb blogbejegyzés lekérése
    public function getLatestBlogs($limit = 3) {
        try {
            $sql = "SELECT b.*, f.nev as szerzo_neve 
                    FROM blog b 
                    LEFT JOIN felhasznalok f ON b.user_id = f.id 
                    ORDER BY b.iras_ideje DESC 
                    LIMIT " . intval($limit);
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    //A 3 legfrissebb írás lekérése
    public function getLatestWritings($limit = 3) {
        try {
            $sql = "SELECT i.*, f.nev as szerzo_neve 
                    FROM irasok i 
                    LEFT JOIN felhasznalok f ON i.user_id = f.id 
                    ORDER BY i.iras_ideje DESC 
                    LIMIT " . intval($limit);
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    //Galéria képek lekérése
    public function getGalleryImages() {
        try {
            $sql = "SELECT * FROM kepek ORDER BY feltoltes_ideje DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    //Új kép mentése
    public function saveGalleryImage($title, $filename, $userId) {
        try {
            $sql = "INSERT INTO kepek (elnevezes, fajlnev, user_id) VALUES (?, ?, ?)";
            return $this->db->prepare($sql)->execute([$title, $filename, $userId]);
        } catch (PDOException $e) {
            return false;
        }
    }

    //Kép lekérése id alapján
    public function getGalleryImageById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM kepek WHERE id = ?");
            $stmt->execute([intval($id)]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    //Kép törlése
    public function deleteGalleryImage($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM kepek WHERE id = ?");
            return $stmt->execute([intval($id)]);
        } catch (PDOException $e) {
            return false;
        }
    }

    //4 legfrissebb kép főoldali carousel-hez
    public function getLatestGalleryImages($limit = 4) {
        try {
            $sql = "SELECT * FROM kepek ORDER BY feltoltes_ideje DESC LIMIT " . intval($limit);
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

}
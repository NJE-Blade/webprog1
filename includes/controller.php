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

        // Eltávolítjuk a BASE_URL-t
        $subPath = str_replace(BASE_URL, "", $fullUrl);

        // Levágjuk a GET paramétereket (?id=1 stb.)
        $cleanPath = explode('?', $subPath)[0];

        // Részekre bontjuk és eltávolítjuk a felesleges perjeleket
        $parts = explode('/', trim($cleanPath, '/'));

        // Ha az első elem üres (főoldal)
        if (empty($parts[0])) {
            return [''];
        }

        return $parts;
    }   

	//weboldal url részek
    public function getUrlParts() {
        return $this->urlParts;
    }

    //TODO
	//bejelentkezés vizsgálata
    public function isLoggedIn() {
        
    }

    public function getPublicMenu() {
        return $this->model->getPublicMenu();
    }

}
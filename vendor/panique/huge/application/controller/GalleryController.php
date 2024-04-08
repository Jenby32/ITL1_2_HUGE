<?php

class GalleryController extends Controller {

    public function __construct() {
        parent::__construct();
    }
    /**
     * This method controls what happens when you move to /note/index in your app.
     * Gets all notes (of the user).
     */
    public function index()
    {
        $this->View->render('gallery/index', array());
    }

    public function saveFile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $file = $_FILES['myfile'];
            $targetDirectory = "../galFolder/";
            $targetFile = $targetDirectory . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                echo "Die Datei " . htmlspecialchars(basename($file['name'])) . " wurde erfolgreich hochgeladen.";
                $this->View->render('gallery/index', array());
            } else {
                $this->View->render('gallery/index', array());
                echo "Es gab einen Fehler beim Hochladen der Datei.";
            }
            
        }
    }
}
<?php

class GalleryModel {
    public static function savePicture() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $file = $_FILES['myfile'];
            $targetDirectory = "../galFolder/";
            $targetFile = $targetDirectory . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                echo "Die Datei " . htmlspecialchars(basename($file['name'])) . " wurde erfolgreich hochgeladen.";
            } else {
                echo "Es gab einen Fehler beim Hochladen der Datei.";
            }
            
        }
    }

    public static function showPictures() {
        $filepath = '../galFolder/Titelbild.jpg';
        $imgs = readfile($filepath);
        return $imgs;
    }
}

?>
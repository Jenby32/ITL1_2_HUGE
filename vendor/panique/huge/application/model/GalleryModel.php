<?php

class GalleryModel {
    public static function savePicture() {
        $database = DatabaseFactory::getFactory()->getConnection();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $file = $_FILES['myfile'];
            $targetDirectory = "../galFolder/";
            $targetFile = $targetDirectory . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                echo "Die Datei " . htmlspecialchars(basename($file['name'])) . " wurde erfolgreich hochgeladen.";
                $pathToPicture = basename($file['name']);
                $userIdOwner = Session::get("user_id");
                $sql = "INSERT INTO gallery (path_to_picture, user_id_owner) VALUES (:path_to_picture, :user_id_owner)";
                $stmt = $database->prepare($sql);
                $stmt->execute(array(":path_to_picture" => $pathToPicture, ":user_id_owner" => $userIdOwner));
            } else {
                echo "Es gab einen Fehler beim Hochladen der Datei.";
            }
            
        }
    }

    public static function getPictures() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT path_to_picture FROM gallery WHERE user_id_owner = :user_id_owner;";
        $stmt = $database->prepare($sql);
        $stmt->execute(array(":user_id_owner" => Session::get("user_id")));

        $imgs = $stmt->fetchAll();
        
        return $imgs;
    }

    public static function loadPicture($imageName) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT path_to_picture FROM gallery WHERE user_id_owner = :user_id_owner AND path_to_picture = :pathToPicture;";
        $stmt = $database->prepare($sql);
        $stmt->execute(array(":user_id_owner" => Session::get("user_id"), ":pathToPicture" => $imageName));
        $img = $stmt->fetch();
        return $img;
    }

    public static function showImage($pictureName) {
        $img = GalleryModel::loadPicture($pictureName);
        header('Content-Type: image/jpeg');
        readfile(Config::get("PATH_TEST")."/".$img->path_to_picture);
    }
}

?>
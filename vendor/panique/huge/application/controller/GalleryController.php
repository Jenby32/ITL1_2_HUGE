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
        // $imgs = readfile(GalleryModel::showPictures());
        // echo var_dump($imgs);
        
        $this->View->render('gallery/index', array("images" => GalleryModel::getPictures()));
    }

    public function saveFile() {
        GalleryModel::savePicture();
        $this->View->render('gallery/index', array());
    }

    public function showFiles($imagePath) {
        GalleryModel::showImage($imagePath);
    }
}
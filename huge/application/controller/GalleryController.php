<?php

//namespace controller;
//
//use Auth;
//use Controller;
//use model\GalleryModel;
//use Redirect;
//use Session;

/**
 * Controller für user-spezifische Galerie: Upload, Anzeige, und gesichertes Ausliefern.
 */
class GalleryController extends Controller
{
    // User-Galerie-Ansicht
    public function index()
    {
        Auth::checkAuthentication();
        $userId = Session::get('user_id');
        $images = GalleryModel::getUserPictures($userId);
        require APP . 'view/gallery/index.php';
    }

    // Upload-Form anzeigen
    public function upload()
    {
        Auth::checkAuthentication();
        require APP . 'view/gallery/upload.php';
    }

    // Upload-Verarbeitung
    public function upload_action()
    {
        Auth::checkAuthentication();
        $userId = Session::get('user_id');
        if (GalleryModel::uploadPicture($userId)) {
            Session::add('feedback_positive', 'Bild erfolgreich hochgeladen.');
        } else {
            Session::add('feedback_negative', 'Bild-Upload fehlgeschlagen!');
        }
        Redirect::to('gallery/index');
    }

    // Bild sicher ausliefern (keine direkte URL)
    public function serve($image = null)
    {
        Auth::checkAuthentication();
        $userId = Session::get('user_id');
        if (!$image) exit('Bild fehlt.');
        $allowed = GalleryModel::getUserPictures($userId);
        if (!in_array($image, $allowed)) exit('Kein Zugriff.');
        $folder = GalleryModel::getUserPictureFolder($userId);
        $filename = $folder . '/' . basename($image);
        if (!file_exists($filename)) exit('Datei nicht gefunden.');
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        header('Content-Type: ' . finfo_file($finfo, $filename));
        readfile($filename);
        exit;
    }
}

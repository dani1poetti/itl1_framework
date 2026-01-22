<?php

//namespace model;
/**
 * Model für user-spezifische Bildergalerie, Upload und Abruf
 */
class GalleryModel
{
    /**
     * Liefert alle Bild-Dateinamen eines Users
     */
    public static function getUserPictures($userId)
    {
        $folder = GalleryModel::getUserPictureFolder($userId);
        if (!is_dir($folder)) {
            return [];
        }
        $files = glob($folder . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        return array_map('basename', $files);
    }

    /**
     * Liefert den Ordnerpfad für die Bilder eines Users
     */
    public static function getUserPictureFolder($userId)
    {
        return dirname(__DIR__, 2) . '/_pictures/userpictures/' . (int)$userId;
    }

    /**
     * Bild hochladen (Single Upload)
     * @param int $userId
     */
    public static function uploadPicture($userId)
    {
        if (!isset($_FILES['gallery_file']) || $_FILES['gallery_file']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        $folder = self::getUserPictureFolder($userId);
        if (!is_dir($folder)) {
            mkdir($folder, 0700, true);
        }
        $info = getimagesize($_FILES['gallery_file']['tmp_name']);
        if (!$info || !in_array($info['mime'], ['image/jpeg', 'image/gif', 'image/png'])) {
            return false;
        }
        $ending = ($info['mime'] == 'image/png' ? '.png' : ($info['mime'] == 'image/gif' ? '.gif' : '.jpg'));
        $filename = uniqid('img_', true) . $ending;
        $destination = $folder . '/' . $filename;
        if (move_uploaded_file($_FILES['gallery_file']['tmp_name'], $destination)) {
            return true;
        }
        return false;
    }
}

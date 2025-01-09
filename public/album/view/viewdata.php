<?php 
    include_once("../../../config/config.php");

    class AlbumController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }
        
        public function getAlbumData($id) {
            $result = mysqli_query($this->kon, "SELECT * FROM album WHERE albumID = '$id'");
            return mysqli_fetch_array($result);
        }
    }

    $albumController = new AlbumController($kon);
    $id = $_GET['id'];
    $fotoData = $albumController->getAlbumData($id);

    if ($fotoData) {
        $id = $fotoData['albumID'];
        $namaAlbum = $fotoData['namaAlbum'];
        $deskripsi = $fotoData['deskripsi'];
        $tanggalDibuat = $fotoData['tanggalDibuat'];
        $userID = $fotoData['userID'];
    }
?>
<?php 
    include_once("../../../config/config.php");

    class FotoController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }
        
        public function getFotoData($id) {
            $result = mysqli_query($this->kon, "SELECT * FROM foto WHERE fotoID = '$id'");
            return mysqli_fetch_array($result);
        }
    }

    $fotoController = new FotoController($kon);
    $id = $_GET['id'];
    $fotoData = $fotoController->getFotoData($id);

    if ($fotoData) {
        $id = $fotoData['fotoID'];
        $judulFoto = $fotoData['judulFoto'];
        $deskripsiFoto = $fotoData['deskripsiFoto'];
        $tanggalUnggah = $fotoData['tanggalUnggah'];
        $albumID = $fotoData['albumID'];
        $userID = $fotoData['userID'];
        $lokasiFile = $fotoData['lokasiFile'];
    }
?>
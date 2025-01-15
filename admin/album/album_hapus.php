<?php 
    include_once("../../config/config.php");

    class AlbumController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }
        
        public function deleteAlbum($albumID) {
            $fotoQuery = mysqli_query($this->kon, "SELECT lokasiFile FROM foto WHERE albumID = '$albumID'");
            $gambar_dir = "../../img/";

            while ($fotoRow = mysqli_fetch_assoc($fotoQuery)) {
                $lokasiFile = $fotoRow['lokasiFile'];
                if ($lokasiFile && file_exists($gambar_dir . $lokasiFile)) {
                    unlink($gambar_dir . $lokasiFile);
                }
            }

            $deleteFoto = mysqli_query($this->kon, "DELETE FROM foto WHERE albumID = '$albumID'");

            $deleteAlbum = mysqli_query($this->kon, "DELETE FROM album WHERE albumID = '$albumID'");

            if ($deleteFoto && $deleteAlbum) {
                return "Album dan semua foto berhasil dihapus.";
            } else {
                return "Gagal menghapus album atau foto.";
            }
        }
    }

    $albumController = new AlbumController($kon);

    if (isset($_GET['id'])) {
        $albumID = $_GET['id'];
        $message = $albumController->deleteAlbum($albumID);

        echo "<script>alert('$message'); window.location.href='dashboard.php';</script>";
    }
?>

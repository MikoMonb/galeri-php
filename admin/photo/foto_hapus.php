<?php 
    include_once("../../config/config.php");

    class FotoController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }
        
        public function deleteFoto($id) {
            $result = mysqli_query($this->kon, "SELECT lokasiFile FROM foto WHERE fotoID = '$id'");
            $row = mysqli_fetch_assoc($result);
            $lokasiFile = $row['lokasiFile'];

            mysqli_query($this->kon, "DELETE FROM likefoto WHERE fotoID = '$id'");
            mysqli_query($this->kon, "DELETE FROM komentarfoto WHERE fotoID = '$id'");

            $deletedata = mysqli_query($this->kon, "DELETE FROM foto WHERE fotoID = '$id'");

            if ($deletedata) {
                $gambar_dir = "../../img/";

                if ($lokasiFile && file_exists($gambar_dir . $lokasiFile)) {
                    unlink($gambar_dir . $lokasiFile);
                }
                return "Data sukses terhapus.";
            } else {
                return "Data gagal terhapus.";
            }
        }
    }

    $fotoController = new FotoController($kon);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $message = $fotoController->deleteFoto($id);
        echo $message;
        header("Location: ../dashboard.php");
    }
?>
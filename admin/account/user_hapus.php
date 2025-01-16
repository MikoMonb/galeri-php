<?php 
    include_once("../../config/config.php");

    class UserController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }

        public function deleteUser($userID) {
            $fotoQuery = mysqli_query($this->kon, "SELECT lokasiFile FROM foto WHERE userID = '$userID'");
            $gambar_dir = "../../img/";

            while ($fotoRow = mysqli_fetch_assoc($fotoQuery)) {
                $lokasiFile = $fotoRow['lokasiFile'];
                if ($lokasiFile && file_exists($gambar_dir . $lokasiFile)) {
                    unlink($gambar_dir . $lokasiFile);
                }
            }

            $deleteFoto = mysqli_query($this->kon, "DELETE FROM foto WHERE userID = '$userID'");

            $deleteAlbum = mysqli_query($this->kon, "DELETE FROM album WHERE userID = '$userID'");

            $deleteUser = mysqli_query($this->kon, "DELETE FROM user WHERE userID = '$userID'");

            if ($deleteFoto && $deleteAlbum && $deleteUser) {
                return "Data sukses terhapus.";
            } else {
                return "Data gagal terhapus.";
            }
        }
    }

    $userController = new UserController($kon);
    
    if (isset($_GET['id'])) {
        $userID = $_GET['id'];
        $message = $userController->deleteUser($userID);
        echo "<script>alert('$message'); window.location.href='dashboard.php';</script>";
    }
?>
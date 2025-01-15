<?php 
    include_once("../../../config/config.php");

    class AlbumController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }

        public function updateAlbum($id, $namaAlbum, $deskripsi, $tanggalDibuat, $userID) {
            $result = mysqli_query($this->kon, "UPDATE album SET namaAlbum = '$namaAlbum', deskripsi = '$deskripsi', tanggalDibuat = '$tanggalDibuat', userID = '$userID' WHERE AlbumID = '$id'");
        
            if ($result) {
                header("Location: ../dashboard.php");
            } else {
                return "gagal meng-update data.";
            }
        }

        public function getDataAlbum($id) {
            $sql = "SELECT * FROM album WHERE albumID = '$id'";
            $ambildata = $this->kon->query($sql);

            if ($result = mysqli_fetch_array($ambildata)) {
                return $result;
            } else {
                return null;
            }
        }
    }
?>
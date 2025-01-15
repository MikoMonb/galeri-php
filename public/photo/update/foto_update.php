<?php 
    include_once("../../../config/config.php");

    class FotoController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }

        public function updateFoto($id, $judulFoto, $deskripsiFoto, $tanggalUnggah, $albumID) {
            $result = mysqli_query($this->kon, "UPDATE foto SET judulFoto = '$judulFoto', deskripsiFoto = '$deskripsiFoto', tanggalUnggah = '$tanggalUnggah', albumID = '$albumID' WHERE fotoID = '$id'");
        
            if ($result) {
                header("Location: ../view/view.php?id=$id");
            } else {
                return "gagal meng-update data.";
            }
        }

        public function getDataFoto($id) {
            $sql = "SELECT * FROM foto WHERE fotoID = '$id'";
            $ambildata = $this->kon->query($sql);

            if ($result = mysqli_fetch_array($ambildata)) {
                return $result;
            } else {
                return null;
            }
        }
    }
?>
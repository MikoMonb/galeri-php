<?php 
    include_once("../../../config/config.php");

    class AlbumController {
        private $kon;

        public function __construct($connection){
            $this->kon = $connection;
        }

        public function tambahAlbum() {
            $setAuto = mysqli_query($this->kon, "SELECT MAX(albumID) AS max_id FROM album");
            $result = mysqli_fetch_assoc($setAuto);
            $max_id = $result['max_id'];

            if (is_numeric($max_id)) {
                $nounik = $max_id + 1;
            } else {
                $nounik = 1;
            } return $nounik;
        }

        public function tambahDataAlbum($data) {
            $id = $data['albumID'];
            $namaAlbum = $data['namaAlbum'];
            $deskripsi = $data['deskripsi'];
            $tanggalDibuat = $data['tanggalDibuat'];
            $userID = $data['userID'];

            $insertData = mysqli_query($this->kon, "INSERT INTO album(albumID, namaAlbum, deskripsi, tanggalDibuat, userID)
                                                    VALUES ('$id', '$namaAlbum', '$deskripsi', '$tanggalDibuat', '$userID')");

            if ($insertData) {
                return "Data berhasil disimpan.";
            } else {
                return "Gagal menyimpan data.";
            }
        }
    }
?>
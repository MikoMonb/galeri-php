<?php 
    include_once('../../../config/config.php');

    class FotoController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }

        public function TambahFoto() {
            $setAuto = mysqli_query($this->kon, "SELECT MAX(fotoID) AS max_id FROM foto");
            $result = mysqli_fetch_assoc($setAuto);
            $max_id = $result['max_id'];

            if (is_numeric($max_id)) {
                $nounik = $max_id + 1;
            } else {
                $nounik = 1;;
            } return $nounik;
        }

        public function tambahDataFoto($data) {
            $id = $data['fotoID'];
            $judulFoto = $data['judulFoto'];
            $deskripsiFoto = $data['deskripsiFoto'];
            $tanggalUnggah = $data['tanggalUnggah'];
            $albumID = $data['albumID'];
            $userID = $data['userID'];

            $ekstensi_diperbolehkan = array('jpeg', 'jpg', 'png');
            $namagambar = $_FILES['lokasiFile']['name'];
            $x = explode('.', $namagambar);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['lokasiFile']['size'];
            $file_temp = $_FILES['lokasiFile']['tmp_name'];

            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if ($ukuran <= 2000000) {
                    move_uploaded_file($file_temp, '../../../img/' . $namagambar);
                    $insertData = mysqli_query($this->kon, "INSERT INTO foto(fotoID, judulFoto, deskripsiFoto, tanggalUnggah, lokasiFile, albumID, userID)
                                                            VALUES ('$id', '$judulFoto', '$deskripsiFoto', '$tanggalUnggah', '$namagambar', '$albumID', '$userID')");

                    if ($insertData) {
                        return "Data berhasil disimpan.";
                    } else {
                        return "Gagal menyimpan data.";
                    }
                } else {
                    echo "<div style='color: red'>
                            Ukuran file terlalu besar! Silahkan pilih file yang lebih kecil!    
                        </div>";
                }
            } else {
                echo "<div style='color: red'>
                            Ekstensi file yang di upload tidak diizinkan!   
                        </div>";
            }
        }
    }
?>
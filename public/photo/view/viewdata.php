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

        public function getKomentarFoto($fotoID) {
            $sql = "SELECT k.isiKomentar, k.tanggalKomentar, u.username 
                    FROM komentarfoto k 
                    JOIN user u ON k.userID = u.userID 
                    WHERE k.fotoID = ?";
            $stmt = $this->kon->prepare($sql);
            $stmt->bind_param("i", $fotoID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
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
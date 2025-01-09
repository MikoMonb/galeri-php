<?php 
    include_once("../../config/config.php");

    class RegisterController {
        private $kon;

        public function __construct($connection){
            $this->kon = $connection;
        }

        public function tambahAccount() {
            $setAuto = mysqli_query($this->kon, "SELECT MAX(userID) AS max_id FROM user");
            $result = mysqli_fetch_assoc($setAuto);
            $max_id = $result['max_id'];

            if (is_numeric($max_id)) {
                $nounik = $max_id + 1;
            } else {
                $nounik = 1;
            } return $nounik;
        }

        public function tambahDataAccount($data) {
            $id = $data['userID'];
            $username = $data['username'];
            $password = $data['password'];
            $email = $data['email'];
            $alamat = $data['alamat'];

            $insertData = mysqli_query($this->kon, "INSERT INTO user(userID, username, password, email, alamat)
                                                    VALUES ('$id', '$username', '$password', '$email', '$alamat')");

            if ($insertData) {
                return "Data berhasil disimpan.";
            } else {
                return "Gagal menyimpan data.";
            }
        }
    }
?>
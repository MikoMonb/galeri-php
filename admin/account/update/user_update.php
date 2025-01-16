<?php 
    include_once("../../../config/config.php");

    class UserController {
        private $kon;

        public function __construct($connection) {
            $this->kon = $connection;
        }

        public function updateUser($id, $username, $email, $alamat) {
            $result = mysqli_query($this->kon, "UPDATE user SET username = '$username', email = '$email', alamat = '$alamat' WHERE UserID = '$id'");
        
            if ($result) {
                header("Location: ../dashboard.php");
            } else {
                return "gagal meng-update data.";
            }
        }

        public function getDataUser($id) {
            $sql = "SELECT * FROM user WHERE userID = '$id'";
            $ambildata = $this->kon->query($sql);

            if ($result = mysqli_fetch_array($ambildata)) {
                return $result;
            } else {
                return null;
            }
        }
    }
?>
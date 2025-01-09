<?php 
    include_once('../../config/config.php');
    include_once('akun_tambah.php');

    $akunController = new RegisterController($kon);

    if (isset($_POST['submit'])) {
        $id = $akunController->tambahAccount();

        $data = [
            'userID' => $id,
            'username' => $_POST['username'],    
            'password' => $_POST['password'],
            'email' => $_POST['email'],
            'alamat' => $_POST['alamat'],
        ];

        $message = $akunController->tambahDataAccount($data);

        header("Location: ../../login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.querySelector(".menu-toggle");
            const navbar = document.querySelector(".navbar");

            toggleButton.addEventListener("click", function () {
                navbar.classList.toggle("show");
            });
        });
    </script>
</head>
<body class="login">
    <header class="header">
        <a href="../../dashboard.php" class="logo">Photo <span>Gallery</span></a>
        <button class="menu-toggle">☰</button>

        <nav class="navbar">
            <a href="../../dashboard.php">Home</a>
            <a href="../photo/tambah/tambah.php">Upload</a>
            <a href="../album/dashboard.php">Album</a>
            <a href="../../login.php">Login</a>
        </nav>
    </header>
    <div class="login-container">
        <form action="register.php" method="post" class="login-form">
            <h2>Create Account</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="text" name="alamat" placeholder="Alamat" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="submit" value="Register">
            <p class="register"><a href="../../login.php">Already have an account?</a></p>
        </form>
    </div>
</body>
</html>
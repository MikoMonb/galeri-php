<?php 
include_once('../../../config/config.php');
include_once('viewdata.php');

$albumController = new AlbumController($kon);

session_start();

if (!isset($_SESSION["userID"])) {
    header("Location: ../../login.php");
    exit();
}

$userID = $_SESSION["userID"]; 

$sqlAlbum = "SELECT * FROM album WHERE albumID = '$id'";
$resultAlbum = $kon->query($sqlAlbum);

$sqlFoto = "SELECT fotoID, lokasiFile FROM foto WHERE albumID = '$id'";
$resultFoto = $kon->query($sqlFoto);

$logStatus = isset($_SESSION["userID"]) ? true : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../../css/style.css">
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
<body>
    <header class="header">
        <a href="../../../dashboard.php" class="logo">Photo <span>Gallery</span></a>
        <button class="menu-toggle">☰</button>
        <nav class="navbar">
            <a href="../../../dashboard.php">Home</a>
            <a href="../../photo/tambah/tambah.php">Upload</a>
            <a href="../dashboard.php">Album</a>
            <?php if ($logStatus === true): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <div class="box">
            <div class="dream" id="dream1"></div>
            <div class="dream" id="dream2"></div>
            <div class="dream" id="dream3"></div>

            <?php
            $counter = 0;
            if ($resultFoto->num_rows > 0) {
                while ($row = $resultFoto->fetch_assoc()) {

                    $image = $row['lokasiFile'];
                    $imagePath = "../../../img/" . htmlspecialchars($image);
                    $imageId = "image" . $counter;

                    $targetDream = $counter % 3 === 0 ? "dream1" : ($counter % 3 === 1 ? "dream2" : "dream3");

                    echo "<script>
                        document.getElementById('$targetDream').innerHTML += 
                        '<img src=\"" . $imagePath . "\" alt=\"Foto\" id=\"" . $imageId . "\" class=\"clickable\" onclick=\"window.location.href=\'../../photo/view/view.php?id=" . $row['fotoID'] . "\'\">';
                    </script>";

                    $counter++;
                }
            }
            ?>
        </div>
    </div>
</body>
</html>

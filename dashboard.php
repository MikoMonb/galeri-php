<?php 
    include_once('config/config.php');

    if (isset($_GET['cari'])) {
        $cari = $_GET['cari'];
        $sql = "SELECT * FROM foto WHERE fotoID LIKE '%$cari%' OR judulFoto LIKE '%$cari%' OR deskripsiFoto LIKE '%$cari%'";
    } else {
        $sql = "SELECT * FROM foto ORDER BY RAND()";
    }

    $result = $kon->query($sql);
    
    $logStatus = isset($_SESSION["userID"]) ? true : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
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
        <a href="dashboard.php" class="logo">Photo <span>Gallery</span></a>
        <button class="menu-toggle">☰</button>

        <div class="search-container">
            <form action="dashboard.php" method="get">
                <input 
                    type="text" 
                    name="cari" 
                    placeholder="Search..." 
                    class="search-bar"
                    value="<?php echo isset($cari) ? htmlspecialchars($cari) : ''; ?>" 
                />
            </form>
        </div>
        <nav class="navbar">
            <a href="public/photo/tambah/tambah.php">Upload</a>
            <a href="public/album/dashboard.php">Album</a>
            <?php if ($logStatus === true): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
            <a href="admin/dashboard.php">
                <img class="backend-logo" src="asset/backend (1).png" alt="">
            </a>
        </nav>
    </header>

    <div class="container">
        <div class="box">
            <div class="dream" id="dream1"></div>
            <div class="dream" id="dream2"></div>
            <div class="dream" id="dream3"></div>

            <?php
            $counter = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $image = $row['lokasiFile'];
                    $imagePath = "img/" . htmlspecialchars($image);
                    $imageId = "image" . $counter;

                    $targetDream = $counter % 3 === 0 ? "dream1" : ($counter % 3 === 1 ? "dream2" : "dream3");

                    echo "<script>
                        document.getElementById('$targetDream').innerHTML += 
                        '<img src=\"" . $imagePath . "\" alt=\"Foto\" id=\"" . $imageId . "\" class=\"clickable\" onclick=\"window.location.href=\'public/photo/view/view.php?id=" . $row['fotoID'] . "\'\">';
                    </script>";

                    $counter++;
                }
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php 
    include_once("../../config/config.php");

    session_start();

    if (!isset($_SESSION["userID"])) {
        header("Location: ../../login.php");
        exit();
    }

    $sql = "SELECT * FROM user";
    $result = $kon->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Albums</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.querySelector(".menu-toggle");
            const navbar = document.querySelector(".navbar");

            toggleButton.addEventListener("click", function () {
                navbar.classList.toggle("show");
            });
        });
        
        function confirmDeletion(event, id) {
            const isConfirmed = confirm("Are you sure you want to delete this photo? This action cannot be undone.");
            if (!isConfirmed) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <header class="header">
        <a href="../dashboard.php" class="logo">Admin Monitor</a>
        <button class="menu-toggle">☰</button>

        <nav class="navbar">
            <a href="../dashboard.php">Home</a>
            <a href="../album/dashboard.php">Album</a>
            <a href="../../logout.php">Logout</a>
        </nav>
    </header>

    <div class="album">
        <h1 class="album-title">All Users</h1>
        <div class="album-list">
            <?php 
            while($row = $result->fetch_assoc()) :
                $userID = $row['userID'];
                $username = $row['username'];
                $email = $row['email'];
                $alamat = $row['alamat'];

                $fotoSql = "SELECT lokasiFile FROM foto WHERE userID = '$userID' ORDER BY RAND() LIMIT 1";
                $fotoResult = $kon->query($fotoSql);
                $coverFoto = $fotoResult->fetch_assoc();
                $coverFoto = $coverFoto ? $coverFoto['lokasiFile'] : 'user.jpg';
            ?>
            <div class="album-item">
                <a href="view/view_album.php?id=<?php echo $albumID; ?>">
                    <img src="../../img/<?php echo $coverFoto; ?>" alt="Cover of <?php echo $username; ?>" class="album-cover">
                    <div class="album-info">
                        <h2><?php echo $username; ?></h2>
                        <p><strong>Uploader ID:</strong> <?php echo $userID; ?></p>
                        <p><strong>Email:</strong> <?php echo $email; ?></p>
                        <p><strong>Alamat:</strong> <?php echo $alamat; ?></p>

                        <div class="album-actions">
                            <a href="update/update.php?id=<?php echo $userID; ?>" class="album-btn album-btn-update">Update</a>
                            <a href="user_hapus.php?id=<?php echo $userID; ?>" 
                                class="album-btn album-btn-delete"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Delete</a>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php 
    include_once("../../config/config.php");

    session_start();

    if (!isset($_SESSION["userID"])) {
        header("Location: ../../login.php");
        exit();
    }

    $sql = "SELECT * FROM album";
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
            <a href="../account/dashboard.php">Users</a>
            <a href="../../logout.php">Logout</a>
        </nav>
    </header>

    <div class="album">
        <h1 class="album-title">All Albums</h1>
        <div class="album-list">
            <?php 
            while($row = $result->fetch_assoc()) :
                $userID = $row['userID'];
                $usernameSql = "SELECT username FROM user WHERE userID = '$userID'";
                $usernameResult = $kon->query($usernameSql);
                $username = $usernameResult->fetch_assoc()['username'];

                $albumID = $row['albumID'];
                $fotoSql = "SELECT lokasiFile FROM foto WHERE albumID = '$albumID' LIMIT 1";
                $fotoResult = $kon->query($fotoSql);
                $coverFoto = $fotoResult->fetch_assoc();
                $coverFoto = $coverFoto ? $coverFoto['lokasiFile'] : 'default.jpg';
            ?>
            <div class="album-item">
                <a href="view/view_album.php?id=<?php echo $albumID; ?>">
                    <img src="../../img/<?php echo $coverFoto; ?>" alt="Cover of <?php echo $row['albumID']; ?>" class="album-cover">
                        <div class="album-info">
                            <h2><?php echo $row['albumID']; ?></h2>
                            <p><strong>Uploader     :</strong> <?php echo $username; ?></p>
                            <p><strong>Nama Album:</strong> <?php echo $row['namaAlbum']; ?></p>
                            <p><strong>Description:</strong> <?php echo $row['deskripsi']; ?></p>
                            <p><strong>Upload Date:</strong> <?php echo $row['tanggalDibuat']; ?></p>

                            <div class="album-actions">
                                <a href="update/update.php?id=<?php echo $albumID; ?>" class="album-btn album-btn-update">Update</a>
                                <a href="album_hapus.php?id=<?php echo $albumID; ?>" 
                                    class="album-btn album-btn-delete"
                                    onclick="confirmDeletion(event, <?php echo $albumID; ?>)">Delete</a>
                            </div>
                        </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="add-album">
            <a href="tambah/tambah.php" class="add-album-link">Add New Album</a>
        </div>
    </div>
</body>
</html>

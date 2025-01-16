<?php 
    include_once("../../../config/config.php");
    include_once("album_update.php");

    $albumController = new AlbumController($kon);

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $namaAlbum = $_POST['namaAlbum'];
        $deskripsi = $_POST['deskripsi'];
        $tanggalDibuat = $_POST['tanggalDibuat'];
        $userID = $_POST['userID'];

        $message = $albumController->updateAlbum(
            $id,
            htmlspecialchars($namaAlbum),
            htmlspecialchars($deskripsi),
            $tanggalDibuat,
            $userID
        );
        echo $message;

    }

    $id = null;
    $namaAlbum = null;
    $deskripsi = null;
    $tanggalDibuat = null;
    $userID = null;

    if (isset($_GET['id']) && is_numeric($_GET['id']) ) {
        $id = $_GET['id'];
        $result = $albumController->getDataAlbum($id);

        if ($result) {
            $id = $result['albumID'];
            $namaAlbum = $result['namaAlbum'];
            $deskripsi = $result['deskripsi'];
            $tanggalDibuat = $result['tanggalDibuat'];
            $userID = $result['userID'];
        } else {
            echo "Data tidak ditemukan.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Album</title>
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
<body class="upload">
    <header class="header">
        <a href="../../../dashboard.php" class="logo">Admin Monitor</a>
        <button class="menu-toggle">☰</button>

        <nav class="navbar">
            <a href="../../../dashboard.php">Home</a>
            <a href="../../album/dashboard.php">Album</a>
            <a href="../../../logout.php">Logout</a>
        </nav>
    </header>

    <div class="upload-container">
        <h1 class="title">Update Album</h1>
        <form action="update.php" method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label for="namaAlbum" class="form-label">Nama Album:</label>
                <input type="text" name="namaAlbum" id="namaAlbum" value="<?php echo $namaAlbum; ?>" required class="form-input" />
            </div>
            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi Album:</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-input"><?php echo $deskripsi; ?></textarea>
            </div>
            <div class="form-group-row">
                <div class="form-group-column">
                    <label for="tanggalDibuat" class="form-label">Tanggal Unggah:</label>
                    <input type="date" name="tanggalDibuat" id="tanggalDibuat" value="<?php echo $tanggalDibuat; ?>" required readonly class="form-input" />
                </div>
            </div>
            <div class="form-group-row">
                <div class="form-group-column">
                    <label for="id" class="form-label">Album ID:</label>
                    <input type="text" name="id" value="<?php echo $id; ?>" readonly required class="form-input" />
                </div>
                <div class="form-group-column">
                    <label for="userID" class="form-label">User ID:</label>
                    <input type="text" name="userID" id="userID" value="<?php echo $userID ?>" readonly class="form-input" />
                </div>
            </div>
            <div class="button-group">
                <button type="submit" name="update" class="submit-button">
                    Submit
                </button>
            </div>
        </form>
    </div>
</body>
</html>
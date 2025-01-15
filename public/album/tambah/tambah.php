<?php 
    include_once('../../../config/config.php');
    include_once('album_tambah.php');

    session_start();

    if (!isset($_SESSION["userID"])) {
        header("Location: ../../../login.php");
        exit();
    }

    $userID = $_SESSION['userID'];
    $albumController = new AlbumController($kon);

    if (isset($_POST['submit'])) {
        $id = $albumController->tambahAlbum();

        $data = [
            'albumID' => $id,
            'namaAlbum' => $_POST['namaAlbum'],
            'deskripsi' => $_POST['deskripsi'],
            'tanggalDibuat' => $_POST['tanggalDibuat'],
            'userID' => $_POST['userID'],
        ];

        $message = $albumController->tambahDataAlbum($data);

        header("Location: ../../../dashboard.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Foto</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.querySelector(".menu-toggle");
            const navbar = document.querySelector(".navbar");

            toggleButton.addEventListener("click", function () {
                navbar.classList.toggle("show");
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const tanggalInput = document.getElementById('tanggalDibuat');
            const today = new Date().toISOString().split('T')[0]; // Format ke 'YYYY-MM-DD'
            tanggalInput.value = today;
        });
    </script>
</head>
<body class="upload">
    <header class="header">
        <a href="../../../dashboard.php" class="logo">Photo <span>Gallery</span></a>
        <button class="menu-toggle">☰</button>

        <nav class="navbar">
            <a href="../../../dashboard.php">Home</a>
            <a href="../../album/dashboard.php">Album</a>
            <a href="../../../logout.php">Logout</a>
        </nav>
    </header>

    <div class="upload-container">
        <h1 class="title">Tambah Album</h1>
        <form action="tambah.php" method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label for="namaAlbum" class="form-label">Nama Album:</label>
                <input type="text" name="namaAlbum" id="namaAlbum" required class="form-input" />
            </div>
            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi Album:</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-input"></textarea>
            </div>
            <div class="form-group-row">
                <div class="form-group-column">
                    <label for="tanggalDibuat" class="form-label">Tanggal Dibuat:</label>
                    <input type="date" name="tanggalDibuat" id="tanggalDibuat" required readonly class="form-input" />
                </div>
            </div>
            <div class="form-group-row">
                <div class="form-group-column">
                    <label for="albumID" class="form-label">Album ID:</label>
                    <input type="text" name="albumID" id="albumID" value="<?php echo($albumController->tambahAlbum())?>" readonly required class="form-input" />
                </div>
                <div class="form-group-column">
                    <label for="userID" class="form-label">User ID:</label>
                    <input type="text" name="userID" id="userID" value="<?php echo $_SESSION['userID']; ?>" readonly class="form-input" />
                </div>
            </div>
            <div class="button-group">
                <button type="submit" name="submit" class="submit-button">
                    Submit
                </button>
            </div>
        </form>
    </div>
</body>
</html>

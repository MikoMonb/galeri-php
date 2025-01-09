<?php 
    include_once('../../../config/config.php');
    include_once('foto_tambah.php');

    session_start();

    if (!isset($_SESSION["userID"])) {
        header("Location: ../../../login.php");
        exit();
    }

    $userID = $_SESSION['userID'];
    $fotoController = new FotoController($kon);

    if (isset($_POST['submit'])) {
        $id = $fotoController->TambahFoto();

        $data = [
            'fotoID' => $id,
            'judulFoto' => $_POST['judulFoto'],
            'deskripsiFoto' => $_POST['deskripsiFoto'],
            'tanggalUnggah' => $_POST['tanggalUnggah'],
            'albumID' => $_POST['albumID'],
            'userID' => $_POST['userID'],
        ];

        $message = $fotoController->tambahDataFoto($data);

        header("Location: ../../../dashboard.php");
        exit();
    }

    $dataAlbum = mysqli_query($kon, "SELECT * FROM album WHERE userID = '$userID'");
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
        <h1 class="title">Tambah Foto</h1>
        <form action="tambah.php" method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label for="judulFoto" class="form-label">Judul Foto:</label>
                <input type="text" name="judulFoto" id="judulFoto" required class="form-input" />
            </div>
            <div class="form-group">
                <label for="deskripsiFoto" class="form-label">Deskripsi Foto:</label>
                <textarea name="deskripsiFoto" id="deskripsiFoto" rows="4" required class="form-input"></textarea>
            </div>
            <div class="form-group-row">
                <div class="form-group-column">
                    <label for="tanggalUnggah" class="form-label">Tanggal Unggah:</label>
                    <input type="date" name="tanggalUnggah" id="tanggalUnggah" required class="form-input" />
                </div>
                <div class="form-group-column">
                    <label for="lokasiFile" class="form-label">Lokasi File:</label>
                    <input type="file" name="lokasiFile" id="lokasiFile" required class="form-input" />
                </div>
            </div>
            <div class="form-group-row">
                <div class="form-group-column">
                    <label for="albumID" class="form-label">Album:</label>
                    <select name="albumID" id="albumID" required class="form-input">
                        <?php while($row = mysqli_fetch_assoc($dataAlbum)) : ?>
                            <option value="<?php echo $row['albumID']; ?>">
                                <?php echo $row['albumID'] . ' - ' . $row['namaAlbum'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group-column">
                    <label for="fotoID" class="form-label">Foto ID:</label>
                    <input type="text" name="fotoID" id="fotoID" value="<?php echo($fotoController->TambahFoto())?>" readonly required class="form-input" />
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

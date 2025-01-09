<?php 
    include_once("../../../config/config.php");
    include_once("foto_update.php");

    $fotoController = new FotoController($kon);

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $judulFoto = $_POST['judulFoto'];
        $deskripsiFoto = $_POST['deskripsiFoto'];
        $tanggalUnggah = $_POST['tanggalUnggah'];
        $albumID = $_POST['albumID'];
        $userID = $_POST['userID'];

        $message = $fotoController->updateFoto($id, $judulFoto, $deskripsiFoto, $tanggalUnggah, $albumID, $userID);
        echo $message;

    }

    $id = null;
    $judulFoto = null;
    $deskripsiFoto = null;
    $tanggalUnggah = null;
    $albumID = null;
    $userID = null;

    if (isset($_GET['id']) && is_numeric($_GET['id']) ) {
        $id = $_GET['id'];
        $result = $fotoController->getDataFoto($id);

        if ($result) {
            $id = $result['fotoID'];
            $judulFoto = $result['judulFoto'];
            $deskripsiFoto = $result['deskripsiFoto'];
            $tanggalUnggah = $result['tanggalUnggah'];
            $albumID = $result['albumID'];
            $userID = $result['userID'];
        } else {
            echo "Data tidak ditemukan.";
        }
    }

    $dataAlbum = mysqli_query($kon, "SELECT * FROM album WHERE userID = '$userID'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Foto</title>
    <link rel="stylesheet" href="../../../css/style.css">
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
        <h1 class="title">Update Foto</h1>
        <form action="update.php" method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label for="judulFoto" class="form-label">Judul Foto:</label>
                <input type="text" name="judulFoto" id="judulFoto" value="<?php echo $judulFoto; ?>" required class="form-input" />
            </div>
            <div class="form-group">
                <label for="deskripsiFoto" class="form-label">Deskripsi Foto:</label>
                <textarea name="deskripsiFoto" id="deskripsiFoto" rows="4" value="<?php echo $deskripsiFoto; ?>" required class="form-input"></textarea>
            </div>
            <div class="form-group-row">
                <div class="form-group-column">
                    <label for="tanggalUnggah" class="form-label">Tanggal Unggah:</label>
                    <input type="date" name="tanggalUnggah" id="tanggalUnggah" value="<?php echo $tanggalUnggah; ?>" required class="form-input" />
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
                    <label for="id" class="form-label">Foto ID:</label>
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
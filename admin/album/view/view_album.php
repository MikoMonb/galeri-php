<?php 
    include_once("../../../config/config.php");
    include_once("viewdata.php");

    $fotoController = new FotoController($kon);

    $sql = "SELECT username FROM user WHERE userID = '$userID'";
    $result = $kon->query($sql);
    $username = $result->fetch_assoc()['username'];

    $sql = "SELECT namaAlbum FROM album WHERE albumID = '$albumID'";
    $result = $kon->query($sql);
    $album = $result->fetch_assoc()['namaAlbum'];

    $logStatus = isset($_SESSION["userID"]) ? true : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Photo</title>
    <link rel="stylesheet" href="../../../css/style.css"> 
</head>
<body>
    <header class="header">
        <a href="../../../dashboard.php" class="logo">Photo <span>Gallery</span></a>
        <button class="menu-toggle">☰</button>
        <nav class="navbar">
            <a href="../../../dashboard.php">Home</a>
            <a href="../tambah/tambah.php">Upload</a>
            <a href="../../album/dashboard.php">Album</a>
            <?php if ($logStatus === true): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="view">
        <div class="view-container">
            <div class="photo-container">
                <?php if ($fotoData): ?>
                    <img src="../../../img/<?php echo $lokasiFile; ?>" alt="<?php echo $judulFoto; ?>">
                <?php else: ?>
                    <p>Photo not found.</p>
                <?php endif; ?>
            </div>
            <div class="info-container">
                <?php if ($fotoData): ?>
                    <h2><?php echo $judulFoto; ?></h2>
                    <p><strong>Description:</strong> <?php echo $deskripsiFoto; ?></p>
                    <p><strong>Album Name:</strong> <?php echo $album; ?></p>
                    <p><strong>Upload Date:</strong> <?php echo $tanggalUnggah; ?></p>
                    <p><strong>Uploader ID:</strong> <?php echo $username; ?></p>
                <?php else: ?>
                    <p>No details available for this photo.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>

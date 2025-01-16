<?php 
    include_once("../../../config/config.php");
    include_once("viewdata.php");

    session_start();

    $fotoController = new FotoController($kon);

    $loggedInUserID = $_SESSION['userID'] ?? null;

    $sql = "SELECT username FROM user WHERE userID = '$userID'";
    $result = $kon->query($sql);
    $username = $result->fetch_assoc()['username'];

    $sql = "SELECT namaAlbum FROM album WHERE albumID = '$albumID'";
    $result = $kon->query($sql);
    $album = $result->fetch_assoc()['namaAlbum'];

    $sql = "SELECT COUNT(*) AS total_likes FROM likefoto WHERE fotoID = '$id'";
    $result = $kon->query($sql);
    $totalLikes = $result->fetch_assoc()['total_likes'];

    $komentarFoto = $fotoController->getKomentarFoto($id);

    $logStatus = isset($_SESSION["userID"]) ? true : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Photo</title>
    <link rel="stylesheet" href="../../../css/style.css">
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
        <a href="../../../dashboard.php" class="logo">Admin Monitor</a>
        <button class="menu-toggle">☰</button>
        <nav class="navbar">
            <a href="../../../dashboard.php">Home</a>
            <a href="../../account/dashboard.php">Users</a>
            <a href="../../album/dashboard.php">Album</a>
            <?php if ($logStatus === true): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="../../../login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="view">
        <div class="view-container">
            <div class="photo-container">
                <?php if ($fotoData): ?>
                    <img src="../../../img/<?php echo $lokasiFile; ?>" alt="<?php echo $judulFoto; ?>">
                    <button class="love-button" data-fotoid="<?php echo $fotoID; ?>">❤</button>
                <?php else: ?>
                    <p>Photo not found.</p>
                <?php endif; ?>
            </div>
            <div class="info-container">
                <?php if ($fotoData): ?>
                    <h2><?php echo $judulFoto; ?></h2>
                    <p><strong>Description :</strong> <?php echo $deskripsiFoto; ?></p>
                    <p><strong>Album Name :</strong> <?php echo $album; ?></p>
                    <p><strong>Upload Date :</strong> <?php echo $tanggalUnggah; ?></p>
                    <p><strong>Uploader :</strong> <?php echo $username; ?></p>
                    <p><strong>Likes :</strong> <?php echo $totalLikes; ?></p>

                    <div class="action-buttons">
                        <a href="../update/update.php?id=<?php echo $id; ?>" class="update-button">Update Photo</a>
                        <a href="../foto_hapus.php?id=<?php echo $id; ?>" class="delete-button" onclick="confirmDeletion(event, <?php echo $id; ?>)">Delete Photo</a>
                    </div>
                <?php else: ?>
                    <p>No details available for this photo.</p>
                <?php endif; ?>

                <div class="comment-section">
                    <?php if ($logStatus === true): ?>
                        <form action="controller/submit_komentar.php" method="POST" class="comment-form">
                            <input type="hidden" name="fotoID" value="<?php echo $id; ?>">
                            <input type="hidden" name="userID" value="<?php echo $loggedInUserID; ?>">
                            <input type="text" name="isiKomentar" rows="3" placeholder="Buatlah komentar..." required></input>
                            <button type="submit" class="submit-comment">
                                <img src="../../../asset/arrow.png" alt="">
                            </button>
                        </form>
                    <?php else: ?>
                        <p>Please <a href="../../../login.php">log in</a> to comment.</p>
                    <?php endif; ?>
                    <ul>
                        <?php if (!empty($komentarFoto)): ?>
                            <?php foreach ($komentarFoto as $komentar): ?>
                                <li>
                                    <p><strong><?php echo htmlspecialchars($komentar['username']); ?></strong>: <?php echo htmlspecialchars($komentar['isiKomentar']); ?></p>
                                    <p class="text-muted"><?php echo htmlspecialchars($komentar['tanggalKomentar']); ?></p>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No comments yet.</p>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.querySelector(".menu-toggle");
            const navbar = document.querySelector(".navbar");

            toggleButton.addEventListener("click", function () {
                navbar.classList.toggle("show");
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.love-button').forEach(button => {
                button.addEventListener('click', function() {
                    const fotoID = <?php echo json_encode($id) ?>;
                    const userID = <?php echo json_encode($loggedInUserID); ?>;

                    fetch('controller/like.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ fotoID, userID }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Photo liked successfully!');
                        } else {
                            alert('Failed to like photo.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</body>
</html>

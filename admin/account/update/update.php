<?php 
    include_once("../../../config/config.php");
    include_once("user_update.php");

    $userController = new UserController($kon);

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $alamat = $_POST['alamat'];

        $message = $userController->updateUser($id, htmlspecialchars($username), htmlspecialchars($email), htmlspecialchars($alamat));
        echo "<script>alert('$message'); window.location.href='../../../dashboard.php';</script>";
    }

    $id = null;
    $username = null;
    $email = null;
    $alamat = null;

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $result = $userController->getDataUser($id);

        if ($result) {
            $id = $result['userID'];
            $username = $result['username'];
            $email = $result['email'];
            $alamat = $result['alamat'];
        } else {
            echo "<script>alert('Data tidak ditemukan.'); window.location.href='../../../dashboard.php';</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
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
        <h1 class="title">Update User</h1>
        <form action="" method="POST" class="form-container">
            <div class="form-group">
                <label for="username" class="form-label">Nama User:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required class="form-input" />
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required class="form-input" />
            </div>
            <div class="form-group">
                <label for="alamat" class="form-label">Alamat:</label>
                <input type="text" name="alamat" id="alamat" value="<?php echo htmlspecialchars($alamat); ?>" required class="form-input" />
            </div>
            <div class="form-group-row">
                <div class="form-group-column">
                    <label for="id" class="form-label">User ID:</label>
                    <input type="text" name="id" id="id" value="<?php echo $id; ?>" readonly class="form-input" />
                </div>
            </div>
            <div class="button-group">
                <button type="submit" name="update" class="submit-button">Update</button>
            </div>
        </form>
    </div>
</body>
</html>

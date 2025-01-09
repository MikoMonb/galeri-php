<?php 
    session_start();
    include_once("config/config.php");

    if ($kon->connect_error) {
        die("Connection failed: " . $kon->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = $_POST["username"];
		$password = $_POST["password"];

		$sql =  "SELECT userID, username, password FROM user WHERE username = '$username' AND password = '$password'";
		$result = $kon->query($sql);

		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();

			$_SESSION["userID"] = $row["userID"];
			$_SESSION["username"] = $row["username"];

			if ($row["username"] === "admin" && $row["userID"] == 1) {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
		} else {
			echo "Login gagal. Silahkan coba lagi.";
		}
	}

    $kon->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
<body class="login">
    <header class="header">
        <a href="dashboard.php" class="logo">Photo <span>Gallery</span></a>
        <button class="menu-toggle">☰</button>

        <nav class="navbar">
            <a href="dashboard.php">Home</a>
            <a href="public/photo/tambah/tambah.php">Upload</a>
            <a href="public/album/dashboard.php">Album</a>
            <a href="public/account/register.php">Register</a>
        </nav>
    </header>
    <div class="login-container">
        <form action="login.php" method="post" class="login-form">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
            <p class="register"><a href="public/account/register.php">Don't have an account?</a></p>
        </form>
    </div>
</body>
</html>
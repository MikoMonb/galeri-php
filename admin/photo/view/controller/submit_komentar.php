<?php
include_once("../../../../config/config.php");
session_start();

function generateKomentarID($kon) {
    $query = mysqli_query($kon, "SELECT MAX(komentarID) AS max_id FROM komentarfoto");
    $result = mysqli_fetch_assoc($query);
    $max_id = $result['max_id'];

    if (is_numeric($max_id)) {
        return $max_id + 1;
    } else {
        return 1;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $komentarID = generateKomentarID($kon);
    $fotoID = $_POST['fotoID'];
    $userID = $_POST['userID'];
    $isiKomentar = $_POST['isiKomentar'];
    $tanggalKomentar = date('Y-m-d');

    if (!empty($fotoID) && !empty($userID) && !empty($isiKomentar)) {
        $sql = "INSERT INTO komentarfoto (komentarID, fotoID, userID, isiKomentar, tanggalKomentar) VALUES (?, ?, ?, ?, ?)";
        $stmt = $kon->prepare($sql);
        $stmt->bind_param("iiiss", $komentarID, $fotoID, $userID, $isiKomentar, $tanggalKomentar);

        if ($stmt->execute()) {
            header("Location: ../view.php?id=$fotoID");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "All fields are required!";
    }
} else {
    echo "Invalid request method.";
}
?>

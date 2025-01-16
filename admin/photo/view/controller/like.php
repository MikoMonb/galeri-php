<?php
header('Content-Type: application/json');

require_once("../../../../config/config.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['fotoID'], $data['userID'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid input data."
    ]);
    exit;
}

$fotoID = $data['fotoID'];
$userID = $data['userID'];

function generateLikeID($kon) {
    $query = mysqli_query($kon, "SELECT MAX(likeID) AS max_id FROM likefoto");
    $result = mysqli_fetch_assoc($query);
    $max_id = $result['max_id'];

    if (is_numeric($max_id)) {
        return $max_id + 1;
    } else {
        return 1;
    }
}

try {
    $checkQuery = $kon->prepare("SELECT * FROM likefoto WHERE fotoID = ? AND userID = ?");
    $checkQuery->bind_param("ii", $fotoID, $userID);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode([
            "success" => false,
            "message" => "You have already liked this photo."
        ]);
        exit;
    }

    $likeID = generateLikeID($kon);

    $insertQuery = $kon->prepare("INSERT INTO likefoto (likeID, fotoID, userID) VALUES (?, ?, ?)");
    $insertQuery->bind_param("iii", $likeID, $fotoID, $userID);

    if ($insertQuery->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Photo liked successfully."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to like photo."
        ]);
    }

    $insertQuery->close();
    $checkQuery->close();
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>

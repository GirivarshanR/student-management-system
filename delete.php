<?php
include "db.php";

$id = $_GET["id"];

$sql = "DELETE FROM students WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit();
}
else {
    echo "Error deleting student: " . $stmt->error;
}
?>
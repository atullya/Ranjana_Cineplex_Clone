<?php
include('dbconnection.php');

if (isset($_GET['uid'])) {
    $uid = intval($_GET['uid']);
    $query = "DELETE FROM users WHERE uid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $uid);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'User deleted successfully']);
    } else {
        echo json_encode(['message' => 'Failed to delete user']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['message' => 'Invalid request']);
}
?>

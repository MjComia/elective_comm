<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $PersonnelID = $_POST['PersonnelID'];

    // Step 1: Get all ShiftIDs related to this PersonnelID
    $shiftQuery = $conn->prepare("SELECT ShiftID FROM shifts WHERE PersonnelID = ?");
    $shiftQuery->bind_param("i", $PersonnelID);
    $shiftQuery->execute();
    $result = $shiftQuery->get_result();

    // Store all related ShiftIDs
    $shiftIDs = [];
    while ($row = $result->fetch_assoc()) {
        $shiftIDs[] = $row['ShiftID'];
    }
    $shiftQuery->close();

    // Step 2: Delete from incidentsreported and equipmentassigned
    foreach ($shiftIDs as $shiftID) {
        $sql = $conn->prepare("DELETE FROM incidentsreported WHERE ShiftID = ?");
        $sql->bind_param("i", $shiftID);
        $sql->execute();
        $sql->close();

        $sql = $conn->prepare("DELETE FROM equipmentassigned WHERE ShiftID = ?");
        $sql->bind_param("i", $shiftID);
        $sql->execute();
        $sql->close();
    }

    // Step 3: Delete from shifts
    $sql = $conn->prepare("DELETE FROM shifts WHERE PersonnelID = ?");
    $sql->bind_param("i", $PersonnelID);
    $sql->execute();
    $sql->close();

    // Step 4: Delete from securitypersonnel
    $sql = $conn->prepare("DELETE FROM securitypersonnel WHERE PersonnelID = ?");
    $sql->bind_param("i", $PersonnelID);
    $sql->execute();
    $sql->close();

    header("Location: index.php");
    exit;
}

include "footer.php";
?>

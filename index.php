<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
include 'conn.php';

echo "<h1>Welcome to the Medallion Theatre Database</h1>";
echo "<h1>Personnel Records</h1>";
echo "<a href = 'addData.php'>Add</a>";
?>
<?php
include 'header.php';
?>
<?php
$sql = "
SELECT 
  sp.PersonnelID,
  sp.Name,
  s.ShiftID,
  s.Shift,
  s.Location,
  s.EntryTime,
  s.ExitTime,
  ea.Equipment,
  ir.Incident
FROM SecurityPersonnel sp
JOIN Shifts s ON sp.PersonnelID = s.PersonnelID
LEFT JOIN EquipmentAssigned ea ON s.ShiftID = ea.ShiftID
LEFT JOIN IncidentsReported ir ON s.ShiftID = ir.ShiftID
ORDER BY sp.PersonnelID, s.ShiftID
";

$result = $conn->query($sql);

// Start HTML table
echo "<table border='1' cellpadding='5'>";
echo "<tr>
        <th>Personnel ID</th>
        <th>Name</th>
        <th>Shift</th>
        <th>Location</th>
        <th>Entry Time</th>
        <th>Exit Time</th>
        <th>Equipment</th>
        <th>Incident</th>
        <th>Actions</th>
      </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>SEC" . str_pad($row["PersonnelID"], 3, '0', STR_PAD_LEFT) . "</td>";
        echo "<td>" . $row["Name"] . "</td>";
        echo "<td>" . $row["Shift"] . "</td>";
        echo "<td>" . $row["Location"] . "</td>";
        echo "<td>" . $row["EntryTime"] . "</td>";
        echo "<td>" . $row["ExitTime"] . "</td>";
        echo "<td>" . $row["Equipment"] . "</td>";
        echo "<td>" . $row["Incident"] . "</td>";
        echo "<td>
            <form method = 'POST' action = 'editData.php'>
            <input type = 'hidden' name = 'PersonnelID' value = '". $row["PersonnelID"]."'>
            <input type = 'hidden' name = 'Name' value = '".$row["Name"] ."'>
            <input type = 'hidden' name = 'Shift' value = '".$row["Shift"]."'>
            <input type = 'hidden' name = 'Location' value = '".$row["Location"] ."'>
            <input type = 'hidden' name = 'EntryTime' value = '".$row["EntryTime"]."'>
            <input type = 'hidden' name = 'ExitTime' value = '".$row["ExitTime"]."'>
            <input type = 'hidden' name = 'Equipment' value = '".$row["Equipment"]."'>
            <input type = 'hidden' name = 'Incident' value = '".$row["Incident"]."'>
            <input type = 'submit' value = 'EDIT'>
            </form>

            <form method = 'POST' action = 'deleteData.php'>
            <input type = 'hidden' name = 'PersonnelID' value = '". $row["PersonnelID"]."'>
            <input type = 'hidden' name = 'Name' value = '".$row["Name"] ."'>
            <input type = 'hidden' name = 'Shift' value = '".$row["Shift"]."'>
            <input type = 'hidden' name = 'Location' value = '".$row["Location"] ."'>
            <input type = 'hidden' name = 'EntryTime' value = '".$row["EntryTime"]."'>
            <input type = 'hidden' name = 'ExitTime' value = '".$row["ExitTime"]."'>
            <input type = 'hidden' name = 'Equipment' value = '".$row["Equipment"]."'>
            <input type = 'hidden' name = 'Incident' value = '".$row["Incident"]."'>
            <input type = 'submit' value = 'DELETE'>
            </form>
        </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No data found</td></tr>";
}

echo "</table>";
 ?>
<a href="logout.php">Logout</a>
<?php 
include 'footer.php';
?>
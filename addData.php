<?php 
include "conn.php";
?>


<form action="addData.php" method = "POST">
<h1>Add Data</h1>
<label for="name">Name: </label>
<input type = "text" name = "name" id ="name" required><br><br>
<label for = "shift">Shift: </label>
<input type = "text" name = "shift" id = "shift" required><br><br>
<label for = "location">Location: </label>
<input type = "text" name = "location" id = "location" required><br><br>
<label for = "entrytime">Entry Time: </label>
<input type = "time" name = "entrytime" id = "entrytime" required><br><br>
<label for = "exittime">Exit Time: </label>
<input type = "time" name = "exittime" id = "exittime" required><br><br>
<label for = "equipment">Equipment: </label>
<input type = "text" name = "equipment" id = "equipment" required><br><br>
<label for = "incident">Incident: </label>
<input type = "text" name = "incident" id = "incident" required><br><br>
<input type = "submit" value = "add" name = "add">
</form>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
$name = $_POST['name'];
$shift = $_POST['shift'];
$location = $_POST['location'];
$entrytime = $_POST['entrytime'];
$exittime = $_POST['exittime'];
$equipment = $_POST['equipment'];
$incident = $_POST['incident'];

$sql = $conn->prepare("INSERT INTO securitypersonnel (Name) Values(?)");
$sql->bind_param("s", $name);
if($sql->execute()){
    $PersonnelID = $sql->insert_id;
    $sql->close();
    $sql = $conn->prepare("INSERT INTO shifts (PersonnelID, Location, EntryTime, ExitTime)VALUES(?,?,?,?)");
    $sql->bind_param("ssss", $PersonnelID, $location, $entrytime, $exittime);
    if($sql->execute()){
        $ShiftID = $sql->insert_id;
        $sql->close();
        $sql = $conn->prepare("INSERT INTO equipmentassigned (ShiftID, Equipment) VALUES (?,?)");
        $sql->bind_param("is", $ShiftID, $equipment);
        if($sql->execute()){
            $sql->close();
            $sql = $conn->prepare("INSERT INTO incidentsreported (ShiftID, Incident) VALUES (?,?)");
            $sql->bind_param("is", $ShiftID, $incident);
            if($sql->execute()){
                $sql->close();
                header("Location: index.php");
                exit;
        }
    }
}
}
}
include "footer.php";
?>
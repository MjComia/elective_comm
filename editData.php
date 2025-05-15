<?php 
include "conn.php";
?>

<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $shift = $_POST['Shift'];
    $PersonnelID = $_POST['PersonnelID'];
    $Name = $_POST['Name'];
    $Location = $_POST['Location'];
    $EntryTime = $_POST['EntryTime'];
    $ExitTime = $_POST['ExitTime'];
    $Equipment = $_POST['Equipment'];
    $Incident = $_POST['Incident'];
    echo "$shift";
    echo "$PersonnelID";
    echo "$Name";
    echo "$Location";
    echo "$EntryTime";
    echo "$ExitTime";
    echo "$Equipment";
    echo "$Incident";
}

echo "<div>
    <h1>Edit Data</h1>
    <form method = 'POST' action = 'editData.php'>
    <h5>Edit '".$Name."' Data:</h5>
    <input type = 'hidden' name = 'PersonnelID' value = '".$PersonnelID."'
    <label for = 'shift'>Shift:</label>
    <input type = 'text' name = 'shift' id = 'shift'required><br><br>
    <label for = 'location'>Location:</label>
    <input type = 'text' name = 'location' id = 'location' required><br><br>
    <label for = 'entrytime'>Entry Time:</label>
    <input type = 'time' name = 'entrytime' id = 'entrytime' required><br><br>
    <label for = 'exittime'>Exit Time:</label>
    <input type = 'time' name = 'exittime' id = 'exittime' required><br><br>
    <label for = 'equipment'>Equipment:</label>
    <input type = 'text' name = 'equipment' id = 'equipment' required><br><br>
    <label for = 'incident'>Incident:</label>
    <input type = 'text' name = 'incident' id = 'incident' required><br><br>
    <input type = 'submit' value = 'edit' name = 'edit'>
 
    </form>
</div>";



if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])){
    $shift = $_POST['shift'];
    $location = $_POST['location'];
    $entrytime = $_POST['entrytime'];
    $exittime = $_POST['exittime'];
    $equipment = $_POST['equipment'];
    $incident = $_POST['incident'];
    $PersonnelID = $_POST['PersonnelID'];
    $sql = $conn->prepare("UPDATE shifts SET Shift=?, Location=?, EntryTime=?, ExitTime=? WHERE PersonnelID=?");
    $sql->bind_param("ssssi", $shift, $location, $entrytime, $exittime, $PersonnelID);
    if($sql->execute()){
       $sql->close();
       $sql =$conn->prepare("UPDATE equipmentassigned SET Equipment=? WHERE EquipmentID=?");
       $sql->bind_param("si", $equipment, $PersonnelID);
       $sql->execute();
         $sql->close();
         $sql = $conn->prepare("UPDATE incidentsreported SET Incident=? WHERE IncidentID=?");
            $sql->bind_param("si", $incident, $PersonnelID);
            $sql->execute();
            $sql->close();
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
}
?>
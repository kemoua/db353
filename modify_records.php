<?php
$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";

$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['edit_row']))
{
 $row=$_POST['row_id'];
 $actual_cost=$_POST['actual_cost_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];

 $sql = "UPDATE project SET status='$status',start_date='$start_date',actual_cost='$actual_cost' WHERE project_id = '$row'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}

if(isset($_POST['delete_row']))
{
 $row_no=$_POST['row_id'];
 $sql = "DELETE FROM project WHERE project_id = '$row_no'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}

if(isset($_POST['insert_row']))
{
 $project_id=$_POST['project_id_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];
 $status = !empty($status) ? $status : "Analysis";
 $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
 
 $sql = "INSERT INTO project(project_id,status,start_date) VALUES('$project_id','$status',$start_date)";

 if ($conn->query($sql) === TRUE) {
    echo $project_id;
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}
?>
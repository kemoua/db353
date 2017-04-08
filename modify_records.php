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

 $sql = "UPDATE projects SET status='$status',start_date='$start_date',actual_cost='$actual_cost' WHERE project_id = '$row'";

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
 $sql = "DELETE FROM projects WHERE project_id = '$row_no'";

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
 $client_id=$_POST['client_id_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];
 $complete_date=$_POST['complete_date_val'];
 $time_needed=$_POST['time_needed_val'];
 $title=$_POST['title_val'];
 $type=$_POST['type_val'];
 $budget=$_POST['budget_val'];
 $actual_cost=$_POST['actual_cost_val'];

 $status = !empty($status) ? $status : "Analysis";
 $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
 $client_id = !empty($client_id) ? "'$client_id'" : "NULL";
 $complete_date = !empty($complete_date) ? "'$complete_date'" : "NULL";
 $time_needed = !empty($time_needed) ? "'$time_needed'" : "NULL";
 $title = !empty($title) ? "'$title'" : "NULL";
 $type = !empty($type) ? "'$type'" : "NULL";
 $budget = !empty($budget) ? "'$budget'" : "NULL";
 $actual_cost = !empty($actual_cost) ? "'$actual_cost'" : "NULL";

 $sql = "INSERT INTO projects VALUES('$project_id','$client_id','$status','$start_date','$complete_date','$time_needed','$title','$type','$budget','$actual_cost')";

 if ($conn->query($sql) === TRUE) {
 	echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}
?>
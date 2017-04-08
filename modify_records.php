<?php
$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";

$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['edit_project']))
{
 $row=$_POST['row_id'];
 $actual_cost=$_POST['actual_cost_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];
 $budget=$_POST['budget_val'];
 $type=$_POST['type_val'];
 $time_needed=$_POST['time_needed_val'];
 $complete_date=$_POST['complete_date_val'];

 $complete_date = !empty($complete_date) ? "'$complete_date'" : "NULL";
 $budget = !empty($budget) ? $budget : "NULL";
 $actual_cost = !empty($actual_cost) ? $actual_cost : "0";

 $sql = "UPDATE projects SET budget=$budget,type='$type',time_needed='$time_needed',complete_date=$complete_date,status='$status',start_date='$start_date',actual_cost='$actual_cost' WHERE project_id = '$row'";

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

if(isset($_POST['create_project']))
{
 $client_id=$_POST['client_id_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];
 $complete_date=$_POST['complete_date_val'];
 $time_needed=$_POST['time_needed_val'];
 $title=$_POST['title_val'];
 $type=$_POST['type_val'];
 $budget=$_POST['budget_val'];
 $actual_cost=$_POST['actual_cost_val'];


 $complete_date = !empty($complete_date) ? "'$complete_date'" : "NULL";
 // $title = !empty($title) ? "'$title'" : "";
 $budget = !empty($budget) ? $budget : "NULL";
 $actual_cost = !empty($actual_cost) ? $actual_cost : "0";
$projid =  "SELECT MAX(project_id)+1 AS max FROM projects";
$projectid = $conn->query($projid);
while ($rowid=mysqli_fetch_array($projectid)) 
{ 
	$id=$rowid['max'];
}
$conn->close();
$conn= new mysqli($servername, $username, $password, $dbname);
 $sql = "INSERT INTO projects VALUES($id,'$client_id','$status','$start_date',$complete_date,'$time_needed','$title','$type',$budget,'$actual_cost')";
 // $sql = "INSERT INTO projects(project_id,client_id,status,title,type) VALUES($id,$client_id,'$status','$title','$type')";


 if ($conn->query($sql) === TRUE) {
 	echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}

if(isset($_POST['create_client']))
{
 $username=$_POST['username_val'];
 $password=$_POST['password_val'];
 $password = sha1($password);

 $sql = "INSERT INTO users VALUES('$username','$password','Customer')";

 if ($conn->query($sql) === TRUE) {
 	echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}

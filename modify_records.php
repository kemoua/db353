<?php
include 'config_server.php';

$conn = new mysqli($servername, $username, $password, $dbname);

/**************************************************************************************/
/*  PROJECTS  */
/**************************************************************************************/

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

if(isset($_POST['delete_project']))
{
 $project_no=$_POST['project_id'];
 $sql = "DELETE FROM projects WHERE project_id = '$project_no'";

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


 if ($conn->query($sql) === TRUE) {
 	echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}

/**************************************************************************************/
/*  CLIENTS  */
/**************************************************************************************/

if(isset($_POST['create_client']))
{
 $client_id=$_POST['client_id_val'];
 $first_name=$_POST['first_name_val'];
 $last_name=$_POST['last_name_val'];
 $civic_number=$_POST['civic_number_val'];
 $postal_code=$_POST['postal_code_val'];
 $country=$_POST['country_val'];
 $city=$_POST['city_val'];
 $phone=$_POST['phone_val'];
 $username=$_POST['username_val'];
 $password=$_POST['password_val'];
 $street=$_POST['street_val'];
 $password = sha1($password);

 $sql = "INSERT INTO users VALUES('$username','$password','Customer')";
 if ($conn->query($sql) === TRUE) {
 	$sql = "INSERT INTO clients VALUES('$client_id','$first_name','$last_name','$civic_number','$postal_code','$country','$city','$phone','$username','$street')";
 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 // $conn = new mysqli($servername, $username, $password, $dbname);
 // $clientidsql =  "SELECT MAX(client_id)+1 AS max FROM clients";
 // $clientid = $conn->query($clientidsql);
 // while ($rowid=mysqli_fetch_array($clientid)) 
 // { 
 //    $id=$rowid['max'];
 // }
 // $conn->close();
 // $conn = new mysqli($servername, $username, $password, $dbname);
 // $sql = "INSERT INTO clients VALUES('5','$first_name','$last_name','$civic_number','$postal_code','$country','$city','$phone','$username','$street')";
 // if ($conn->query($sql) === TRUE) {
 //    echo "success";
 // } else {
 //    echo "error" . mysqli_errno($conn);
 // } 
 // $conn->close();
 exit();
}

/**************************************************************************************/
/*	TASKS  */
/**************************************************************************************/
if(isset($_POST['edit_task']))
{
 $task_id=$_POST['task_id'];
 $project_id=$_POST['project_id_val'];
 $phase_id=$_POST['phase_id_val'];
 $description=$_POST['description_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];
 $complete_date=$_POST['complete_date_val'];
 $time_needed=$_POST['time_needed_val'];
 $budget=$_POST['budget_val'];
 $cost=$_POST['cost_val'];

 $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
 $complete_date = !empty($complete_date) ? "'$complete_date'" : "NULL";
 $budget = !empty($budget) ? $budget : "NULL";
 $cost = !empty($cost) ? $cost : "NULL";

 $sql = "UPDATE tasks SET description='$description',status='$status',start_date=$start_date,complete_date=$complete_date,time_needed='$time_needed',budget=$budget,cost=$cost WHERE task_id='$task_id' AND phase_id='$phase_id' AND project_id ='$project_id'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}


if(isset($_POST['create_task']))
{
 $project_id=$_POST['project_id_val'];
 $phase_id=$_POST['phase_id_val'];
 $description=$_POST['description_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];
 $complete_date=$_POST['complete_date_val'];
 $time_needed=$_POST['time_needed_val'];
 $budget=$_POST['budget_val'];
 $cost=$_POST['cost_val'];

 $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
 $complete_date = !empty($complete_date) ? "'$complete_date'" : "NULL";
 $budget = !empty($budget) ? $budget : "NULL";
 $cost = !empty($cost) ? $cost : "NULL";

$taskidsql =  "SELECT MAX(task_id)+1 AS max FROM tasks";
$taskid = $conn->query($taskidsql);
while ($rowid=mysqli_fetch_array($taskid)) 
{ 
	$id=$rowid['max'];
}
$conn->close();
$conn= new mysqli($servername, $username, $password, $dbname);
 $sql = "INSERT INTO tasks VALUES($id,'$project_id','$phase_id','$description','$status',$start_date,$complete_date,'$time_needed',$budget,$cost)";


 if ($conn->query($sql) === TRUE) {
 	echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}

if(isset($_POST['delete_task']))
{
 $task_id=$_POST['task_id'];
 $sql = "DELETE FROM tasks WHERE task_id = '$task_id'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}

/**************************************************************************************/
/*  PHASES  */
/**************************************************************************************/
if(isset($_POST['edit_phase']))
{
 $phase_id=$_POST['phase_id'];
 $project_id=$_POST['project_id_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];
 $complete_date=$_POST['complete_date_val'];
 $time_needed=$_POST['time_needed_val'];
 $budget=$_POST['budget_val'];
 $actual_cost=$_POST['actual_cost_val'];

 $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
 $complete_date = !empty($complete_date) ? "'$complete_date'" : "NULL";
 $budget = !empty($budget) ? $budget : "NULL";
 $actual_cost = !empty($actual_cost) ? $actual_cost : "NULL";

 $sql = "UPDATE phases SET status='$status',start_date=$start_date,complete_date=$complete_date,time_needed='$time_needed',budget=$budget,actual_cost=$actual_cost WHERE phase_id='$phase_id' AND project_id ='$project_id'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}


if(isset($_POST['create_phase']))
{
 $project_id=$_POST['project_id_val'];
 $status=$_POST['status_val'];
 $start_date=$_POST['start_date_val'];
 $complete_date=$_POST['complete_date_val'];
 $time_needed=$_POST['time_needed_val'];
 $budget=$_POST['budget_val'];
 $actual_cost=$_POST['actual_cost_val'];

 $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
 $complete_date = !empty($complete_date) ? "'$complete_date'" : "NULL";
 $budget = !empty($budget) ? $budget : "NULL";
 $actual_cost = !empty($actual_cost) ? $actual_cost : "NULL";

$phaseidsql =  "SELECT MAX(phase_id)+1 AS max FROM phases";
$phaseid = $conn->query($phaseidsql);
while ($rowid=mysqli_fetch_array($phaseid)) 
{ 
    $id=$rowid['max'];
}
$conn->close();
$conn= new mysqli($servername, $username, $password, $dbname);
 $sql = "INSERT INTO phases VALUES($id,'$project_id','$status',$start_date,$complete_date,'$time_needed',$budget,$actual_cost)";


 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}



/**************************************************************************************/
/*  CLIENT ACCOUNT (ONLY PHONE)  */
/**************************************************************************************/

if(isset($_POST['editPhone'])){
    $user_name = $_POST["username"];
    $phone = $_POST['phonenumber'];

 $sql = "UPDATE clients SET phone='$phone' WHERE username ='$user_name' ";
 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}


/**************************************************************************************/
/*  ORDERS  */
/**************************************************************************************/

if(isset($_POST['edit_billing']))
{
 $project_id=$_POST['project_id_val'];
 $order_number=$_POST['order_number_val'];
 $status=$_POST['status_val'];
 $total_cost=$_POST['total_cost_val'];
 $date_order=$_POST['date_order_val'];

 $date_order = !empty($date_order) ? "'$date_order'" : "NULL";
 $total_cost = !empty($total_cost) ? $total_cost : "NULL";

$phaseidsql =  "SELECT phase_id AS id FROM phases WHERE phases.status='$status' AND phases.project_id='$project_id'";
$phaseid = $conn->query($phaseidsql);
while ($rowid=mysqli_fetch_array($phaseid)) 
{ 
    $id=$rowid['id'];
}
$conn->close();
$conn= new mysqli($servername, $username, $password, $dbname);
 $sql = "UPDATE orders SET phase_id='$id',date_order=$date_order,total_cost=$total_cost WHERE order_number='$order_number'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}


if(isset($_POST['create_billing']))
{
 $project_id=$_POST['project_id_val'];
 $status=$_POST['phase_val'];
 $date_order=$_POST['date_order_val'];
 $date_delivered=$_POST['date_delivered_val'];
 $total_cost=$_POST['total_cost_val'];

 $date_order = !empty($date_order) ? "'$date_order'" : "NULL";
 $date_delivered = !empty($date_delivered) ? "'$date_delivered'" : "NULL";
 $total_cost = !empty($total_cost) ? $total_cost : "NULL";

$phaseidsql =  "SELECT phase_id AS id FROM phases WHERE phases.status='$status' AND phases.project_id='$project_id'";
$phaseid = $conn->query($phaseidsql);
while ($rowid=mysqli_fetch_array($phaseid)) 
{ 
    $phase_id=$rowid['id'];
}
$conn->close();

$orderidsql =  "SELECT MAX(order_number)+1 AS max FROM orders";
$orderid = $conn->query($orderidsql);
while ($rowid2=mysqli_fetch_array($orderid)) 
{ 
    $id=$rowid2['max'];
}
$conn->close();
$conn= new mysqli($servername, $username, $password, $dbname);
 $sql = "INSERT INTO orders VALUES($id,'$phase_id','$project_id',$total_cost,$date_order,$date_delivered)";


 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}

if(isset($_POST['delete_billing']))
{
 $order_number=$_POST['order_number'];
 $sql = "DELETE FROM orders WHERE order_number = '$order_number'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}

/**************************************************************************************/
/*  SUBORDERS  */
/**************************************************************************************/

if(isset($_POST['edit_suborders']))
{
 $sub_order_number=$_POST['sub_order_number_val'];
 $cost=$_POST['cost_val'];
 $quantity=$_POST['quantity_val'];

 $cost = !empty($cost) ? $cost : "NULL";
 $quantity = !empty($quantity) ? $quantity : "NULL";

 $sql = "UPDATE sub_orders SET cost=$cost,quantity=$quantity WHERE sub_order_number='$sub_order_number'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}


if(isset($_POST['create_suborders']))
{
 $order_number=$_POST['order_number_val'];
 $cost=$_POST['cost_val'];
 $quantity=$_POST['quantity_val'];
 $item_id=$_POST['item_id_val'];

 $cost = !empty($cost) ? $cost : "NULL";
 $quantity = !empty($quantity) ? $quantity : "NULL";


$orderidsql =  "SELECT MAX(sub_order_number)+1 AS max FROM sub_orders";
$orderid = $conn->query($orderidsql);
while ($rowid2=mysqli_fetch_array($orderid)) 
{ 
    $id=$rowid2['max'];
}
$conn->close();
$conn= new mysqli($servername, $username, $password, $dbname);
 $sql = "INSERT INTO orders VALUES($id,'$order_number',$total_cost,$quantity,'$item_id')";


 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . mysqli_errno($conn);
 } 
 $conn->close();
 exit();
}

if(isset($_POST['delete_suborders']))
{
 $sub_order_number=$_POST['sub_order_number'];
 $sql = "DELETE FROM sub_orders WHERE sub_order_number = '$sub_order_number'";

 if ($conn->query($sql) === TRUE) {
    echo "success";
 } else {
    echo "error" . $conn->error;
 }
 $conn->close();
 exit();
}
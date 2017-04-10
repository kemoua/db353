<?php
$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";
  
if(isset($_POST['result'])){

$search = $_POST['result'];
echo $search;

$conn = new mysqli($servername, $username, $password, $dbname);

 
$sql = "SELECT * FROM PROJECTS WHERE project_id LIKE '%$search' OR title LIKE '%$search' ";
$result = $conn->query($sql);

	if ($conn->query($sql) === TRUE) {
	    echo "success";
	 } else {
	    echo "error" . $conn->error;
	 }
 $conn->close();
 exit();  
}
?>

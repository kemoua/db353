<?php
session_start();

$servername="localhost";
$username="root";
$password="";
$dbname="comp353";

$projectid = $_GET["projectid"];

$conn = new mysqli($servername, $username, $password, $dbname); 
$sql = "SELECT * FROM project WHERE project_id = '$projectid' ";
$result = $conn->query($sql);

 
?>

<html>
<head>
	<link rel="stylesheet" href="css/styleProject.css">
	<title>Project <?php echo $_GET["projectid"]; ?></title>
</head>
<body>
	<header> 
		<h1>Project <?php echo $_GET["projectid"]; ?></title>
	</header>

	<div id="wrapper">
		<?php  
					while ($row=mysqli_fetch_array($result)) 
					{ 

					?>
					<div id="projectBox">

					<?php

					?><h1><?php echo $row['title']; ?></h1><?php
					?><div id="mainPic"></div><?php
			 		?><div id="content">
			 			<?php
					 		?><p>Actual Cost: <?php echo $row['actual_cost'];?></p><?php 
					 		?><p>Status: <?php echo $row['status'];?></p><?php 
					 		?><p>Type: <?php echo $row['type'];?></p><?php 
							?><p>Start Date: <?php echo $row['start_date'];?></p><?php 
			 			?>

			 		</div><?php	 
					?>
					</div>
					<?php
			  	 	
					}  
		?>
		</div>
	<?php
	$conn->close();
	?> 
</body>
</html>
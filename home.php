<?php
	session_start();
 
$servername="localhost";
$username="root";
$password="";
$dbname="comp353";

//query for admin
$conn = new mysqli($servername, $username, $password, $dbname); 
$sql = "SELECT * FROM project";
$result = $conn->query($sql);


//query for users with no admin privileges
$user = $_SESSION['user'];
$sql2 = "SELECT * FROM project,client WHERE project.client_id = client.client_id AND client.username ='$user' ";
$resultClient = $conn->query($sql2);

?>

<html>
<head>
	<link rel="stylesheet" href="css/styleHome.css">
	<title>Welcome to Damavand!</title>
</head>
<body>
	<header>
		<div id="header"></div>
		<h1>Welcome <?php echo $_SESSION["user"]; ?></h1>

	</header>



	<div id="wrapper">
		<h1>Projects</h1>


		<?php  
				if($_SESSION['privilege'] == 'A'){

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

			 		?><input type="button" class="infosButton" onclick="window.location='project.php?projectid=<?php echo $row['project_id']; ?>';" /><?php

					?>
					</div>
					<?php
			  	 	
					}  
				}else{  // if user is a client , he will only be able to see his own projects
					while ($rowClient=mysqli_fetch_array($resultClient)) 
					{ 

					?>
					<div id="projectBox">

					<?php

					?><h1><?php echo $rowClient['title']; ?></h1><?php
					?><div id="mainPic"></div><?php
			 		?><div id="content">
			 			<?php
					 		?><p>Actual Cost: <?php echo $rowClient['actual_cost'];?></p><?php 
					 		?><p>Status: <?php echo $rowClient['status'];?></p><?php 
					 		?><p>Type: <?php echo $rowClient['type'];?></p><?php 
							?><p>Start Date: <?php echo $rowClient['start_date'];?></p><?php 
			 			?>

			 		</div><?php	

			 		?><input type="button" class="infosButton" onclick="window.location='project.php?projectid=<?php echo $rowClient['project_id']; ?>';" /><?php

					?>
					</div>
					<?php
			  	 	
					}  
				}
			?>
	</div>
	<?php
	$conn->close();
	?> 
</body>
</html>
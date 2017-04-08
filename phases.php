<?php
session_start();


$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";

$projectid = $_GET["projectid"]; 
?>

<html>
<head>
	<link rel="stylesheet" href="css/styleHome.css">
	<title>PHASES</title>
</head>
<body>
	<header> 
	<div id="logo" onclick="window.location = 'home.php';"></div>
		<!-- <button class="logout" onclick="window.location = 'index.php';">Logout</button> -->
	</header>
		<ul id="menu">
		        <li><a href="home.php">Home</a></li>
		        <li>
		                <a href="home.php">Project</a>
		                <ul>
		                        <li><a href="home.php">List</a>
								<ul>
									<?php  
										$conn2 = new mysqli($servername, $username, $password, $dbname); 
										$sql1 = "SELECT * FROM projects";
										$result2 = $conn2->query($sql1);
										//query for users with no admin privileges
										$user = $_SESSION['user'];
										$sql2 = "SELECT * FROM projects,client WHERE project.client_id = client.client_id AND client.username ='$user' ";
										$resultClient = $conn2->query($sql2);
										if($_SESSION['privilege'] == 'Company'){
											while ($row=mysqli_fetch_array($result2)) 
											{ 
									?>
												<li><a href="project.php?projectid=<?php echo $row['project_id']; ?>"><?php echo $row['title'];?></a></li>
											<?php
										  	
											}  
											}else{  // if user is a client , he will only be able to see his own projects
												while ($rowClient=mysqli_fetch_array($resultClient)) 
												{ 
												?>
													<li><a href="project.php?projectid=<?php echo $rowClient['project_id']; ?>"><?php echo $rowClient['title'];?></a></li>

												<?php
												}  
											}
											?>
									<?php
										$conn2->close();
									?> 

								</ul>
		                        </li>
		                        <li><a href="#">Create</a></li>
		                </ul>
		        </li>
		        <li><a href="#">About</a></li>
		        <li><a href="#">Contact</a></li>
		        <li><a href="index.php">Logout</a></li>
		</ul>

		<div id="wrapper"> 
					<h1>Phases for the project : <?php echo $projectid;?></h1>
					<?php 
						$conn = new mysqli($servername, $username, $password, $dbname);  
						$sql = "SELECT * FROM phases WHERE project_id ='$projectid' ";
						$result = $conn->query($sql); 

						while ($row=mysqli_fetch_array($result)) 
						{ 
							?><div id="projectBoxPhases"><?php

							?><label>Phase ID</label><p><?php echo $row['phase_id']; ?></p><?php
							?><label>Status</label><p><?php echo $row['status'];?></p><?php
							?><label>Start Date</label><p><?php echo $row['status'];?></p><?php
							?><label>Complete Date</label><p><?php echo $row['complete_date'];?></p><?php
							?><label>Time Needed</label><p><?php echo $row['time_needed'];?></p><?php
							?><label>Budget</label><p><?php echo $row['budget'];?></p><?php
							?><label>Actual Cost</label><p><?php echo $row['actual_cost'];?></p><?php
							
							?>	
							<div class="action_btns">
							<?php	 

							if($_SESSION['privilege'] == 'Company'){
							?>
							  <input type='button' class="edit_button" id="edit_button<?php echo $row['project_id'];?>" value="edit" onclick="edit_row('<?php echo $row['project_id'];?>');">
						 	  <input type='button' style="display: none;" class="save_button" id="save_button<?php echo $row['project_id'];?>" value="save" onclick="save_row('<?php echo $row['project_id'];?>');">
							<?php 
							} 
							
							?></div><?php								

							?></div><?php	

						}
						
						$conn->close();


					?>

		</div>
</body>
</html>
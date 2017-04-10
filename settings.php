<?php
session_start();

include 'config_server.php';

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
		        <li><a href="#">Contact</a></li>
		        <li><a href="index.php">Logout</a></li>
		</ul>
		<div id="wrapper">
			<div id="projectBox">
				<h1>je veux que tout ce qui ce passer dans le EDIT (le petit button) se passe ici!!!!</h1>
			</div>
		</div>
</body>
</html>
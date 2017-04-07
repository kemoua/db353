<?php
session_start();

$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";

$projectid = $_GET["projectid"];

$conn = new mysqli($servername, $username, $password, $dbname); 
$sql = "SELECT * FROM projects WHERE project_id = '$projectid' ";
$result = $conn->query($sql);

 
?>

<html>
<head>
	<link rel="stylesheet" href="css/styleProject.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/modify_records.js"></script>
	<script type='text/javascript'>
	$(document).ready(function(){ 
	    $(window).scroll(function(){ 
	        if ($(this).scrollTop() > 100) { 
	            $('#scroll').fadeIn(); 
	        } else { 
	            $('#scroll').fadeOut(); 
	        } 
	    }); 
	    $('#scroll').click(function(){ 
	        $("html, body").animate({ scrollTop: 0 }, 600); 
	        return false; 
	    }); 
	});
	</script>
	<title>Project <?php echo $_GET["projectid"]; ?></title>
</head>
<body>
<a href="javascript:void(0);" id="scroll" title="Scroll to Top" style="display: none;">Top<span></span></a>
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
										if($_SESSION['privilege'] == 'A'){
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
	
		<?php  
					while ($row=mysqli_fetch_array($result)) 
					{ 

					?>
					<div id="projectBox">

					<?php

					?><h1><?php echo $row['title']; ?></h1><?php
					?><div class="mainPic">	

					<?php
					$file = 'images/project'. $row['project_id']. '/main.jpg';

					if (!file_exists($file)) {
					    $file = 'images/no_img.png';
					}				
					echo '<img src="'. $file. '"/>'; 

			 		?><div id="content">
			 			<div id="row<?php echo $row['project_id'];?>">
			 			<?php
					 		?>Actual Cost: <label id="actual_cost_val<?php echo $row['project_id'];?>"><?php echo $row['actual_cost'];?></label><br><?php 
					 		?>Status: <label id="status_val<?php echo $row['project_id'];?>"><?php echo $row['status'];?></span></label><br><?php 
					 		?>Type: <label id="type_val<?php echo $row['project_id'];?>"><?php echo $row['type'];?></label><br><?php 
							?>Start Date: <label id="start_date_val<?php echo $row['project_id'];?>"><?php echo $row['start_date'];?></label><br><?php 
			 			?>

			 		</div>
			 		</div><?php	 
					?><div class="action_btns"><?php
						if($_SESSION['privilege'] == 'A'){
							?>
					   <input type='button' class="edit_button" id="edit_button<?php echo $row['project_id'];?>" value="edit" onclick="edit_row('<?php echo $row['project_id'];?>');">
					   <input type='button' style="display: none;" class="save_button" id="save_button<?php echo $row['project_id'];?>" value="save" onclick="save_row('<?php echo $row['project_id'];?>');">
						<?php
						}
					?></div>
					</div>
					<!-- Test queries response -->
					<input type="hidden" id="result">
					<?php
			  	 	
					}  
		?>
		</div>
	<?php
	$conn->close();
	?> 
</body>
</html>
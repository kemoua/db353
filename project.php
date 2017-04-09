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
	<link rel="stylesheet" href="css/styleHome.css">  
  	<link rel="stylesheet" type="text/css" media="all" href="css/jquery.lightbox-0.5.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script type="text/javascript" src="js/jquery.lightbox-0.5.min.js"></script>

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
										$sql2 = "SELECT * FROM projects,clients WHERE projects.client_id = clients.client_id AND clients.username ='$user' ";
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
		                        <?php
		                        if($_SESSION['privilege'] == 'Company'){
		                        	?><li><a href="create.php">Create</a></li>
		                        <?php }?>
		                </ul>
		        </li>
		        <li><a href="#">About</a></li>
		        <li><a href="#">Contact</a></li>
		        <li><a href="index.php">Logout</a></li>
		</ul>

	<div id="wrapper">
		<div id="buttonSection">
			<a href="phases.php?projectid=<?php echo $_GET["projectid"] ?>"><img border="0" src="images/phases_1.png" width="149" height="50" onmouseover="this.src='images/phases_1_2.png';" onmouseout="this.src='images/phases_1.png';" /></a>


			<a href="tasks.php?projectid=<?php echo $_GET["projectid"] ?>"><img border="0" src="images/tasks_1.png" width="149" height="50" onmouseover="this.src='images/tasks_1_2.png';" onmouseout="this.src='images/tasks_1.png';" />
			</a>

			<a href="billing.php?projectid=<?php echo $_GET["projectid"] ?>"><img border="0" alt="" src="images/billing_1.png" width="149" height="50" onmouseover="this.src='images/billing_1_2.png';" onmouseout="this.src='images/billing_1.png';" />
			</a>
		</div>
	
		<?php  
				while ($row=mysqli_fetch_array($result)) 
				{ 

				?>
				<div id="projectBoxBig">

				<h1><?php echo strtoupper($row['title']); ?></h1>
		
		 		<div id="contentBigBox">  <?php
		 				//rajout de lignes 
				 		?><b>Project #: </b><label id="project_id_val<?php echo $row['project_id'];?>"><?php echo $row['project_id'];?></label></br><?php 
				 		?><b>Client ID: </b><label id="client_id_val<?php echo $row['project_id'];?>"><?php echo $row['client_id'];?></label></br><?php 
				 		?><b>Budget: </b><label id="budget_val<?php echo $row['project_id'];?>"><?php echo $row['budget'];?></label><br><?php
				 		?><b>Actual Cost: </b><label id="actual_cost_val<?php echo $row['project_id'];?>"><?php echo $row['actual_cost'];?></label><br><?php 
				 		?><b>Status: </b><label id="status_val<?php echo $row['project_id'];?>"><?php echo $row['status'];?></span></label><br><?php 
				 		?><b>Type: </b><label id="type_val<?php echo $row['project_id'];?>"><?php echo $row['type'];?></label><br><?php 
						?><b>Time Needed : </b><label id="time_needed_val<?php echo $row['project_id'];?>"><?php echo $row['time_needed'];?></label></br><?php
						?><b>Start Date: </b><label id="start_date_val<?php echo $row['project_id'];?>"><?php echo $row['start_date'];?></label><br><?php 
		 				?><b>Complete Date: </b><label id="complete_date_val<?php echo $row['project_id'];?>"><?php echo $row['complete_date'];?></label></br><?php
		 		

		 			?>
					</div>

				<?php

						?><div class="project_main_pic"><?php
						$file = 'images/project'. $row['project_id']. '/main.jpg';

						if (!file_exists($file)) {
						    $file = 'images/no_img.png';
						}				
						echo '<img class="main_pic_project" width="400" height="300" src="'. $file. '"/>'; 

						?>
						<div id="photosBox">
					      <div id="thumbnails">
					        <ul class="clearfix"> 
					        	<!-- source: http://dribbble.com/shots/1115776-DIY-Robot-Kit -->
					         	<li><a href="images/photos/02-robot-diy-kit.png" title="DIY Robot by Jory Raphael"><img src="images/photos/02-robot-diy-kit-thumbnail.png" alt="DIY Robot Kit"></a></li>
					          
					          	<!-- source: http://dribbble.com/shots/1115794-Todly -->
					          	<li><a href="images/photos/03-todly-green-monster.png" title="Todly by Scott Wetterschneider"><img src="images/photos/03-todly-green-monster-thumbnail.png" alt="Todly"></a></li>
					      
					          	<li><a href="images/photos/03-todly-green-monster.png" title="Todly by Scott Wetterschneider"><img src="images/photos/03-todly-green-monster-thumbnail.png" alt="Todly"></a></li>

					      	  </ul>
					     	 </div>
					     </div> 
						<?php 


				?>
				</div>
				<div class="action_btns_project"><?php 
					if($_SESSION['privilege'] == 'Company'){
				?> 
				   <input type="button" class="deleteProject" onclick="delete_project('<?php echo $_GET['projectid'];?>');">
				   <input type='button' class="edit_button" id="edit_button<?php echo $row['project_id'];?>" onclick="edit_project('<?php echo $row['project_id'];?>');">
				   <input type='button' style="display: none;" class="save_button" id="save_button<?php echo $row['project_id'];?>" value="Save" onclick="save_project('<?php echo $row['project_id'];?>');">	
				   <input type='button' style="display: none;" class="save_button" id="cancel_button<?php echo $row['project_id'];?>" value="Cancel" onclick="cancel_edit_project('<?php echo $row['project_id'];?>');">
				<?php } ?>
				</div>					
					<!-- Test queries response -->
					<input type="hidden" id="result">
				<?php
			  	 	
				}  
		?>
		</div>

	</div>
		<?php
		$conn->close();
		?> 
</body>
</html>
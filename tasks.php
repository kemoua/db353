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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/modify_tasks.js"></script>
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
	<title>TASKS</title>
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

		<script>
			function displayBox() {
			    div = document.getElementById('newPhase');
			    div.style.display = "block";
			}
		</script>
		<div id="wrapper"> 
					<h1>Tasks for the project : <?php echo $projectid;?></h1>
					<a class='back' href="project.php?projectid=<?php echo $_GET["projectid"] ?>"><img border="0" src="images/arrow.png" width="80" height="80">
					</a>
					 <?php  
						if($_SESSION['privilege'] == 'Company'){
							?><a class='add' href="javascript:displayBox();"><img border="0" src="images/add.png" width="80" height="80">
							</a><?php
						}
					?>		


					<div id="newPhase">
						<div id="projectBoxPhases">
								<!-- <label>Task ID</label><input type="text" name="new_task_id"> -->
								<label>Project Id</label><input type="text" name="new_project_id" value="<?php echo $projectid;?>" disabled>
								<label>Phase ID</label><input type="text" name="new_phase_id">
								<label>Description</label><input type="text" name="new_description">
								<label>Status</label><input type="text" name="new_status">
								<label>Start Date</label><p><input type="text" name="new_start_date">
								<label>Complete Date</label><input type="text" name="new_complete_date">
								<label>Time Needed</label><input type="text" name="new_time_needed">
								<label>Budget</label><p><input type="text" name="new_budget">
								<label>Cost</label><input type="text" name="new_actual_cost">								
								<input type="button" value="Create Task" onclick="create_task();">
							</form>
						</div>
					</div>

					<?php 
						$conn = new mysqli($servername, $username, $password, $dbname);  
						$sql = "SELECT tasks.project_id,task_id,phases.status as phases_id,tasks.description,tasks.status as status,tasks.start_date,tasks.complete_date,tasks.time_needed,tasks.budget,tasks.cost FROM tasks,phases WHERE tasks.project_id ='$projectid' ";
						$result = $conn->query($sql); 

						$num_rows = $result->num_rows;

						if($num_rows === 0){
							?><div id="projectBoxCreate">No tasks have been found for this project.</div><?php
						}

						while ($row=mysqli_fetch_array($result)) 
						{ 
							?><div id="projectBoxPhases"><?php

							?><b>Task Id: </b><label id="task_id_val<?php echo $row['project_id'];?>"><?php echo $row['task_id'];?></label><br><?php 
							?><b>Phase Status: </b><label id="phase_id_val<?php echo $row['project_id'];?>"><?php echo $row['phases_id'];?></label><br><?php 
							?><b>Description: </b><label id="description_val<?php echo $row['project_id'];?>"><?php echo $row['description'];?></label><br><?php 
							?><b>Status: </b><label id="status_val<?php echo $row['project_id'];?>"><?php echo $row['status'];?></label><br><?php 
							?><b>Start date: </b><label id="start_date_val<?php echo $row['project_id'];?>"><?php echo $row['start_date'];?></label><br><?php 
							?><b>Complete date: </b><label id="complete_date_val<?php echo $row['project_id'];?>"><?php echo $row['complete_date'];?></label><br><?php 
							?><b>Time needed: </b><label id="time_needed_val<?php echo $row['project_id'];?>"><?php echo $row['time_needed'];?></label><br><?php 
							?><b>Budget: </b><label id="budget_val<?php echo $row['project_id'];?>"><?php echo $row['budget'];?></label><br><?php 
							?><b>Cost: </b><label id="cost_val<?php echo $row['project_id'];?>"><?php echo $row['cost'];?></label><br><?php 
						
							?>	
							<div class="action_btns">
							<?php	 

							if($_SESSION['privilege'] == 'Company'){
							?>
							  <input type='button' class="edit_button" id="edit_button<?php echo $row['project_id'];?>" value="edit" onclick="edit_task('<?php echo $row['project_id'];?>');">
						 	  <input type='button' style="display: none;" class="save_button" id="save_button<?php echo $row['project_id'];?>" value="save" onclick="save_task('<?php echo $row['project_id'];?>');">
						 	  <input type='button' style="display: none;" class="save_button" id="cancel_button<?php echo $row['project_id'];?>" value="Cancel" onclick="cancel_edit_task('<?php echo $row['project_id'];?>');">
							<?php 
							} 
							
							?></div><?php								

							?></div><?php	

						}
						
						$conn->close();


					?>
</body>
</html>
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
										$sql2 = "SELECT * FROM projects,clients WHERE project.client_id = client.client_id AND client.username ='$user' ";
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
		        <li><a href="contact.php">Contact</a></li>
		        <li><a href="index.php">Logout</a></li>
		</ul>

		<script>
			function displayBox() {
			    div = document.getElementById('newTask');
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


					<div id="newTask"> 
							<h2>Task ID #</h2> 
								<label>Project Id</label><input type="text" id="new_project_id" value="<?php echo $projectid;?>" disabled>
								<label>Phase Id</label><select id="new_phase_id">
								<?php  
										$conn2 = new mysqli($servername, $username, $password, $dbname); 
										$sql1 = "SELECT * FROM phases WHERE project_id='$projectid'";
										$result2 = $conn2->query($sql1);
										
											while ($row=mysqli_fetch_array($result2)) 
											{ 
									?>
												<option value="<?php echo $row['phase_id']; ?>"><?php echo $row['phase_id'];?></option>
											<?php
										  	
											}  
											
											?>
									<?php
										$conn2->close();
									?>	
								</select>
								<label>Description</label><input type="text" id="new_description">
								<label>Status</label><select id="new_status">
														<option value="Pending" selected>Pending</option>
														<option value="In Progress">In Progress</option>
														<option value="Completed">Completed</option>
														<option value="Cancelled">Cancelled</option>
														</select>
								<label>Start Date</label><input type="date" id="new_start_date">
								<label>Complete Date</label><input type="date" id="new_complete_date">
								<label>Time Needed</label><input type="text" id="new_time_needed">
								<label>Budget</label><input type="number" id="new_budget">
								<label>Cost</label><input type="number" id="new_cost">	 
								<input type="button" class="createButtonTask" value="Create Task" onclick="create_task();">
								<input type="button" class="cancelButtonTask" value="Cancel" onclick="">

					</div>

<!-- QUERY RESPONSE -->
					<input type="hidden" id="result">


					<?php 
						$conn = new mysqli($servername, $username, $password, $dbname);  
						$sql = "SELECT * FROM tasks WHERE tasks.project_id ='$projectid' ";
						$result = $conn->query($sql); 

						$num_rows = $result->num_rows;

						if($num_rows === 0){
							?><div id="projectBoxTasks">No tasks have been found for this project.</div><?php
						}

						while ($row=mysqli_fetch_array($result)) 
						{ 
							?><div id="projectBoxTasks"><?php
							?><h2>Task ID #<?php echo $row['task_id']; ?></h2><?php
							?><label>Project Id: </label><p id="project_id_val<?php echo $row['task_id'];?>"><?php echo $row['project_id'];?></p><?php 
							?><label>Phase Id: </label><p id="phase_id_val<?php echo $row['task_id'];?>"><?php echo $row['phase_id'];?></p><?php 
							?><label>Description: </label><p id="description_val<?php echo $row['task_id'];?>"><?php echo $row['description'];?></p><?php 
							?><label>Status: </label><p id="status_val<?php echo $row['task_id'];?>"><?php echo $row['status'];?></p><?php 
							?><label>Start date: </label><p id="start_date_val<?php echo $row['task_id'];?>"><?php echo $row['start_date'];?></p><?php 
							?><label>Complete date: </label><p id="complete_date_val<?php echo $row['task_id'];?>"><?php echo $row['complete_date'];?></p><?php 
							?><label>Time needed: </label><p id="time_needed_val<?php echo $row['task_id'];?>"><?php echo $row['time_needed'];?></p><?php 
							?><label>Budget: </label><p id="budget_val<?php echo $row['task_id'];?>"><?php echo $row['budget'];?></p><?php 
							?><label>Cost: </label><p id="cost_val<?php echo $row['task_id'];?>"><?php echo $row['cost'];?></p><?php 					
							?>	
							<div class="action_btns_tasks">
							<?php	 

							if($_SESSION['privilege'] == 'Company'){
							?>
							  <input type='button' class="deleteTask" >
							  <input type='button' class="edit_button" id="edit_button<?php echo $row['task_id'];?>" value="" onclick="edit_task('<?php echo $row['task_id'];?>');">
						 	  <input type='button' style="display: none;" class="save_button" id="save_button<?php echo $row['task_id'];?>" value="save" onclick="save_task('<?php echo $row['task_id'];?>');">
						   	  <input type='button' style="display: none;" class="save_button" id="cancel_button<?php echo $row['task_id'];?>" value="Cancel" onclick="cancel_edit_task('<?php echo $row['project_id'];?>');">						 	  
							<?php 
							} 
							
							?></div><?php								

							?></div><?php	

						}
						
						$conn->close();


					?>
</body>
</html>
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
	<script type="text/javascript" src="js/modify_phases.js"></script>
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
					<h1>Phases for the project : <?php echo $projectid;?></h1>
					<a class='back' href="project.php?projectid=<?php echo $_GET["projectid"] ?>"><img border="0" src="images/arrow.png" width="80" height="80">
					</a>
					 <?php  
						if($_SESSION['privilege'] == 'Company'){
							?><a class='add' href="javascript:displayBox();"><img border="0" src="images/add.png" width="80" height="80">
							</a>
							<?php
						}
					?>


					<div id="newPhase">
						<div id="projectBoxPhases">
								<h2>Phase ID #</h2>
								<label>Project Id #</label><input type="text" value="<?php echo $projectid; ?>" >
								<label>Status:</label><select id="new_status">
														<option value="Design" selected>Design</option>
														<option value="Pre-Construction">Pre-Construction</option>
														<option value="Procurement">Procurement</option>
														<option value="Construction">Construction</option>
														<option value="Owner Occupancy">Owner Occupancy</option>
														<option value="Closeout">Closeout</option>
														</select>
								<label>Start Date:</label><input type="date" id="new_start_date">
								<label>Complete Date:</label><input type="date" id="new_complete_date">
								<label>Time Needed:</label><input type="text" id="new_time_needed">
								<label>Budget:</label><input type="number" id="new_budget">
								<label>Actual Cost:</label><input type="number" id="new_actual_cost">								
								<input type="button" class="createButtonPhase" value="Create Phase" onclick="create_phase();">
								<input type="button" class="cancelButtonPhase" value="Cancel" onclick="">
	
						</div>
					</div>


					<input type="hidden" id="result">

					<?php
						$conn = new mysqli($servername, $username, $password, $dbname);  
						$sql = "SELECT * FROM phases WHERE project_id ='$projectid' ";
						$result = $conn->query($sql); 
						$num_rows = $result->num_rows;

						if($num_rows === 0){
							?><div id="projectBoxCreate">No phases have been found for this project.</div><?php
						}

						while ($row=mysqli_fetch_array($result)) 
						{ 
							?><div id="projectBoxPhases"><?php
							?><h2>Phase ID #<?php echo $row['phase_id']; ?></h2><?php
							?><label>Project Id # </label><p id="project_id_val<?php echo $row['phase_id'];?>"><?php echo $row['project_id'];?></p><?php 
							?><label>Status: </label><p id="status_val<?php echo $row['phase_id'];?>"><?php echo $row['status'];?></p><?php 
							?><label>Start Date: </label><p id="start_date_val<?php echo $row['phase_id'];?>"><?php echo $row['start_date'];?></p><?php 
							?><label>Complete Date: </label><p id="complete_date_val<?php echo $row['phase_id'];?>"><?php echo $row['complete_date'];?></p><?php 
							?><label>Time Needed: </label><p id="time_needed_val<?php echo $row['phase_id'];?>"><?php echo $row['time_needed'];?></p><?php 
							?><label>Budget: </label><p id="budget_val<?php echo $row['phase_id'];?>"><?php echo $row['budget'];?></p><?php 
							?><label>Actual Cost: </label><p id="actual_cost_val<?php echo $row['phase_id'];?>"><?php echo $row['actual_cost'];?></p><?php 					
							?>
							<div class="action_btns_phases">


							<?php	 

							if($_SESSION['privilege'] == 'Company'){
							?>
							  <input type='button' class="edit_button_phases" id="edit_button<?php echo $row['phase_id'];?>" onclick="edit_phase('<?php echo $row['phase_id'];?>');">
						 	  <input type='button' style="display: none;" class="save_button_phase" id="save_button<?php echo $row['phase_id'];?>" value="save" onclick="save_phase('<?php echo $row['phase_id'];?>');">
						 	  <input type='button' style="display: none;" class="save_button_phase" id="cancel_button<?php echo $row['phase_id'];?>" value="Cancel" onclick="cancel_edit_phase('<?php echo $row['project_id'];?>');">

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
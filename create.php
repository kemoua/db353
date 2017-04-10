<?php
	session_start();
 
$serverid="localhost";
$userid="root";
$password="root";
$dbid="comp353";

 $conn = new mysqli($serverid, $userid, $password, $dbid);
 $clientidsql =  "SELECT MAX(client_id)+1 AS max FROM clients";
 $clientid = $conn->query($clientidsql);
 while ($rowid=mysqli_fetch_array($clientid)) 
 { 
    $id=$rowid['max'];
 }
 $conn->close();
//query for admin
$conn = new mysqli($serverid, $userid, $password, $dbid); 
$sql = "SELECT * FROM projects";
$result = $conn->query($sql);


//query for users with no admin privileges
$user = $_SESSION['user'];
$sql2 = "SELECT * FROM projects,clients WHERE projects.client_id = clients.client_id AND clients.userid ='$user' ";
$resultClient = $conn->query($sql2);

?>

<html>
<head>
	<link rel="stylesheet" href="css/styleHome.css">
	<title>Welcome to Damavand!</title>

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
</head>
<body>
<a href="javascript:void(0);" id="scroll" title="Scroll to Top" style="display: none;">Top<span></span></a>
	<header>
		<div id="logo" onclick="window.location = 'home.php';"></div>
	</header>

		<ul id="menu">
		        <li><a href="#">Home</a></li>
		        <li>
		                <a href="#">Project</a>
		                <ul>
		                        <li><a href="#">List</a>
								<ul>
									<?php  
										if($_SESSION['privilege'] == 'Company'){
											while ($row=mysqli_fetch_array($result)) 
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
										$conn->close();
										$conn = new mysqli($serverid, $userid, $password, $dbid); 
										$sql = "SELECT * FROM projects";
										$result = $conn->query($sql);
										//query for users with no admin privileges
										$user = $_SESSION['user'];
										$sql2 = "SELECT * FROM projects,clients WHERE projects.client_id = clients.client_id AND clients.userid ='$user' ";
										$resultClient = $conn->query($sql2);
									?> 

								</ul>
		                        </li>
		                        <?php  
										if($_SESSION['privilege'] == 'Company'){
											?><li><a href="create.php">Create</a></li>
										<?php }
									?>
		                        
		                </ul>
		        </li>
		        <li><a href="#">About</a></li>
		        <li><a href="#">Contact</a></li>
		        <li><a href="client.php">My Account</a></li> 
		        <li><a href="index.php">Logout</a></li>
		</ul>
	

	<div id="wrapper">
	<!-- Create Client if needed -->
		<div id="clientBoxCreate">
			<h1>Client Creation</h1>
			<div class="contentClient">
				<label>Client ID: </label><input type="text" id="new_cclient_id" disabled value="<?php echo $id;?>"><br>
				<label>First Name: </label><input type="text" id="new_first_name"><br>
				<label>Last Name:</label><input type="text" id="new_last_name"><br>
				<label>Civic #: </label><input type="text" id="new_civic_number"><br>
				<label>Street: </label><input type="text" id="new_street"><br>
				<label>Postal Code: </label><input type="text" id="new_postal_code"><br>
				<label>Country: </label><input type="text" id="new_country"><br>
				<label>City: </label><input type="text" id="new_city"><br>
				<label>Phone: </label><input type="text" id="new_phone"><br>
				<label>Username: </label><input type="text" id="new_username"><br>
				<label>Password: </label><input type="password" id="new_password"><br>
				<input type="button" class="buttonClientCreate" value="Create Client" onclick="create_client();">
			</div>
		</div>	

	<!-- Create Project -->
		<div id="projectBoxCreate">
			<h1>Project Creation</h1>
			<div class="contentClient">
			<?php
			$sql3 = "SELECT client_id,username FROM clients";
			$clientid = $conn->query($sql3);
			?>
				<label>Client ID: </label><select style="" id="new_client_id">
							<?php 
							while ($rowid=mysqli_fetch_array($clientid)) 
							{ 
							?>
								<option value="<?php echo $rowid['client_id']; ?>"><?php echo $rowid['username']; ?></option>
							<?php 
							}
							?>
							</select>
				<br>

				<label>Status:</label><select style="" id="new_status">
						<option value="Analysis" selected>Analysis</option>
						<option value="In Progress">In Progress</option>
						<option value="Completed">Completed</option>
						<option value="Cancelled">Cancelled</option>
						</select><br>
				<label>Start Date:</label><input type="date" id="new_start_date" value="<?php echo date('Y-m-d')?>"><br>
				<label>Complete Date: </label><input type="date" id="new_complete_date"><br>
				<label>Time Needed: </label><input type="text" id="new_time_needed"><br>
				<label>Title: </label><input type="text" id="new_title"><br>
				<label>Type: </label><select style="" id="new_type">
						<option value="Condo" selected>Condo</option>
						<option value="House">House</option>
						</select><br>
				<label>Budget </label><input type="number" id="new_budget"><br>
				<label>Actual Cost: </label><input type="number" id="new_actual_cost"><br> 
				<input type="hidden" id="result" style="width: 500px;">

				<input type="button" class="buttonClientCreate" value="Create Project" onclick="create_project();">

			</div>
		</div>

	</div>
	<?php
	$conn->close();
	?> 
	

</body>


</html>
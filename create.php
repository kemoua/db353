<?php
	session_start();
 
$serverid="localhost";
$userid="root";
$password="root";
$dbid="comp353";

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
		        <li><a href="index.php">Logout</a></li>
		</ul>
	

	<div id="wrapper">
	<!-- Create Client if needed -->
		<div id="clientBoxCreate">
			<div id="content">
				Client ID: <input type="text" id="new_cclient_id"><br>
				First Name: <input type="text" id="new_first_name"><br>
				Last Name:<input type="text" id="new_last_name"><br>
				Civic #: <input type="text" id="new_civic_number"><br>
				Street: <input type="text" id="new_street"><br>
				Postal Code: <input type="text" id="new_postal_code"><br>
				Country: <input type="text" id="new_country"><br>
				City: <input type="text" id="new_city"><br>
				Phone: <input type="text" id="new_phone"><br>
				Username: <input type="text" id="new_username"><br>
				Password: <input type="password" id="new_password"><br>
				<input type="button" value="Create Client" onclick="create_client();">
			</div>
		</div>	

	<!-- Create Project -->
		<div id="projectBoxCreate">
			<div id="content">
			<?php
			$sql3 = "SELECT * FROM clients";
			$clientid = $conn->query($sql3);
			?>
				Client ID: <select id="new_client_id">
							<?php 
							while ($rowid=mysqli_fetch_array($clientid)) 
							{ 
							?>
								<option value="<?php echo $rowid['client_id']; ?>"></option>
							<?php 
							}
							?>
							</select>
				<br>

				Status:<select id="new_status">
						<option value="Analysis" selected>Analysis</option>
						<option value="In Progress">In Progress</option>
						<option value="Completed">Completed</option>
						<option value="Cancelled">Cancelled</option>
						</select><br>
				Start Date:<input type="date" id="new_start_date" value="<?php echo date('Y-m-d')?>"><br>
				Complete Date: <input type="date" id="new_complete_date"><br>
				Time Needed: <input type="text" id="new_time_needed"><br>
				Title: <input type="text" id="new_title"><br>
				Type: <select id="new_type">
						<option value="Condo" selected>Condo</option>
						<option value="House">House</option>
						</select><br>
				Budget <input type="number" id="new_budget"><br>
				Actual Cost: <input type="number" id="new_actual_cost"><br>
				<input type="button" value="Create Project" onclick="create_project();">
				<br><input type="text" id="result" style="width: 500px;">
			</div>
		</div>

	</div>
	<?php
	$conn->close();
	?> 
	

</body>


</html>
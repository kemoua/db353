<?php
	session_start();
 
$serverid="localhost";
$userid="root";
$password="root";
$dbid="comp353";

//query for admin
$conn = new mysqli($serverid, $userid, $password, $dbid); 
$sql = "SELECT * FROM project";
$result = $conn->query($sql);


//query for users with no admin privileges
$user = $_SESSION['user'];
$sql2 = "SELECT * FROM project,client WHERE project.client_id = client.client_id AND client.userid ='$user' ";
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
		<div id="logo" ></div>
	</header>

		<ul id="menu">
		        <li><a href="#">Home</a></li>
		        <li>
		                <a href="#">Project</a>
		                <ul>
		                        <li><a href="#">List</a>
								<ul>
									<?php  
										if($_SESSION['privilege'] == 'A'){
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
										$sql = "SELECT * FROM project";
										$result = $conn->query($sql);
										//query for users with no admin privileges
										$user = $_SESSION['user'];
										$sql2 = "SELECT * FROM project,client WHERE project.client_id = client.client_id AND client.userid ='$user' ";
										$resultClient = $conn->query($sql2);
									?> 

								</ul>
		                        </li>
		                        <?php  
										if($_SESSION['privilege'] == 'A'){
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
		Project ID: <input type="text" id="new_project_id"><br>
		Client ID: <input type="text" id="new_client_id"><br>
		Status: <input type="text" id="new_status"><br>
		Start Date:<input type="text" id="new_start_date"><br>
		Complete Date: <input type="text" id="new_complete_date"><br>
		Time Needed: <input type="text" id="new_time_needed"><br>
		Title: <input type="text" id="new_title"><br>
		Type: <input type="text" id="new_type"><br>
		Budget <input type="text" id="new_budget"><br>
		Actual Cost: <input type="text" id="new_actual_cost"><br>
		<input type="button" value="Create Project" onclick="create_project();">
		<br><input type="text" id="result">
	</div>
	<?php
	$conn->close();
	?> 
	

</body>


</html>
<?php
	session_start(); 

$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";


 $title="";
 $start_date="";
  
 $status = isset($_GET['status'])? " ORDER BY status":"";

 if(isset($_GET['title'])){
 	if(isset($_GET['status'])){
 		$title = ", title";
 	}else{
 		$title = " ORDER BY title";
 	}
 }
 
 if(isset($_GET['start_date'])){
 	if(isset($_GET['status']) || isset($_GET['title'])){
 		$start_date = ", start_date";
 	}else{
 		$start_date = " ORDER BY start_date";
 	}
 }

//query for admin
$conn = new mysqli($servername, $username, $password, $dbname); 
$sql = "SELECT * FROM projects" . $status . $title . $start_date;
$result = $conn->query($sql);


//query for users with no admin privileges
$user = $_SESSION['user'];
$sql2 = "SELECT * FROM projects,clients WHERE projects.client_id = clients.client_id AND clients.username ='$user' " . $status . $title . $start_date;
$resultClient = $conn->query($sql2);

?>

<html>
<head>
	<link rel="stylesheet" href="css/styleHome.css">
	<title>Welcome to Damavand!</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
										$conn = new mysqli($servername, $username, $password, $dbname); 
										$sql = "SELECT * FROM projects" . $status . $title . $start_date;
										$result = $conn->query($sql);
										//query for users with no admin privileges
										$user = $_SESSION['user'];
										$sql2 = "SELECT * FROM projects,clients WHERE projects.client_id = clients.client_id AND clients.username ='$user' " . $status . $title . $start_date;
										$resultClient = $conn->query($sql2);
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
		<div class="filters">
		Filters: 
			<form action="home.php" method="get">
			<input type="checkbox" name="status"> Status
			<input type="checkbox" name="title"> Title
			<input type="checkbox" name="start_date"> Start Date
			<input type="submit" value="Filter">
			</form>
		</div>

		<?php  
				if($_SESSION['privilege'] == 'Company'){

					while ($row=mysqli_fetch_array($result)) 
					{ 

					?>
					<div id="projectBox">

					<?php

					?><h1><?php echo strtoupper($row['title']);?></h1><?php
					?><div class="mainPic"><?php
					$file = 'images/project'. $row['project_id']. '/main.jpg';

					if (!file_exists($file)) {
					    $file = 'images/no_img.png';
					}				
					echo '<img src="'. $file. '"/>';
					?></div><?php
			 		?><div id="content">
			 			<?php
							?><p><b>Project#:</b> <?php echo $row['project_id'];?></p><?php 
					 		?><p><b>Actual Cost:</b> <?php echo $row['actual_cost'];?>$</p><?php 
					 		?><p><b>Status:</b> <?php echo $row['status'];?></p><?php 
					 		?><p><b>Type:</b> <?php echo $row['type'];?></p><?php 
							?><p><b>Start Date:</b> <?php echo $row['start_date'];?></p><?php 
			 			?>

			 		</div><?php	

			 		?><input type="button" class="infosButton" onclick="window.location='project.php?projectid=<?php echo $row['project_id']; ?>';" /><?php

					?>
					</div>
					<?php
			  	 	
					}  
				}else{  // if user is a client , he will only be able to see his own projects
					while ($rowClient=mysqli_fetch_array($resultClient)) 
					{ 

					?>
					<div id="projectBox">

					<?php

					?><h1><?php echo $rowClient['title']; ?></h1><?php
					?><div class="mainPic"><?php
					$file = 'images/project'. $rowClient['project_id']. '/main.jpg';

					if (!file_exists($file)) {
					    $file = 'images/no_img.png';
					}				
					echo '<img src="'. $file. '"/>';
					?></div><?php
			 		?><div id="content">
			 			<?php
							?><p><b>Project#:</b> <?php echo $rowClient['project_id'];?></p><?php 
					 		?><p><b>Actual Cost:</b> <?php echo $rowClient['actual_cost'];?></p><?php 
					 		?><p><b>Status:</b> <?php echo $rowClient['status'];?></p><?php 
					 		?><p><b>Type:</b> <?php echo $rowClient['type'];?></p><?php 
							?><p><b>Start Date:</b> <?php echo $rowClient['start_date'];?></p><?php 
			 			?>

			 		</div><?php	

			 		?><input type="button" class="infosButton" onclick="window.location='project.php?projectid=<?php echo $rowClient['project_id']; ?>';" /><?php

					?>
					</div>
					<?php
			  	 	
					}  
				}
			?>
	</div>
	<?php
	$conn->close();
	?> 
	

</body>


</html>
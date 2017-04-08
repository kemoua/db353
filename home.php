<?php
	session_start(); 

$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";

//query for admin
$conn = new mysqli($servername, $username, $password, $dbname); 
$sql = "SELECT * FROM projects";
$result = $conn->query($sql);


//query for users with no admin privileges
$user = $_SESSION['user'];
$sql2 = "SELECT * FROM projects,clients WHERE projects.client_id = clients.client_id AND clients.username ='$user' ";
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
										$sql = "SELECT * FROM projects";
										$result = $conn->query($sql);
										//query for users with no admin privileges
										$user = $_SESSION['user'];
										$sql2 = "SELECT * FROM projects,clients WHERE projects.client_id = clients.client_id AND clients.username ='$user' ";
										$resultClient = $conn->query($sql2);
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
				if($_SESSION['privilege'] == 'Company'){

					while ($row=mysqli_fetch_array($result)) 
					{ 

					?>
					<div id="projectBox">

					<?php

					?><h1><?php echo $row['title']; ?></h1><?php
					?><div class="mainPic"><?php
					$file = 'images/project'. $row['project_id']. '/main.jpg';

					if (!file_exists($file)) {
					    $file = 'images/no_img.png';
					}				
					echo '<img src="'. $file. '"/>';
					?></div><?php
			 		?><div id="content">
			 			<?php
					 		?><p>Actual Cost: <?php echo $row['actual_cost'];?></p><?php 
					 		?><p>Status: <?php echo $row['status'];?></p><?php 
					 		?><p>Type: <?php echo $row['type'];?></p><?php 
							?><p>Start Date: <?php echo $row['start_date'];?></p><?php 
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
					 		?><p>Actual Cost: <?php echo $rowClient['actual_cost'];?></p><?php 
					 		?><p>Status: <?php echo $rowClient['status'];?></p><?php 
					 		?><p>Type: <?php echo $rowClient['type'];?></p><?php 
							?><p>Start Date: <?php echo $rowClient['start_date'];?></p><?php 
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
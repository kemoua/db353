<?php
session_start();

$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";

$projectid = $_GET["projectid"];

$conn = new mysqli($servername, $username, $password, $dbname); 
$sql = "SELECT * FROM project WHERE project_id = '$projectid' ";
$result = $conn->query($sql);

 
?>

<html>
<head>
	<link rel="stylesheet" href="css/styleProject.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/modify_records.js"></script>
	<title>Project <?php echo $_GET["projectid"]; ?></title>
</head>
<body>
	<header> 
	<div id="logo" onclick="window.location = 'home.php';"></div>
		<h1>Project <?php echo $_GET["projectid"]; ?></title>
		<button onclick="window.location = 'index.php';">Logout</button>
	</header>

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
					   <input type='button' class="save_button" id="save_button<?php echo $row['project_id'];?>" value="save" onclick="save_row('<?php echo $row['project_id'];?>');">
						<?php
						}
					?></div>
					</div>
					<!-- Test queries response -->
					<input type="text" id="result">
					<?php
			  	 	
					}  
		?>
		</div>
	<?php
	$conn->close();
	?> 
</body>
</html>
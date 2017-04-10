<?php
session_start();


include 'config_server.php';

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
	<title>Billing</title>
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
			<div id="projectBox">
				<table id="table_order">
					<tr>
						<th>Order #</th><th>Phase</th><th>Total Cost</th><th>Date Order</th><th>Actual Cost</th>
					</tr>
			<?php  
				$conn = new mysqli($servername, $username, $password, $dbname); 
					$sql = "SELECT * FROM (SELECT payments.order_number, SUM(payments.amount_paid) as actual_cost FROM payments GROUP BY payments.order_number) as R INNER JOIN orders ON orders.order_number = R.order_number INNER JOIN phases ON orders.phase_id = phases.phase_id WHERE orders.project_id=$projectid";
				$result = $conn->query($sql);
				// $sql = "SELECT orders.order_number, phases.status,orders.total_cost,orders.date_order,R.actual_cost FROM (SELECT payments.order_number, SUM(payments.amount_paid) as actual_cost FROM payments GROUP BY payments.order_number) as R INNER JOIN orders ON orders.order_number = R.order_number INNER JOIN phases ON orders.phase_id = phases.phase_id WHERE orders.project_id=$projectid AND phases.project_id=$projectid";
				// echo $sql;
				while ($row=mysqli_fetch_array($result)) 
				{ 
				?>
	
						<tr>
							<th><a href="suborders.php?projectid=<?php echo $projectid; ?>&order=<?php echo $row['order_number']; ?>"><?php echo $row['order_number']; ?></a></th><th><?php echo $row['status'];?></th><th><?php echo $row['total_cost'];?></th><th><?php echo $row['date_order'];?></th><th><a href="payments.php?projectid=<?php echo $projectid; ?>&order=<?php echo $row['order_number']; ?>"><?php echo $row['actual_cost']; ?></a></th>
						</tr>						
					
					<br>
				<?php
				}  
				?>
			<?php
				$conn->close();
			?>
			</table>
			</div>
		</div>
</body>
</html>
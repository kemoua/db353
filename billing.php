<?php
session_start();


include 'config_server.php';

$projectid = $_GET["projectid"]; 
?>

<html>
<head>
	<link rel="stylesheet" href="css/styleHome.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/modify_orders.js"></script>
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
		        <li><a href="#">Contact</a></li>
			    <li><a href="#">MY ACCOUNT</a></li>
		        <li><a href="index.php">Logout</a></li>
		</ul>
				<script>
			function displayBox() {
			    div = document.getElementById('newProjectBilling');
			    div.style.display = "block";
			}
		</script>
		<div id="wrapper">
			<h1>Billing Section for project: <?php echo $projectid;?></h1>
		<a class='back' href="project.php?projectid=<?php echo $projectid;?>"><img border="0" src="images/arrow.png" width="80" height="80"></a> 
				<?php  
			if($_SESSION['privilege'] == 'Company'){
			?><a class='add' href="javascript:displayBox();"><img border="0" src="images/add.png" width="80" height="80">
			</a><?php
			}
			?>

					<div id="newBilling">
						<div id="newProjectBilling">
								<h2>Order #</h2>
								<label>Project Id #</label><input type="text" id="new_project_id" value="<?php echo $projectid; ?>" disabled>
								<label>Phase:</label><select id="new_phase">
									<?php  
										$conn2 = new mysqli($servername, $username, $password, $dbname); 
										$sql1 = "SELECT * FROM phases WHERE phases.project_id=$projectid";
										$result2 = $conn2->query($sql1);
											while ($row=mysqli_fetch_array($result2)) 
											{ 
									?>
												<option type="hidden" value="<?php echo $row['phase_id']; ?>"><?php echo $row['status']; ?>
												</option>
											<?php
										  	
											}  
											
											?>
									<?php
										$conn2->close();
									?>
														</select>
								<label>Date order:</label><input type="date" id="new_date_order">
								<label>Date delivered:</label><input type="date" id="new_date_delivered">
								<label>Total Cost:</label><input type="number" id="new_total_cost">								
								<input type="button" class="createButtonPhase" value="Create Order" onclick="create_billing();">
								<input type="button" class="cancelButtonPhase" value="Cancel" onclick="window.location.href = 'billing.php?projectid=<?php echo $projectid;?>';">
	
						</div>
					</div>


					<input type="hidden" id="result">

			<div id="projectBoxBilling">
				<table id="table_order">
					<h1>Orders</h1>
					<tr>
						<th>Order #</th><th>Phase</th><th>Total Cost</th><th>Date Order</th><th>Actual Cost</th>
					</tr>
			<?php  
				$conn = new mysqli($servername, $username, $password, $dbname); 
					$sql = "SELECT * FROM (SELECT payments.order_number, SUM(payments.amount_paid) as actual_cost FROM payments GROUP BY payments.order_number) as R INNER JOIN orders ON orders.order_number = R.order_number INNER JOIN phases ON orders.phase_id = phases.phase_id WHERE orders.project_id=$projectid";
				$result = $conn->query($sql);
						$num_rows = $result->num_rows;

						if($num_rows === 0){
							?><div id="projectBoxBillings">No Orders have been found for this project.</div><?php
						}				
				while ($row=mysqli_fetch_array($result)) 
				{ 
				?>
	
						<tr>
							<th><a href="suborders.php?projectid=<?php echo $projectid; ?>&order=<?php echo $row['order_number']; ?>"><?php echo $row['order_number']; ?></a></th>
							<th><p id="status_val<?php echo $row['order_number'];?>"><?php echo $row['status'];?></p></th>
							<th><p id="total_cost_val<?php echo $row['order_number'];?>"><?php echo $row['total_cost'];?></p></th>
							<th><p id="date_order_val<?php echo $row['order_number'];?>"><?php echo $row['date_order'];?></p></th>
							<th><a href="payments.php?projectid=<?php echo $projectid; ?>&order=<?php echo $row['order_number']; ?>"><?php echo $row['actual_cost']; ?></a></th>

							<?php
							if($_SESSION['privilege'] == 'Company'){
							?>
							<th><input type='button' id="delete_butt_billing<?php echo $row['order_number'];?>" class="delete_butt_billing" value ="" onclick="delete_billing(<?php echo $row['order_number'];?>);"></th>
							<th><input type='button' class="edit_butt_billing1" id="edit_butt_billing<?php echo $row['order_number'];?>" value="" onclick="edit_billing(<?php echo $row['order_number'];?>);"></th>

							<?php
							} 
							?>

						</tr>						
					
					<br>
				<?php

				

				?>
							 
												<input type='button' style="display: none;" class="save_button_billing" id="save_button_billing<?php echo $row['order_number'];?>" value="save" onclick="save_billing(<?php echo $row['order_number'];?>);">
							<input type='button' style="display: none;" class="cancel_button_billing" id="cancel_button_billing<?php echo $row['order_number'];?>" value="Cancel" onclick="cancel_edit_billing(<?php echo $projectid;?>);">					 	  		
				<?php 
					
				}  
				?>



			<?php
				$conn->close();
			?>
			</table>
			</div>
		</div>
		<input type="hidden" id="theprojectid" value="<?php echo $projectid;?>">
</body>
</html>
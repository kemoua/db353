<?php
session_start();


include 'config_server.php';

$projectid = $_GET["projectid"]; 
$order = $_GET["order"];
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
			<a class='back' href=""><img border="0" src="images/arrow.png" width="80" height="80"></a> 
			<div id="projectBoxSub">
			<h1>For Order# <?php echo $order;?></h1>
				<table class="suborderd" id="table_suborder<?php echo $row['sub_order_number'];?>">
				<tr>
					<th>Suborder #</th><th>Item</th><th>Quantity</th><th>Total Cost</th><th>Actual Cost</th>
				</tr>
			<?php  
				$conn = new mysqli($servername, $username, $password, $dbname); 
				$sql = "SELECT * FROM (SELECT payments.sub_order_number, SUM(payments.amount_paid) as actual_cost FROM payments GROUP BY payments.sub_order_number) as R INNER JOIN sub_orders ON sub_orders.sub_order_number = R.sub_order_number INNER JOIN items ON items.item_id=sub_orders.item_id WHERE sub_orders.order_number=$order ";
				$result = $conn->query($sql);
				// echo $sql;
				while ($row=mysqli_fetch_array($result)) 
				{ 
				?>
	
						<tr>
							<th><?php echo $row['sub_order_number']; ?></a></th><th><?php echo $row['name'];?></th><th><?php echo $row['quantity'];?></th><th><?php echo $row['cost'];?></th><th><a href="payments.php?projectid=<?php echo $projectid; ?>&suborder=<?php echo $row['sub_order_number']; ?>"><?php echo $row['actual_cost']; ?></a></th>
							<?php
							if($_SESSION['privilege'] == 'Company'){
							?>
							<th><input type='button' id="delete_butt_sub" value ="" class= onclick="delete_billing();"></th>
							<th><input type='button' class="edit_butt_sub" id="edit_butt_sub <?php /*truc ici*/?>" value="" onclick="delete_billing();"></th>
							<th><input type='button' style="display: none;" class="save_button_sub" id="save_button_sub" value="save" onclick="save_order();"></th>
							<th><input type='button' style="display: none;" class="save_button_sub" id="cancel_button_sub" value="Cancel" onclick="cancel_edit_billing();"></th>						 	  		

						<?php } ?>

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
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
	<script type="text/javascript" src="js/modify_suborders.js"></script>
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
			    div = document.getElementById('newPhase');
			    div.style.display = "block";
			}
		</script>
		<div id="wrapper">
			<h1>SubOrder Section for project: <?php echo $projectid;?></h1>

		<a class='back' href="billing.php?projectid=<?php echo $projectid;?>"><img border="0" src="images/arrow.png" width="80" height="80"></a> 
				<?php  
			if($_SESSION['privilege'] == 'Company'){
			?><a class='add' href="javascript:displayBox();"><img border="0" src="images/add.png" width="80" height="80">
			</a><?php
			}
			?>

					<div id="newPhase">
						<div id="projectBoxPhases">
								<h2>SubOrder #</h2>
								<label>Order #</label><input type="text" id="new_order_number" value="<?php echo $order; ?>" disabled>
								<label>Item:</label><select id="new_Item">
									<?php  
										$conn2 = new mysqli($servername, $username, $password, $dbname); 
										$sql1 = "SELECT * FROM items";
										$result2 = $conn2->query($sql1);
										
											while ($row=mysqli_fetch_array($result2)) 
											{ 
									?>
												<option value="<?php echo $row['item_id']; ?>"><?php echo $row['name'];?></option>
											<?php
										  	
											}  
											
											?>
									<?php
										$conn2->close();
									?>
														</select>
								<label>Cost:</label><input type="number" id="new_cost">	
								<label>Quantity:</label><input type="number" id="new_quantity">
							
								<input type="button" class="createButtonPhase" value="Create Order" onclick="create_suborders();">
								<input type="button" class="cancelButtonPhase" value="Cancel" onclick="window.location.href = 'suborders.php?projectid=<?php echo $projectid;?>&order=<?php echo $order;?>';">
	
						</div>
					</div>


					<input type="hidden" id="result">

			<div id="projectBoxBilling">
				<table id="table_order">
			<h1>For Order# <?php echo $order;?></h1>
				<table class="suborderd" id="table_suborder<?php echo $row['sub_order_number'];?>">
				<tr>
					<th>Suborder #</th><th>Item</th><th>Quantity</th><th>Total Cost</th><th>Actual Cost</th>
				</tr>
			<?php  
				$conn = new mysqli($servername, $username, $password, $dbname); 

				$sql = "SELECT * FROM (SELECT payments.sub_order_number, SUM(payments.amount_paid) as actual_cost FROM payments GROUP BY payments.sub_order_number) as R INNER JOIN sub_orders ON sub_orders.sub_order_number = R.sub_order_number INNER JOIN items ON items.item_id=sub_orders.item_id WHERE sub_orders.order_number=$order ";
				// echo $sql;
				$result = $conn->query($sql);
						$num_rows = $result->num_rows;

						if($num_rows == 0){
							?><div id="projectBoxBillings">No SubOrders have been found for this project.</div><?php
						}				
				while ($row=mysqli_fetch_array($result)) 
				{ 
				?>
	
						<tr>
							<th><p id="sub_order_number_val<?php echo $row['sub_order_number'];?>"><?php echo $row['sub_order_number']; ?></p></th>
							<th><p id="name_val<?php echo $row['sub_order_number'];?>"><?php echo $row['name'];?></p></th>
							<th><p id="quantity_val<?php echo $row['sub_order_number'];?>"><?php echo $row['quantity'];?></p></th>
							<th><p id="cost_val<?php echo $row['sub_order_number'];?>"><?php echo $row['cost'];?></p></th>
							<th><a href="payments.php?projectid=<?php echo $projectid; ?>&suborder=<?php echo $row['sub_order_number']; ?>"><?php echo $row['actual_cost']; ?></a></th>
							
							<?php
							if($_SESSION['privilege'] == 'Company'){
							?>
							<th><input type='button' id="delete_butt_billing<?php echo $row['sub_order_number'];?>" class="delete_butt_billing" value ="" onclick="delete_suborders(<?php echo $row['sub_order_number'];?>, <?php echo $order; ?> );"></th>
							<th><input type='button' class="edit_butt_billing1" id="edit_butt_billing<?php echo $row['sub_order_number'];?>" value="" onclick="edit_suborders(<?php echo $row['sub_order_number'];?>);"></th>
					 	  
							<?php
							} 
							?>

						</tr>						
							<input type='button' style="display: none;" class="save_button_sub" id="save_button_billing<?php echo $row['sub_order_number'];?>" value="save" onclick="save_suborders(<?php echo $row['sub_order_number'];?> , <?php echo $order; ?> );">
							<input type='button' style="display: none;" class="cancel_button_sub" id="cancel_button_billing<?php echo $row['sub_order_number'];?>" value="Cancel" onclick="cancel_edit_suborders(<?php echo $projectid;?>);">	
					<br>
				<?php

				

				?>
							 
							
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
		<input type="hidden" id="theorder" value="<?php echo $order;?>">
</body>
</html>
<?php
session_start();

include 'config_server.php';
$projectid = $_GET["projectid"]; 
$suborder = isset($_GET["suborder"])? $_GET["suborder"]:"";
?>

<html>
<head>
	<link rel="stylesheet" href="css/styleHome.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/modify_payment.js"></script>
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
		<script>
			function displayBox() {
			    div = document.getElementById('newPhase');
			    div.style.display = "block";
			}
		</script>
		<div id="wrapper">
			<h1>Billing Section for project: <?php echo $projectid;?></h1>

		<a class='back' href=""><img border="0" src="images/arrow.png" width="80" height="80">
					</a> 
				<?php  
			if($_SESSION['privilege'] == 'Company' && isset($_GET['suborder'])){
			?><a class='add' href="javascript:displayBox();"><img border="0" src="images/add.png" width="80" height="80">
			</a><?php
			}
			?>

					<div id="newPhase">
						<div id="projectBoxPhases">
								<h2>Payment #</h2>
								<label>SubOrder #</label><select id="new_sub_order_number">
									<?php  
										$conn2 = new mysqli($servername, $username, $password, $dbname); 
										$sql1 = "SELECT * FROM sub_orders INNER JOIN orders ON sub_orders.order_number=orders.order_number WHERE orders.project_id = $projectid";
										$result2 = $conn2->query($sql1);
											while ($row=mysqli_fetch_array($result2)) 
											{ 
									?>
												<option value="<?php echo $row['sub_order_number']; ?>"><?php echo $row['sub_order_number'];?></option>
											<?php
										  	
											}  
											
											?>
									<?php
										$conn2->close();
									?>
														</select>
								<label>Amount paid:</label><input type="number" id="new_amount_paid">	
								<label>Date of payment:</label><input type="date" id="new_date_of_payment">
							
								<input type="button" class="createButtonPhase" value="Create payment" onclick="create_payments();">
								<input type="button" class="cancelButtonPhase" value="Cancel" onclick="window.location.href = 'payments.php?projectid=<?php echo $projectid;?>&suborder=<?php echo $suborder;?>';">
	
						</div>
					</div>


			<div id="projectBoxPayment">
				<table id="table_payment">
					<tr>
						<th>Payment ID</th><th>Phase</th><th>Item</th><th>Amount Paid</th><th>Date of Payment</th>
					</tr>
			<?php  
				$conn = new mysqli($servername, $username, $password, $dbname); 
				if (isset($_GET["order"])) {
					$order = $_GET["order"];
					$sql = "SELECT * FROM payments INNER JOIN orders ON payments.order_number=orders.order_number INNER JOIN sub_orders ON payments.order_number=sub_orders.order_number INNER JOIN items ON  sub_orders.item_id=items.item_id INNER JOIN phases ON orders.phase_id = phases.phase_id WHERE payments.order_number=$order";
				}else{
					$sql = "SELECT * FROM payments INNER JOIN sub_orders ON payments.sub_order_number=sub_orders.sub_order_number INNER JOIN items ON  sub_orders.item_id=items.item_id INNER JOIN orders ON payments.order_number=orders.order_number INNER JOIN phases ON orders.phase_id = phases.phase_id WHERE payments.sub_order_number=$suborder";
				}
				// echo $sql;
				$result = $conn->query($sql);
				while ($row=mysqli_fetch_array($result)) 
				{ 
				?>
						<tr>
							<th><?php echo $row['payment_id']; ?></th><th><?php echo $row['status'];?></th><th><?php echo $row['name'];?></th><th><?php echo $row['amount_paid'];?></th><th><?php echo $row['date_of_payment'];?></th>
						<?php
							if($_SESSION['privilege'] == 'Company'){
							?>
							<!-- <th><input type='button' id="delete_payment" value ="" class= onclick="delete_billing();"></th> -->
							<!-- <th><input type='button' class="edit_payment" id="edit_payment<?php /*truc ici*/?>" value="" onclick="delete_billing();"></th> -->
							<th><input type='button' style="display: none;" class="save_button_payment" id="save_button_payment" value="save" onclick="save_payment();"></th>
							<th><input type='button' style="display: none;" class="cancel_button_payment" id="cancel_button_payment" value="Cancel" onclick="cancel_edit_payment();"></th>						 	  
							<?php
							} 

						?>					

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
				<input type="hidden" id="theprojectid" value="<?php echo $projectid;?>">
</body>
</html>
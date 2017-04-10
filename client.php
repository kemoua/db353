<?php
session_start();

$servername="localhost";
$username="root";
$password="root";
$dbname="comp353";

$clientid = $_SESSION["user"];

?>

<html>
<head>
	<link rel="stylesheet" href="css/styleHome.css">   
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
	<title>Project <?php echo $_GET["projectid"]; ?></title>
</head>
<body> 
<input type="hidden" id="result" name="">
<script>
	function editMode(){
		var input = document.getElementById("phone_number").value;
 
		document.getElementById("phone_number").innerHTML = '<input type="text" id="new_phone"> '; 
		document.getElementById("phone_number").style.fontSize = "20px";

		//hide button edit
		document.getElementById("editbut").style.display = "none";
		document.getElementById("save_button").style.display = "block"; 
		document.getElementById("cancel_button").style.display = "block";

	}
	function editPhone(){
		var input = document.getElementById("new_phone").value;
		var user = '<?php echo $clientid;?>';
		$.ajax
		 ({
		  type:'post',
		  url:'modify_records.php',
		  data:{
		  editPhone:'editPhone',
		   phonenumber:input,
		   username:user
		  },
		  success:function(response) {
		  	document.getElementById("result").value=response;
		   if(response=="success")
		   {
		    window.location.href = "client.php";
		   }
		  }
		 });

	}

</script>

<a href="javascript:void(0);" id="scroll" title="Scroll to Top" style="display: none;">Top<span></span></a>
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
		                        </li>
		                        <?php
		                        if($_SESSION['privilege'] == 'Company'){
		                        	?><li><a href="create.php">Create</a></li>
		                        <?php }?>
		                </ul>
		        </li>
		        <li><a href="about.php">About</a></li>
		        <li><a href="contact.php">Contact</a></li>
		        <li><a href="client.php">My Account</a></li> 
		        <li><a href="index.php">Logout</a></li>
		</ul>

	<div id="wrapper"> 
		<div id="client_box">
		<h1>Your Informations:</h1>
		<?php   

			$conn = new mysqli($servername, $username, $password, $dbname); 
			$sql = "SELECT * FROM clients WHERE username = '$clientid' ";
			$result = $conn->query($sql);
 
		while ($row=mysqli_fetch_array($result)){ 
				?><label>First Name:</label><p id="p_first"><?php echo $row['first_name'];?></p><?php 
				?><label>Last Name:</label><p id="p"><?php echo $row['last_name'];?></p><?php 
				?><label>Civic Number:</label><p id="p"><?php echo $row['civic_number'];?></p><?php 
				?><label>Street #:</label><p id="p"><?php echo $row['Street'];?></p><?php 
				?><label>Postal Code:</label><p id="p"><?php echo $row['postal_code'];?></p><?php 
				?><label>Country:</label><p id="p"><?php echo $row['country'];?></p><?php 
				?><label>Phone</label><p id="phone_number"><?php echo $row['phone'];?></p><?php 
				?><label>Username</label><p id="p"><?php echo $row['username'];?></p><?php 
		} 				
		?>
			<div class="action_btns_tasks">
			<?php 

			if($_SESSION['privilege'] == 'Company'){
			?>
			  <input type='button' class="edit_button2" id="editbut" value="" onclick="editMode();">
		 	  <input type='button' style="display: none;" class="save_button" id="save_button" value="save" onclick="editPhone()" />
		   	  <input type='button' style="display: none;" class="save_button" id="cancel_button" value="Cancel" onclick="javascript:location.href='client.php'" >						 	  
			<?php 
			} 
			?>
							
						
			</div>
		</div>
	</div>
</body>
</html>
<?php
	session_start(); 

	$servername="localhost";
	$username="root";
	$password="root";
	$dbname="comp353";
 
?>
<html>
<head>
	<link rel="stylesheet" href="css/styleHome.css">     

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
	<title>Contact Us</title>
</head>
<body>
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
		<div ="wrapper">
			<div id="contact_box">
				<h1>Contact Us!</h1>
				<div id="textcontact">
					We thank you for your interest in Damavand. 
					If you have questions, comments, concerns, or well-wishes for the ministry of Damavand or its staff, 
					please use the form below.</br></br>

					If you are having technical trouble with the website, please contact our customer service at 1-800-123-4543.
					<div id="formContact">
					 <form action="/action_page.php">

					    <label for="fname">First Name</label>
					    <input type="text" id="fname" name="firstname" placeholder="Your name..">

					    <label for="lname">Last Name</label>
					    <input type="text" id="lname" name="lastname" placeholder="Your last name..">

					    <label for="email">Email</label> 
					    <input type="text" id="femail" name="firstname" placeholder="Your email..">


					    <label for="subject">Subject</label>
					    <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

					    <input type="submit" value="Submit">
					   </form>

					</div>
				</div>
			</div>
		</div>
	<body>
</html>
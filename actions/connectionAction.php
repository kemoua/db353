<?php 
	session_start();

if (isset($_POST["member-conn"])){
	if(!empty($_POST["uname"]and !empty($_POST["passw"]))){

		$servername = "localhost";
		$username = "root";
		$password = "root";
		$dbname = "comp353"; 

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) { 
		    die("Connection failed: " );
		}   

		$table = "users";
		$user = $_POST["uname"];
		$password = sha1($_POST["passw"]); 

		$sql = "SELECT * FROM $table WHERE username = '$user' AND password = '$password'";

		$result = $conn->query($sql) or die($conn->error);


		$row = $result->fetch_assoc();

		//if it returns data
		if( mysqli_num_rows($result) > 0){
			//if here it means the user successfully logged in
			$_SESSION["user"] = $user;
			$_SESSION["password"]= $password;  
			$_SESSION["privilege"] =$row["privilege"];  
			
			header('location:../home.php');
			// header should be the first thing you do. if you output anythin
			// to the browser, the headers are locked and u cannot set them anymore.
			exit();

		}
		else{ 
			//user needs to try again
			header('location:../index.php');
			session_destroy();
			exit();
		}
	}
	else{
		echo "PAS BON RENTRE UN PASS";
	}
} 
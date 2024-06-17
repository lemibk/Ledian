<?php
// Include config file
require "connection.php";
$message;
$message1;

   

  
  //catch exception
  
// Get form data
$user_name = $_POST['username'];
$first_name = $_POST['fristname'];
$last_name = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
// Hash the password

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $link->prepare("INSERT INTO signup (username, fristname, lastname, email, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $user_name, $first_name, $last_name, $email, $hashed_password);
// Execute the statement
try{
    if ($stmt->execute()){
    $message= "Account  created successfully";
    $message1="Click OK to Login";
    $btxt="Continue";
    $header="../signin.html";}
}catch(Exception $e) {
    
    $message= "<h1>Error:</h1> <br> <h1>The Usename you're trying to use <br> Is in use</h1> ";
    $message1="Click Retry";
    $header="../signup.html";
    $btxt="Retry";
}




// Close the connection
$stmt->close();
$link->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
	<div class="popup">
		<h1><?php echo $message;?></h1>
		<h1><?php echo $message1;?></h1>
		<button class="btn"   onclick="window.location.href='<?php echo $header;?>';"><?php echo $btxt;?></button>
	</div>
</div>
</body>
</html>
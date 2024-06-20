<?php

$link = mysqli_connect('localhost', 'root', '', 'ledian');
$user_name = $_POST['username'];
$plain = $_POST['password'];
$sql ="SELECT username,password from signup where username='$user_name'";

$result =  mysqli_query($link, $sql);
$dbret =$result->fetch_assoc();

$dbpass= $dbret['password'];

$verify = password_verify($plain, $dbpass); 


if($verify){
$message="Login Successfull";
$message1="You can Continue Your Shopping With us have a nice time";
$header="../index.html";
}
else{
$message= "invalid credentials";
$message1="Check your password and username then retry";
$header="../signin.html";
}
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
		<button class="btn"   onclick="window.location.href='<?php echo $header;?>';">close</button>
	</div>
</div>
</body>
</html>
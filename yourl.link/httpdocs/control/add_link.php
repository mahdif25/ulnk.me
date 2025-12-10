<?php
include 'main.php';
check_loggedin($pdo);

// output message (errors, etc)
$msg = '';
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
// Handle edit profile post data


if (isset($_POST['title'], $_POST['url'], $_POST['asin'], $_POST['mass'], $_POST['note'])) {
	// Make sure the submitted registration values are not empty.
/*
	if (empty($_POST['username']) || empty($_POST['email'])) {
		$msg = 'The input fields must not be empty!';
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$msg = 'Please provide a valid email address!';
	} else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
	    $msg = 'Username must contain only letters and numbers!';
	} else if (!empty($_POST['password']) && (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5)) {
		$msg = 'Password must be between 5 and 20 characters long!';
	} else if ($_POST['cpassword'] != $_POST['password']) {
		$msg = 'Passwords do not match!';
	}
*/
		// Check if new username or email already exists in database
		$sqll = "INSERT INTO `links` (`id`, `idd`, `title`, `url`, `asin`, `mass`, `note`, `timo`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($sqll);
		$stmt->execute([ uniqid(), $_POST['title'], $_POST['url'], $_POST['asin'], $_POST['mass'], $_POST['note'], time() ]);
		 header('Location: home.php');
	     exit();
	
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Home</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Website Title</h1>
				<a href="home.php"><i class="fas fa-home"></i>Home</a>
			
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		

		
		<div class="content profile">
			<h2>Add New Link</h2>
			<div class="block">
				<form action="add_link.php" method="post">
					<label style="color: #4a536e;" for="username">Title</label>
					<input type="text"  name="title" id="title" placeholder="science-kit">
					
					<label style="color: #4a536e;" for="username">Amazon URL</label>
					<input type="text"  name="url" id="url" placeholder="https://www.amazon.com/science-kit/s?k=science+kit">

					<label style="color: #4a536e;" for="username">Asin</label>
					<input type="text"  name="asin" id="asin" placeholder="B07VN75JFC">

					<label style="color: #4a536e;" for="username">Mass</label>
					<input type="text"  name="mass" id="mass" placeholder="maas=maas_adg_37F...">

					<label style="color: #4a536e;" for="username">Note</label>
					<input type="text"  name="note" id="note" placeholder="science ads bla bla bla">
					
					<br>
					<input class="profile-btn" type="submit" value="Save">
					<p><?=$msg?></p>
				</form>
			</div>
		</div>
		
	</body>
</html>

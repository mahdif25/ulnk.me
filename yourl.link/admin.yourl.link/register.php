<?php
include 'main.php';
// No need for the user to see the login form if they're logged-in, so redirect them to the home page
if (isset($_SESSION['loggedin'])) {
	// If the user is not logged in, redirect to the home page.
    header('Location: home.php');
    exit;
}
// Also check if they are "remembered"
if (isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme'])) {
	// If the remember me cookie matches one in the database then we can update the session variables and the user will be logged-in.
	$stmt = $pdo->prepare('SELECT * FROM accounts WHERE rememberme = ?');
	$stmt->execute([ $_COOKIE['rememberme'] ]);
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($account) {
		// Authenticate the user
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $account['username'];
		$_SESSION['id'] = $account['id'];
        $_SESSION['role'] = $account['role'];
		// Update last seen date
		$date = date('Y-m-d\TH:i:s');
		$stmt = $pdo->prepare('UPDATE accounts SET last_seen = ? WHERE id = ?');
		$stmt->execute([ $date, $account['id'] ]);
		// Redirect to home page
        header('Location: home.php');
		exit;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Register</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="register">

			<h1>Register</h1>

			<div class="links">
				<a href="index.php">Login</a>
				<a href="register.php" class="active">Register</a>
			</div>

			<form action="register-process.php" method="post" autocomplete="off">

				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>

				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>

				<label for="cpassword">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="cpassword" placeholder="Confirm Password" id="cpassword" required>

				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Email" id="email" required>

				<div class="msg"></div>

				<input type="submit" value="Register">

			</form>

		</div>

		<script>
		// AJAX code
		let registrationForm = document.querySelector('.register form');
		registrationForm.onsubmit = event => {
			event.preventDefault();
			fetch(registrationForm.action, { method: 'POST', body: new FormData(registrationForm) }).then(response => response.text()).then(result => {
				if (result.toLowerCase().includes("autologin")) {
					window.location.href = "home.php";
				} else {
					document.querySelector(".msg").innerHTML = result;
				}
			});
		};
		</script>		
	</body>
</html>
<?php
include 'main.php';
check_loggedin($pdo);
$stmt = $pdo->prepare('SELECT * FROM links');
$stmt->execute();
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
				<a href="add_link.php"><i class="fas fa-user-circle"></i>Add Link</a>
				
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		

		
		<div class="content profile">
			<h2>List of Links</h2>
			


       			<?php foreach ($accounts as $account): ?>
					<div class="block">
						<p> <b style="color: #acc0d1;"> Id :</b> #<?=$account['id']?> | <b style="color: #acc0d1;">Title : </b><?=$account['title']?> | <b style="color: #acc0d1;">Created : </b><?=$account['timo']?></p>
						<p><b style="color: #acc0d1;">Url : </b><?=$account['url']?> | <b style="color: #acc0d1;">Asin : </b><?=$account['asin']?></p>
						<p><b style="color: #acc0d1;">Note : </b><?=$account['note']?></p>
						<p> <b style="color: blue;">URL : </b>https://vmi714834.contaboserver.net/go.php?id=<?=$account['idd']?></p>
						<p><b style="color: #acc0d1;">Edit / Remove</b></p>

					</div>
                <?php endforeach; ?>

			
		</div>
		
	</body>
</html>

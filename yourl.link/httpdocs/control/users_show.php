<?php
include 'main.php';
//check_loggedin($pdo);
$stmt = $pdo->prepare('SELECT * FROM `ip_track3r`');
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

		

		
		<div class="content profile">
			<h2>List of Links</h2>
			
  <table class="table">
    <thead>
      <tr>
        <th>ip</th>
        <th>data</th>
        <th>time</th>
      </tr>
    </thead>
    <tbody>





       			<?php foreach ($accounts as $account): ?>
			
	<tr>
        <td><a href="https://whatismyipaddress.com/ip/<?=$account['ip']?>" target="_blank"><?=$account['ip']?></a> 
</td>
		<td><textarea id="w3review" name="w3review" rows="3" cols="50">
<?=$account['data']?>
</textarea></td>
        <td> <?php echo date('m/d/Y H:i:s', $account['time']);?></td>
        
      </tr>
			
					
                <?php endforeach; ?>

    </tbody>
  </table>
			
		</div>
		
	</body>
</html>

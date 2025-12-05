<?php
include 'main.php';
check_loggedin($pdo);

$arr = [];

foreach ($_POST as $key => $value) {
//	echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
	
	if (str_contains($key, "_v")) {
		
		$t1 = str_replace("n_","",$key);
		$t2 = str_replace("_v","",$t1);
		

		$a =     [
					"url"    =>  $_POST['n_'.$t2.'_url'],
					"open"    => 0,
					"per"     =>  $_POST['n_'.$t2.'_v'],
					"cur_per" => 0,
				] ;

		array_push($arr, $a);

	}
}


if (count($arr) !== 0) {
    		// Check if new username or email already exists in database
// INSERT INTO `rotator` (`id`, `name`, `links`, `time`, `short`) 
// VALUES (NULL, 'namee', 'links listo', 'timo', 'shooortoo');
		$new_arr = json_encode($arr);
		$sqll = "INSERT INTO `rotator` (`id`, `name`, `links`, `time`, `short`, `user_id`) VALUES (NULL, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($sqll);
		$stmt->execute([ $_POST['title'], $new_arr,  time(), uniqid(), $_SESSION['id']  ]);
		 header('Location: links_rotator.php?add=1');
	     exit();
}




?>


<?php
//$time_start = microtime(true); 

if (isset($_GET['id'])) {
}else{echo 'Error in url id !' ; exit;}
include 'control/main.php';

/////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////
$idd = $_GET['id'] ;
$stmt = $pdo->prepare('SELECT * FROM rotator WHERE short = ?');
$stmt->execute([ $idd  ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
if ($account) {
	// 
}else{
	echo 'Error in url id .' ; exit;
}

//////////////////////////////////////////////////////////
						/*
						 "url":"http:\/\/url.url1",
						  "open":0,
						  "per":70,
						  "cur_per":0
						*/

// links = [ ['a',0,40,0], ['b',0,22,0], ['c',0,20,0], ['d',0,10,0] , ['e',0,8,0] ]

$links=array();
$arr = json_decode($account['links'] , true );

foreach($arr as $item) {
	$b = array();
	array_push($b,$item['url'], $item['open'], $item['per'], $item['cur_per']);
	array_push($links,$b);
}
					 		
// echo  $links[0][2] .'<br>' ;
// print_r($links);
$len_ = count($links) ;
$len_0 = $len_ - 1 ;


// echo 'hh';
////////////////////////////////
$i = 0 ;
    for ($k = 0; $k < $len_; $k++) {
    
        $i = $i + $links[$k][1]  ;
	}


	$val_f = 'none';
	// echo $i;
    for ($k = 0; $k < $len_; $k++) {
    
        $v1 = $links[$k][1] + 1 ;
        $prc_ = calc_per($v1, $i) ;
        $prv_ = $links[$k][2]  ;
        $val_ = 'Good' ;
        if ($prc_ > $prv_){
            $val_ = 'Bad' ;
		}else{
            $val_f = $k ;
		}
        // echo $k . ':'.$prc_  . ':' . $prv_ . '>'. $val_ .'<br>';
	}
    if ($val_f == 'none') {
        $y =rand(0, $len_0) ;
	}else{ 
        $y = $val_f;
	}
	// echo 'val :'. $val_f .':>'. $y. '<br>'  ;
    $v1 = $links[$y][1] ;
    $links[$y][1] = $v1 + 1 ;
    
    for  ($j = 0; $j < $len_; $j++) {
        $links[$j][3] = calc_per($links[$j][1], $i) ;
	}
    // print_r($links);
			
    	// echo $links[$y][0];


////////////////////////////////







$arr = [];
    for ($k = 0; $k < $len_; $k++) {
			$a =     [
					"url"     =>  $links[$k][0],
					"open"    =>  $links[$k][1],
					"per"     =>  $links[$k][2],
					"cur_per" =>  $links[$k][3],
				] ;
			array_push($arr, $a);
	}





		$new_arr = json_encode($arr);
	
	
				$stmt = $pdo->prepare('UPDATE rotator SET links = ? WHERE short = ?');
				$stmt->execute([ $new_arr, $idd ]);
	
header("Location: ".$links[$y][0]);
die();
exit;

////////////////////////////////////
function calc_per($a, $b){
	if ($b == 0){$b = 1 ;}
	return (int) (($a /$b) * 100);
}
?>
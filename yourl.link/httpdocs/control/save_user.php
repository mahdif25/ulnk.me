<?php
include 'main.php';

$a = getRealIpAddr();
$b = json_encode($_SERVER);
$c = time();	



		$sqll = "INSERT INTO `ip_track3r` (`id`, `ip`, `data`, `time`) VALUES (NULL, ?, ?, ?)";
		$stmt = $pdo->prepare($sqll);
		$stmt->execute([ $a, $b, $c ]);

header("Location: https://www.amazon.com");
exit();
function getRealIpAddr(){
 if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
  // Check IP from internet.
  $ip = $_SERVER['HTTP_CLIENT_IP'];
 } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
  // Check IP is passed from proxy.
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
 } else {
  // Get IP address from remote address.
  $ip = $_SERVER['REMOTE_ADDR'];
 }
 return $ip;
}
?>

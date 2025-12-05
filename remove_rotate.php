<?php
include 'main.php';
check_loggedin($pdo);


 if (isset($_POST['link_id'], $_POST['done'])) {
	 
	 // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	$stmt = $pdo->prepare('SELECT * FROM `rotator` WHERE `short` = ? and  `user_id` = ? ');
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->execute([ $_POST['link_id'] ,$_SESSION['id'] ]);
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
	// Check if the account exists:
	if ($account) {
		$stmt = $pdo->prepare("DELETE FROM `rotator` WHERE `short` = ?");
		$stmt->execute([ $_POST['link_id']  ]);
	
		header('Location: links_rotator.php?del=1');
	     exit();
		
	
	}else{
		echo '<br><br><h1>Link Not found !</h1>' ;
		exit;
	}	
	 
	 
 
 }

if (isset($_GET['id'])) {
}else{echo 'Error in url id !' ; exit;}


//////////////////////////////////////////////////////////////////////
$idd = $_GET['id'] ;
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $pdo->prepare('SELECT * FROM `rotator` WHERE `short` = ? and  `user_id` = ? ');
// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->execute([ $idd ,$_SESSION['id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if the account exists:
if ($account) {
	
}else{
echo '<br><br><h1>Link Not found !</h1>' ;
exit;
}	


include "head.php";
include "menu.php";
include "navbar.php";

?>

		

		












          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-fluid flex-grow-1 container-p-y">

				<div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                  
                  
                   
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Link Details</h5>
                    <!-- Account -->
                    <div class="card-body">
        
						
									<br><center ><h2 style="color:red;">Are you sure you wanna Remove the link ?</h2></center>
			
       			
							       <div class="card shadow-none bg-transparent border border-info mb-3">
      <div class="card-body">
<p> <b style="color: #acc0d1;"> Id :</b> #<?=$account['id']?> | <b style="color: #acc0d1;">Title : </b><?=$account['name']?> | <b style="color: #acc0d1;">Created : </b><?= date('m/d/Y H:i:s', $account['time']);?>    <b style="color: blue;">URL : </b>https://yourl.link/visit.php?id=<?=$account['short']?></p> 
					<?php	$arr = json_decode($account['links'] , true );
						/*
						 "url":"http:\/\/url.url1",
						  "open":0,
						  "per":70,
						  "cur_per":0
						*/

							foreach($arr as $item) { //foreach element in $arr
								$var1 = $item['url'];
								$var2 = $item['open'];
								$var3 = $item['per'];
								$var4 = $item['cur_per'];
								//echo '<br>'. $var1 .' , '. $var2 .' , '. $var3 .' , '. '<br>' ;
echo '<p> <b style="color: blue;">URL : </b> '.$var1.' </p>';
echo '<p><b style="color: #acc0d1;">Open : </b>'.$var2.'| <b style="color: #acc0d1;">percentage  : </b>'.$var3.' | <b style="color: #acc0d1;">Current percentage  : </b>'.$var4.' </p> ';

}
							
						
						
						?>
						
			</div>			
      </div>
						
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                      <form action="remove_rotate.php" method="post">
					 <input type="hidden" id="done" name="done" value="1">
					<input type="hidden" id="link_id" name="link_id" value="<?=$account['short']?>">
                        <div class="mt-2">
                          <button type="submit" value="Remove" class="btn btn-danger btn-buy-now">Yes ,Remove it</button>
                          
                        </div>
                      </form>
						
				
						
						
                    </div>
                    <!-- /Account -->
                  </div>
     
                </div>
              </div>
				
            </div>
            <!-- / Content -->

<?php
include "foot.php";
?>
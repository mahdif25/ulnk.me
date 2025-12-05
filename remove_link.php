<?php
include 'main.php';
check_loggedin($pdo);


 if (isset($_POST['link_id'], $_POST['done'])) {

	 // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	$stmt = $pdo->prepare('SELECT * FROM `links` WHERE `idd` = ? and  `user_id` = ? ');
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->execute([ $_POST['link_id'] ,$_SESSION['id'] ]);
	$account = $stmt->fetch(PDO::FETCH_ASSOC);
	// Check if the account exists:
	if ($account) {
		$stmt = $pdo->prepare("DELETE FROM `links` WHERE `idd` = ?");
		$stmt->execute([ $_POST['link_id']  ]);
	
		header('Location: home.php?del=1');
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
$stmt = $pdo->prepare('SELECT * FROM `links` WHERE `idd` = ? and  `user_id` = ? ');
// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->execute([ $idd ,$_SESSION['id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if the account exists:
if ($account) {
	
}else{
echo '<br><br><h1>Link Not found .!</h1>' ;
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
			
    <table class="table table-striped">
      <thead>
        <tr>
		<th>created</th>
          <th>Asin</th>
          <th>Clicks</th>
          <th>title</th>
          <th>Keyword</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">

       			
		  							<?php $ii = $ii  + 1;
						$key_0 =  explode("=",$account['url']);
						//$title_0 =  explode("/",$account['url']);
						$key_1 = str_replace("+"," ",$key_0[1]) ;
						//$title_1 = str_replace("-"," ",$title_0[3]) ;
						
						?>
		  
		        <tr>
					<td> <?= date('m/d/Y H:i:s', $account['timo']);?> </td>
					
					          <td>
<small><?=$account['asin']?></small>
          </td>
				 <td><span class="badge bg-label-primary me-1"><?=$account['clicks']?></span></td>	
          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><small><?=$account['title']?></small></strong></td>
          <td><small><?=$key_1?></small></td>

     
        </tr>
               

		  



		  

      </tbody>
    </table>
						
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                      <form action="remove_link.php" method="post">
					 <input type="hidden" id="done" name="done" value="1">
					<input type="hidden" id="link_id" name="link_id" value="<?=$account['idd']?>">
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
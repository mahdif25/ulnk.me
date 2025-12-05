<?php

include "head.php";
include "menu.php";
include "navbar.php";
include 'main.php';
check_loggedin($pdo);

if (isset($_POST['title'], $_POST['url'], $_POST['asin'], $_POST['mass'], $_POST['note'])) {
	
		$domain_ = $_POST['domain'] ;
		$gcid = isset($_POST['gcid']) ? 1 : 0;
	
		$link_id = $_POST['link_id'] ;
		$idd = $link_id ;
		$stmt = $pdo->prepare('SELECT * FROM links WHERE `idd` = ? and  `user_id` = ? ');
		$stmt->execute([ $idd ,$_SESSION['id'] ]);
		$account = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($account) {
		}else{
			echo '<br><br><h1>Link Not found !</h1>' ;
			exit;
		}	
	

		$title = str_replace(" ","-",$_POST['url']) ;
		$url1  = str_replace(" ","+",$_POST['url']) ;
		// https://www.amazon.com/play-money-kids/s?k=play+money+for+kids
		$url_ = 'https://www.amazon.'.$domain_.'/'.$title.'/s?k='.$url1 ;
		//$url_ = 'https://www.amazon.com/'.$title.'/s?k='.$url1 ;
				$stmt = $pdo->prepare('UPDATE links SET  title = ?, url = ?, asin = ?, mass = ?, note = ?, updato = ?, gcid_ = ? WHERE idd = ?');
				$stmt->execute([ $_POST['title'], $url_, $_POST['asin'], $_POST['mass'], $_POST['note'],time(), $gcid, $link_id  ]);

    echo '<script> document.location.href="/home.php?edit=1"; </script>' ;
    die();
	exit();
	
}




if (isset($_GET['id'])) {
}else{echo 'Error in url id !' ; exit;}


//////////////////////////////////////////////////////////////////////
$idd = $_GET['id'] ;

$stmt = $pdo->prepare('SELECT * FROM links WHERE `idd` = ? and  `user_id` = ? ');

$stmt->execute([ $idd ,$_SESSION['id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if ($account) {
	
}else{
echo '<br><br><h1>Link Not found !</h1>' ;
exit;
}	



include 'head1.php' ;

$key_0 =  explode("=",$account['url']);
$key_1 = str_replace("+"," ",$key_0[1]) ;

$domain_0 =  explode("www.amazon.",$account['url']);
$domain_1 =  explode("/",$domain_0[1]);
$domain_ = $domain_1[0] ;

$is_checked = '' ;
if ( $account['gcid_'] == 1 ){
	$is_checked = 'checked' ;
}

$domainOptions = array(
    'com' => '[com] Default',
    'de' => '[de] german',
    'es' => '[es] spain',
    'co.uk' => '[co.uk] uk',
    'it' => '[it] italy',
    'fr' => '[fr] france',
    'ca' => '[ca] canada',
    'nl' => '[nl] netherlands',
    'se' => '[se] sweden'
);

?>


		







          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-fluid flex-grow-1 container-p-y">

				<div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                  
                  
                   
                  </ul>
					
					
					
					
					
<div class="row">
  <!-- Basic Layout -->
  <div class="col-xxl">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Link</h5> <small class="text-muted float-end">Link id : <?=$account['idd']?></small>
      </div>
      <div class="card-body">
        <form action="edit_link.php" method="post">
			<input type="hidden" id="link_id" name="link_id" value="<?=$account['idd']?>">
			
			
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="title">Domain</label>
            <div class="col-sm-4">
				<?php
	
						// Selected domain
						$selectedDomain = $domain_ ;

						// HTML output with dynamically set selected value
						echo '<select name="domain" id="domain" class="form-select" data-np-intersection-state="visible">';
						foreach ($domainOptions as $value => $label) {
							echo '<option value="' . $value . '"';
							if ($value == $selectedDomain) {
								echo ' selected="selected"';
							}
							echo '>' . $label . '</option>';
						}
						echo '</select>';
				?>
				
            </div>
          </div>			
			
			
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="title">Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="title" id="title"  value="<?=$account['title']?>" />
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="title">Amazon keyword</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name="url" id="url" value="<?=$key_1?>" />
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="title">Asin</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="asin" id="asin"  value="<?=$account['asin']?>" />
            </div>
          </div>
			
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="title">Mass</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name="mass" id="mass"  value="<?=$account['mass']?>" />
            </div>
          </div>
			
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="title">Note</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"   name="note" id="note"  value="<?=$account['note']?>" />
            </div>
          </div>

			
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="title">Google Click ID</label>
            <div class="col-sm-10">
				<div class="col-3 form-check form-switch mb-2"> 
					  <input class="form-check-input" type="checkbox" name="gcid" id="gcid" <?=$is_checked?> >
				</div>	
            </div>
			  
			  
			  
          </div>			
			
			
		<br><br>
			
			
          <div class="row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>	
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					

              </div>
				
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>
            <!-- / Content -->

<?php
include "foot.php";
?>
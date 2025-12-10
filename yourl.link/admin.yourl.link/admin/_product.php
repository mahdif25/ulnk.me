<?php
include 'main.php';

include 'head.php';
include 'menu.php';

/////////////////////////////////////////////////

// If editing an account
if (isset($_GET['id'])) {
    // Get the account from the database
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // ID param exists, edit an existing account
    $page = 'Update';
    if (isset($_POST['submit'])) {
        // Update the account
        $timo = time() ;
        $stmt = $pdo->prepare('UPDATE products SET name = ?, Description = ?, logo = ?, api_key = ?, last_update = ? WHERE id = ?');
       $stmt->execute([ $_POST['name'], $_POST['desc'], $_POST['logo'], $_POST['api'],$timo, $_GET['id'] ]);
		echo "<script>window.location.href='_clients.php?success_msg=2';</script>";
        header('Location: _clients.php?success_msg=2');
        exit;
    }
    if (isset($_POST['delete'])) {
        // Redirect and delete the account
		    // Delete the account
			$stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
			$stmt->execute([  $_GET['id'] ]);
			echo "<script>window.location.href='_clients.php?success_msg=3';</script>";
			header('Location:_clients.php?success_msg=3'); 
	        exit;
    }
} else {
    // Create a new account
	// name,desc,logo,api,
    $page = 'Create';
	$timo = time() ;
	if (isset($_POST['submit'])) {
		//************************************************
			$target_dir = "uploado/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			$filo_name = $timo .'.'.$imageFileType;
			$target_file = $target_dir . $filo_name ;
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			  if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			  } else {
				echo "File is not an image.";
				$uploadOk = 0;
			  }
			}

			// Check if file already exists
			if (file_exists($target_file)) {
			  echo "Sorry, file already exists.";
			  $uploadOk = 0;
			}

			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
			  echo "Sorry, your file is too large.";
			  $uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			  $uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			  echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			  } else {
				echo "Sorry, there was an error uploading your file.";
			  }
			}
		//************************************************
		$client0 = explode(":",$_POST['client']) ;
        $stmt = $pdo->prepare('INSERT IGNORE INTO products 
(seller_id ,seller_name ,asin_id ,image ,free_asin_list ,time_ ,deals ,max_deals ) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([ $client0[0],$client0[1], $_POST['asin'], $filo_name, $_POST['free_asin'],$timo ,0,$_POST['max_deals'] ]);
		echo "<script>window.location.href='_clients.php?success_msg=1';</script>";
        header('Location:_clients.php?success_msg=1');
        exit;
    }else{
	
		/////////////////////////////////////////////////
		// Prepare accounts query
		$stmt = $pdo->prepare('SELECT * FROM clients ORDER BY `clients`.`id` DESC');
		$stmt->execute();
		// Retrieve query results
		$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
		/////////////////////////////////////////////////
	}
}


/////////////////////////////////////////////////
		if (isset($_GET['del'])) {
				$btn_form =  '<p class="text-danger">Are you sure you want to remove this client </p>
				<br><input class="btn btn-danger" type="submit" name="delete" value="Yes ,Remove it">	';
				$input_st = 'disabled' ;
			}else{
				$btn_form =   '<input class="btn btn-info" type="submit" name="submit" value="'.$page.'">	';
				$input_st = 'required' ;
			}

			
			
?>


			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Clients List</h1>

					<div class="row">
						<div class="col-12 col-lg-10">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">Empty card</h5>
								</div>
									
							
								<div class="card-body">
    <form action="" method="post" class="form responsive-width-100"  enctype="multipart/form-data">
		
<div class="mb-3">
			<label class="form-label" style="color:#0088ff">Client</label>
				<select name="client" id="client">
					<?php if (!$clients): ?>
                			<option value="0">There's no client!</option>
              		<?php endif; ?>
                	<?php foreach ($clients as $client): ?>

                    <option value="<?=$client['id']?>:<?=$client['name']?>"><?=$client['name']?></option> 
                  
              		<?php endforeach; ?>
					
					  
				</select>
		</div>
		
		<div class="mb-3">
			<label class="form-label" style="color:#0088ff">Asin ID</label>
			 <input class="form-control"  type="text" id="asin" name="asin" placeholder="Asin ID" value="<?=$account['asin_id']?>" <?=$input_st ?>>				
		</div>
		
		
		<div class="mb-3">
			<label class="form-label" style="color:#0088ff">image</label>
			<input type="file" name="fileToUpload" id="fileToUpload">			
		</div>		
		
		
		<div class="mb-3"><label class="form-label" for="rememberme" style="color:#0088ff"> Free asin list</label>
			
        <input class="form-control" type="text" id="free_asin" name="free_asin" placeholder="12365523;565656565;6565656554;" value="<?=$account['free_asin_list']?>"   <?=$input_st ?>></div>

        <div class="mb-3"><label  class="form-label" for="rememberme" style="color:#0088ff">max_deals</label>
        <input class="form-control" type="number" id="max_deals" name="max_deals" placeholder="20" value="<?=$account['max_deals']?>"  <?=$input_st ?>></div>

       
        <div class="submit-btns">

             <?=$btn_form ?>
            
        </div>

		
		
    </form>
								
				</div>					
									
							</div>
						</div>
					</div>

				</div>
			</main>




<?php
include 'footer.php';

?>




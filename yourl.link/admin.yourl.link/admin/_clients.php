<?php
include 'main.php';

include 'head.php';
include 'menu.php';

/////////////////////////////////////////////////
// Prepare accounts query
$stmt = $pdo->prepare('SELECT * FROM clients ORDER BY `clients`.`id` DESC');
$stmt->execute();
// Retrieve query results
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
/////////////////////////////////////////////////
if (isset($_GET['success_msg'])) {
    if ($_GET['success_msg'] == 1) {
        $success_msg = 'Client created successfully!';
    }
    if ($_GET['success_msg'] == 2) {
        $success_msg = 'Client updated successfully!';
    }
    if ($_GET['success_msg'] == 3) {
        $success_msg = 'Client deleted successfully!';
    }

		
echo '<br><a style="background-color: #37e9b494;color: #1cbb8c;" class="badge text-white ms-3" href="#">
      '.$success_msg.'
  </a>';

}


?>

<style>
.img-hover img {
    -webkit-transition: all .3s ease; /* Safari and Chrome */
  	-moz-transition: all .3s ease; /* Firefox */
  	-o-transition: all .3s ease; /* IE 9 */
  	-ms-transition: all .3s ease; /* Opera */
  	transition: all .3s ease;
  	position:relative;
}
.img-hover img:hover {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform:translateZ(0) scale(5.20); /* Safari and Chrome */
    -moz-transform:scale(5.20); /* Firefox */
    -ms-transform:scale(5.20); /* IE 9 */
    -o-transform:translatZ(0) scale(5.20); /* Opera */
    transform:translatZ(0) scale(5.20);
}
  
.img-hover:hover:after {
    content:"";
    position:absolute;
    top:0;
    left:0;
    z-index:2;
    width:30px;
    height:30px;
    border:1px solid #000;
}
  
.grayscale {
  -webkit-filter: brightness(1.10) grayscale(100%) contrast(90%);
  -moz-filter: brightness(1.10) grayscale(100%) contrast(90%);
  filter: brightness(1.10) grayscale(100%); 
}
</style>

			<main class="content">
	
				<div class="container-fluid p-0">

					<a href="_client.php" class="btn btn-info mb-3">Add New Client</a>
					<br>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">Clients List</h5>
								</div>
									
									
									<table class="table table-hover my-0">
									<thead>
							
										
										<tr>
                    <td>#</td>
                    <td>Client</td>
                    <td class="responsive-hidden">Brand</td>
                    <td class="responsive-hidden">Api Key</td>
                    <td class="responsive-hidden">Products</td>
                    <td class="responsive-hidden">Deals</td>
                    <td class="responsive-hidden">Created</td>
					<td class="responsive-hidden">Option</td>
                </tr>
										
									</thead>
									<tbody>
										
									
										
								
									
			<?php if (!$accounts): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no accounts</td>
                </tr>
                <?php endif; ?>
                <?php foreach ($accounts as $account): ?>
                <tr>
					<td><?=$account['id']?></td>
                    <td><?=$account['name']?></td> 
                  
					  <td class="responsive-hidden img-hover">
      <img class="img-responsive img-rounded"  width="40" height="40" src="https://admin.yourl.link/admin/uploado/<?=$account['logo']?>">
                    </td>
					
                    <td class="responsive-hidden"><?=substr($account['api_key'], 0, 9)?>....</td>
                    <td class="responsive-hidden"><?=$account['num_of_products']?></td>
                    <td class="responsive-hidden"><?=$account['num_of_deals']?></td>
                    <td class="responsive-hidden"><?=date('m/d/Y H:i:s', $account['time_'])?></td>
                    <td>
                        <a class="text-danger" href="_client.php?id=<?=$account['id']?>">Edit</a> &nbsp;&nbsp;&nbsp; 
                        <a class="text-info" href="_client.php?id=<?=$account['id']?>&del=1" >Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
									
									
									</tbody>
								</table>	
									
									
									
									
							</div>
						</div>
					</div>

				</div>
			</main>




<?php
include 'footer.php';
?>




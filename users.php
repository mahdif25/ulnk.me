<?php
include 'main.php';
check_loggedin($pdo);
include "head.php";
include "menu.php";
include "navbar.php";


	$add_ = 'none';
	if (isset($_GET['add']) && $_GET['add'] == 1) {	$add_ = 'block';  $msg_=  'Rotate Link was created successfully';	} 
	if (isset($_GET['del']) && $_GET['del'] == 1) {	$add_ = 'block';  $msg_=  'Rotate Link was removed successfully';	} 


	if (isset($_GET['page_no']) && $_GET['page_no']!="") {
		$page_no = $_GET['page_no'];
	} else { $page_no = 1;         }

	$total_records_per_page = 50;
	$offset = ($page_no-1) * $total_records_per_page; 
	

	// $stmt = $pdo->prepare('SELECT * FROM accounts WHERE `id` <> 3');
	$admn_ = 3 ;

	$stmt = $pdo->prepare('SELECT * FROM accounts WHERE  `id` <>  :usr  LIMIT  :limit , :offset  ');
	$stmt->bindValue(':offset',  (int) $total_records_per_page, PDO::PARAM_INT); 
	$stmt->bindValue(':limit',  (int) $offset, PDO::PARAM_INT);
	$stmt->bindValue(':usr',  (int) $admn_, PDO::PARAM_INT);
	$stmt->execute( );
	$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$total_records = $pdo->query('select count(*) from accounts')->fetchColumn(); 

	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 


    $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1


?> 


          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-fluid flex-grow-1 container-p-y">

				<div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" onclick=" reatator();"><i class="bx bx-list-plus me-1"></i> Add new User</a>
                    </li>
                  
                   
                  </ul>
                  <div class="card mb-4">
                   
                    <hr class="my-0">
                   
						
						
						<!-- Striped Rows -->
<div class="card">
	
	
	
	<div class="row card-header">
              

		<div style="display:<?=$add_?>" class="card-header alert alert-success alert-dismissible" role="alert">
          <?=$msg_?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>




</div>

  	<div class="row">
                <div class="col-md-12">




  	<div class="row">
                <div class="col-md-12">
<div class="divider divider-warning card-header">
          <div class="divider-text">Users List</div>
        </div>

 </div>
	 </div>
				
					  	<div class="row">
                <div class="col-md-6">
					
				
			
				
					
					
					
					
					
					
					
					
					
					
					<div class="mt-3">
          <!-- Button trigger modal -->
						
						

          <!-- Modal -->
          <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <form id="form1"  action="add_user.php" method="post" class="modal-content" >
                <div class="modal-header">
                  <h5 class="modal-title" id="backDropModalTitle">Add new User</h5>
				
					
                  <button type="button" class="btn-close" onclick=" close_modal()" aria-label="Close"></button>
                </div>
<div class="modal-body">
	
			<div id="link_msg" class="alert alert-warning" role="alert" style="display:none">
          <p id="link_msg_txt"></p>
        </div>
    
	<div class="row">
                    <div class="col mb-3">
                      <label for="nameBackdrop" class="form-label">Username</label>
                      <input  name="title" id="title" type="text"  class="form-control" placeholder="Enter Title" wfd-id="id0">
                    </div>
                  </div>
	
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameBackdrop" class="form-label">Email</label>
                      <input name="mail" id="mail" type="email"  class="form-control" placeholder="Enter Title" wfd-id="id0">
                    </div>
                  </div>
	

                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameBackdrop" class="form-label">Password</label>
                      <input  name="pass" id="pass" type="password"  class="form-control" placeholder="Enter Title" wfd-id="id0">
                    </div>
                  </div>
	
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" onclick=" close_modal()">Close</button>
                  <button type="button" class="btn btn-primary" onclick="send_()">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
					
					
					
					
					
					
					
	 </div>
					<div style="margin-left: -20px;" class="col-md-6">
						
	<div  >
    <nav aria-label="Page navigation">

		

<ul class="pagination justify-content-end">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li  class='page-item' <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a class='page-link' <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class=' page-item active'><a class='page-link'>$counter</a></li>";	
		
				}else{
           echo "<li class='page-item'><a  class='page-link' href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class=' page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li class='page-item'><a class='page-link'>...</a></li>";
		echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
		echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class=' page-item active''><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
				}                  
       }
       echo "<li class='page-item'><a class='page-link'>...</a></li>";
	   echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
		echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class=' page-item active'><a class='page-link'>$counter</a></li>";	
				}else{
           echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
				}                   
                }
            }
	}
?>
	<li class=' page-item '<?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a class='page-link'<?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>
		
		
          </nav>

</div>
	
	</div>
	
	 </div>
	
	
	
	
	
	
	
	
	
	
	
	


		  

					
					<div class="card-header row">
       			<?php foreach ($accounts as $account): ?>
					 	
                <div class="col-md-12">
							       <div class="card shadow-none bg-transparent border border-info mb-3">
      <div class="card-body">
<p> <b style="color: #acc0d1;"> Id :</b> #<?=$account['id']?> | <b style="color: #acc0d1;">Username  : </b> <b><?=$account['username']?></b> | <b style="color: #acc0d1;">Email : </b> <b><?=$account['email']?> </b>|  <b style="color: #acc0d1;">Created : </b><?= date('m/d/Y H:i:s', $account['time']);?>   
	
	
	
	<a  class="badge rounded-pill bg-label-info"  href="#">Edit</a> / 
	
	
	<a  class="badge rounded-pill bg-label-danger"  href="remove_user.php?id=<?=$account['id']?>">Remove</a>
	</p> 
		  

						
			</div>			
      </div>
    </div>
                <?php endforeach; ?>

			
					

				</div>	


</div>
<!--/ Striped Rows -->
						
						
						
						
                    <!-- /Account -->
                  </div>
     
                </div>
              </div>
				
            </div>
            <!-- / Content -->

<?php
include "foot.php";
?>
					
<script>
var links_ = 0 ;
	

function close_modal(){

	$('#backDropModal').modal('hide'); 
}
	
				
		
		function send_(){
			var parm0 = {};
			
			
				document.getElementById("link_msg").style.display = "none";
				document.getElementById("link_msg_txt").innerHTML = '';
			
var elements = document.getElementById("form1").elements;
		var total_ = 0 ;
		var error_ = 0 ;

			for (var i2 = 0, element; element = elements[i2++];) {
				var id_el = String(element.id) ;
				element.style = "none"; 
				if ( !id_el.includes('_v')){ continue ;}
				 
			}
		for (var i = 0, element; element = elements[i++];) {
			var id_el = String(element.id) ;
			
			if (id_el == 'title'){
				if (element.type === "text" && element.value === ""){
					document.getElementById("link_msg").style.display = "block";
					document.getElementById("link_msg_txt").innerHTML = 'Username is empty !';
					element.style = "border: 1px solid #ff5604;"; 
					error_ = 1;
					break ;
				}else{ element.style = "none"; parm0[id_el] = element.value; continue ; };
			}
			
			if (id_el == 'pass'){
				if (element.type === "text" && element.value === ""){
					document.getElementById("link_msg").style.display = "block";
					document.getElementById("link_msg_txt").innerHTML = 'Pass is empty !';
					element.style = "border: 1px solid #ff5604;"; 
					error_ = 1;
					break ;
				}else{ element.style = "none"; parm0[id_el] = element.value; continue ; };
			}

			if (id_el == 'mail'){
				if (element.type === "text" && element.value === ""){
					document.getElementById("link_msg").style.display = "block";
					document.getElementById("link_msg_txt").innerHTML = 'Email is empty !';
					element.style = "border: 1px solid #ff5604;"; 
					error_ = 1;
					break ;
				}else{ element.style = "none"; parm0[id_el] = element.value; continue ; };
			}
			
		}
			


		if (error_== 0 ){ post('add_user.php',parm0);    }
		// document.getElementById('form1').submit();
	}
	
	
	
	function reatator(){
	

	
	$('#backDropModal').modal('show'); 
	}
	
	
	
	
	function post(path, params, method='post') {

  // The rest of this code assumes you are not using a library.
  // It can be made less verbose if you use one.
  const form = document.createElement('form');
  form.method = method;
  form.action = path;

  for (const key in params) {
    if (params.hasOwnProperty(key)) {
      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = key;
      hiddenField.value = params[key];

      form.appendChild(hiddenField);
    }
  }

  document.body.appendChild(form);
  form.submit();
}
</script>					
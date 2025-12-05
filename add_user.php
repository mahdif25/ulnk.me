<?php
include 'main.php';
check_loggedin($pdo);
if ($_SESSION['id'] != 3 ){ header('Location: home.php'); exit();	}
// output message (errors, etc)
$msg = '';
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
// Handle edit profile post data



include 'head1.php' ;
exit;
?>


		



<?php
include 'main.php';
check_loggedin($pdo);
$msg = '';

//url_1
if (isset($_POST['title'], $_POST['mail'], $_POST['pass'] )) {
		$pass0 =   password_hash($_POST['pass'], PASSWORD_DEFAULT) ;
		// Check if new username or email already exists in database
		$sqll = "INSERT INTO `accounts` (`id`, `username`,`email`, `password`) VALUES (NULL, ?, ?, ?)";
		$stmt = $pdo->prepare($sqll);
		$stmt->execute([  $_POST['title'], $_POST['mail'], $pass0]);

	 header('Location: users.php?add=1');
	     exit();
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
					
					
              <form id="form1"  action="add_rotator.php" method="post" class="modal-content" >
                <div class="modal-header">
                  <h5 class="modal-title" id="backDropModalTitle">Add New User</h5>
				
					
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
                 
                  <button type="button" class="btn btn-primary" onclick="send_()">Save</button>
                </div>
              </form>			
					
					

				
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>
            <!-- / Content -->

<?php
include "foot.php";
?>
					
<script>


		
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
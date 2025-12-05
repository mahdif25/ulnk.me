<?php
include 'main.php';
check_loggedin($pdo);


// output message (errors, etc)
$msg = '';




//url_1
if (isset($_POST['title'],  $_POST['asin'], $_POST['mass'], $_POST['note'])) {
	
	foreach ($_POST as $key => $value) {
	if (str_contains($key, "url_")) {
		
		
				$title = str_replace(" ","-",$value) ;
		$url1  = str_replace(" ","+",$value) ;
		// https://www.amazon.com/play-money-kids/s?k=play+money+for+kids     gcid
		$url_ = 'https://www.amazon.com/'.$title.'/s?k='.$url1 ;
	
				// Check if new username or email already exists in database   `gcid_`
		$sqll = "INSERT INTO `links` (`id`, `idd`, `title`, `url`, `asin`, `mass`, `note`, `timo`, `user_id`, `gcid_`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($sqll);
		$stmt->execute([ uniqid(), $_POST['title'], $url_, $_POST['asin'], $_POST['mass'], $_POST['note'], time() , $_SESSION['id'], $_POST['gcid'] ]);

	}
	
		}
	 header('Location: home.php?add=1');
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
                  <h5 class="modal-title" id="backDropModalTitle">Add New link</h5>
				
					
                </div>
<div class="modal-body">
	
		<div id="link_msg" class="alert alert-warning" role="alert" style="display:none">
          <p id="link_msg_txt"></p>
        </div>

                  <div class="row">
					  
					  

					  
					  
                    <div class="col mb-3 col-9">
                      <label for="nameBackdrop" class="form-label">Title</label>
                      <input type="text" class="form-control" name="title" id="title" placeholder=" Product Title - Asin - Purpose">
                    </div>
					  
					<div class="col-3 form-check form-switch mb-2"> <br>
					  <input class="form-check-input" type="checkbox" name="gcid" id="gcid">
					  <label class=" bg-label-primary form-check-label" for="gcid"> &nbsp;&nbsp;&nbsp;include [Google Click ID] &nbsp;&nbsp;&nbsp; </label>
					</div>
					  
					  
					  
                  </div>
		
	<button type="button" class="btn btn-outline-warning" onclick="add_link('http://');"><i class="bx bx-list-plus me-1"></i> Add new Keyword</button> 
				<div id="links">
					

	
			 </div>		
					
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameBackdrop" class="form-label">Asin</label>
                      <input type="text" class="form-control" name="asin" id="asin" placeholder="B012345678">
                    </div>
                  </div>
	
	
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameBackdrop" class="form-label">Mass</label>
                      <input type="text" class="form-control" name="mass" id="mass" placeholder="maas=maas_adg_37F...">
                    </div>
                  </div>
	
	
                  <div class="row">
                    <div class="col mb-3">
                      <label for="nameBackdrop" class="form-label">Note</label>
                      <input type="text" class="form-control"  name="note" id="note" placeholder="science ads ...">
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
var links_ = 1 ;
add_link('') ;	

	
function add_link($url){


let para = document.createElement("div");

	
//para.innerHTML = '<div class="row"> <div class="col mb-3"> <label style="color: #4a536e;" for="username">Amazon keyword #'+links_+'</label> <input type="text"  name="url_'+links_+'" id="url'+links_+'" placeholder="Product Keyword "> </div> </div>	';
	
para.innerHTML = '<div class="col mb-3"> <label for="nameBackdrop" class="form-label"><span class="badge bg-label-primary me-1">Amazon keyword #'+links_+'</span></label> <input type="text" class="form-control"   name="url_'+links_+'" id="url_'+links_+'" placeholder="Product Keyword '+links_+' "> </div>	';
// Append to another element:
document.getElementById("links").appendChild(para);
links_ = links_ + 1 ;
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
			
			gcid
			
			
			
			var id_el = String(element.id) ;

			
			if (id_el == 'gcid'){
				if (document.getElementById("gcid").checked){
					parm0[id_el] = 1 ; 
				}else{ 
					parm0[id_el] = 0 ; 
				}
				continue ; 
			}
						
			
			
			if (id_el == 'title'){
				if (element.type === "text" && element.value === ""){
					
				document.getElementById("link_msg").style.display = "block";
				document.getElementById("link_msg_txt").innerHTML = 'the Title is empty !';

				element.style = "border: 1px solid #ff5604;"; 
			
				error_ = 1;
				break ;
				}else{ element.style = "none"; parm0[id_el] = element.value; continue ; };
			}
			

			var url_val = parseInt(element.value) ;

				parm0[id_el] = element.value;
				if (element.value === "" ){ }
				
			
		}
			
		if (error_ > 0 ){ }else {
			
		}
console.log(parm0);
		if (error_== 0 ){ post('add_link2.php',parm0);    }
		// document.getElementById('form1').submit();
	}
	
	
	
	function reatator(){
	
	  let chkboxes = $('.form-check-input');

	  for(let i = 0; i < chkboxes.length; i++) {
		if (chkboxes[i].checked) {
		  let url_id = chkboxes[i].id; 
		  console.log(url_id);
			add_link('https://yourl.link/show.php?id='+url_id)
		}
	  }
	
	
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
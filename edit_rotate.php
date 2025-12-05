<?php


include 'main.php';
check_loggedin($pdo);

if (isset($_POST['title'])) {
	
		$link_id = $_POST['link_id'] ;
		$idd = $link_id ;
		$stmt = $pdo->prepare('SELECT * FROM `rotator` WHERE `short` = ? and  `user_id` = ? ');
		$stmt->execute([ $idd ,$_SESSION['id'] ]);
		$account = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($account) {
		}else{
			echo '<br><br><h1>Link Not found !</h1>' ;
			exit;
		}
	
	
	
	$arr = [];

	foreach ($_POST as $key => $value) {
	//	echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";

		if (str_contains($key, "_nv")) { 

			$t1 = str_replace("n_","",$key);
			$t2 = str_replace("_nv","",$t1);


			$a =     [
						"url"     => $_POST['n_'.$t2.'_url'],
						"open"    => $_POST['n_'.$t2.'_ov'],
						"per"     => $_POST['n_'.$t2.'_nv'],
						"cur_per" => $_POST['n_'.$t2.'_cv']
					] ;

			array_push($arr, $a);

		}
	}

	//print_r( $arr) ; exit;

	if (count($arr) !== 0) {

		$new_arr = json_encode($arr);
		
		$stmt = $pdo->prepare('UPDATE `rotator` SET  name = ?, links = ?, updato = ? WHERE short = ?');
		$stmt->execute([$_POST['title'], $new_arr ,time(), $link_id ]);
		 header('Location: links_rotator.php');
	     exit();
		
			}

}


if (isset($_GET['id'])) {
}else{echo 'Error in url id !' ; exit;}


//////////////////////////////////////////////////////////////////////
$idd = $_GET['id'] ;

$stmt = $pdo->prepare('SELECT * FROM `rotator` WHERE `short` = ? and  `user_id` = ? ');
$stmt->execute([ $idd ,$_SESSION['id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if ($account) {
	
}else{
echo '<br><br><h1>Link Not found !</h1>' ;
exit;
}	



include "head.php";
include "menu.php";
include "navbar.php";
$key_0 =  explode("=",$account['url']);
$key_1 = str_replace("+"," ",$key_0[1]) ;
						
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
        <h5 class="mb-0">Edit Link</h5> <small class="text-muted float-end">Link id : <?=$account['short']?></small>
      </div>
      <div class="card-body">
        <form id="form1" action="edit_rotate.php" method="post">
			<input type="hidden" id="link_id" name="link_id" value="<?=$account['short']?>">
			

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="title">Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="title" id="title"  value="<?=$account['name']?>" />
            </div>
          </div>

<button type="button" class="btn btn-outline-warning" onclick="add_link('http://');"><i class="bx bx-list-plus me-1"></i> Add new Url</button>
<div id="links">
					<?php	$arr = json_decode($account['links'] , true );
						
							$links_ = 0 ;
							foreach($arr as $item) { //foreach element in $arr
								$links_ = $links_ + 1 ;
								$var1 = $item['url'];
								$var2 = $item['open'];
								$var3 = $item['per'];
								$var4 = $item['cur_per'];
								
echo '
<div class="row" id="row_'.$links_.'"> 

	<div class="form-check form-switch col-md-2">
         <br><span class="badge bg-label-primary me-1" id="row_'.$links_.'_n">Rotate link #'.$links_.'</span>
        </div>
		
	<div class="col-md-2"> 
		<label  class="form-label">% Val</label> 
		<input id="n_'.$links_.'_nv" class="form-control" type="number" value="'.$var3.'" data-np-intersection-state="visible" > 
	</div> 
	
		<div class="col mb-2"> 
		<label for="dobBackdrop" class="form-label">Url</label> 
		<input id="n_'.$links_.'_url" type="text" value="'.$var1.'" class="form-control" > 
	</div> 
	
	<div class="col-md-2"> 
		<label  class="form-label">% Current Val</label> 
		<input id="n_'.$links_.'_cv" class="form-control" type="number" value="'.$var4.'" data-np-intersection-state="visible" disabled> 
	</div> 
	
	<div class="col-md-2"> 
		<label  class="form-label">Open</label> 
		<input id="n_'.$links_.'_ov" class="form-control" type="number" value="'.$var2.'" value="1" data-np-intersection-state="visible" disabled> 
	</div> 
	

	
	<div class="form-check form-switch col-md-2">
         <br><a href="#" class="badge rounded-pill bg-label-danger" onclick="del_row( '."'".'row_'.$links_."'".')" >Remove</a>
        </div>
	
</div>' ;
						
		  

}
							

						?>
</div>	
			<br><br>
          <div class="row justify-content-end">
			  <div class="col-sm-12">
			  		<div id="link_msg" class="alert alert-warning" role="alert" style="display:none">
          <p id="link_msg_txt"></p>
        </div></div>
			  
            <div class="col-sm-10">
    
				 <button type="button" class="btn btn-primary" onclick="send_()">Update</button>
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
$links_ = $links_ + 1 ;					
?>
					
					
<script>	
	
var links_ = <?=$links_?> ;
		
function add_link(url){

let para = document.createElement("div");
	
para.id = "row_"+links_ ;
para.classList.add('row');	
para.innerHTML ='<div class="form-check form-switch col-md-2"> <br><span id="row_'+links_+'_n" class="badge bg-label-primary me-1">Rotate link #'+links_+'</span> </div>  <div class="col-md-2"> <label  class="form-label">% Val</label> <input id="n_'+links_+'_nv" class="form-control" type="number" value="1" data-np-intersection-state="visible" > </div> <div class="col mb-2"> <label for="dobBackdrop" class="form-label">Url</label> <input id="n_'+links_+'_url" type="text" value="" class="form-control" > </div> <div class="col-md-2"> <label  class="form-label">% Current Val</label> <input id="n_'+links_+'_cv" class="form-control" type="number" value="0" data-np-intersection-state="visible" disabled> </div> <div class="col-md-2"> <label  class="form-label">Open</label> <input id="n_'+links_+'_ov" class="form-control" type="number" value="0" value="1" data-np-intersection-state="visible" disabled> </div>  <div class="form-check form-switch col-md-2"> <br><a href="#" class="badge rounded-pill bg-label-danger" onclick="del_row( '+"'"+'row_'+links_+"'"+')" >Remove</a> </div>' ;	

	
// Append to another element:
document.getElementById("links").appendChild(para);
links_ = links_ + 1 ;
	
fix_num() ;	
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
				document.getElementById("link_msg_txt").innerHTML = 'the Title is empty !';

				element.style = "border: 1px solid #ff5604;"; 
			
				error_ = 1;
				break ;
				}else{ element.style = "none"; 
					  parm0[id_el] = element.value; 
					  parm0["link_id"] = document.getElementById("link_id").value ;
					  continue ; 
					 }
			}
			
			if ( !id_el.includes('n_')){ continue ;}
			var url_val = parseInt(element.value) ;
			if ( id_el.includes('_url') ){
				parm0[id_el] = element.value;
				if (element.value === "" ){ }
				
			}
			
			if ( id_el.includes('_nv') ){ 
				if (url_val < 1) {
				
				
					document.getElementById("link_msg").style.display = "block";
					document.getElementById("link_msg_txt").innerHTML = 'one or many input fields are empty !';
					element.style = "border: 1px solid #ff5604;"; 
					error_ = 1;
					break ;
				}
				console.log('** ',element.value,url_val,id_el,total_);
				total_	= total_ + url_val ;
				parm0[id_el] = element.value;
			}else{
				parm0[id_el] = element.value;
			}

			if (element.type === "text" && element.value === ""){
					document.getElementById("link_msg").style.display = "block";
					document.getElementById("link_msg_txt").innerHTML = 'one or many input fields are empty !';
					element.style = "border: 1px solid #ff5604;"; 
					error_ = 1;
					break ;
			}
				
		}
			
		if (error_ > 0 ){ }else {
			if (  (total_ !== 100)  ){

				document.getElementById("link_msg").style.display = "block";
				document.getElementById("link_msg_txt").innerHTML = 'the total of percentage is : '+total_+'% ,must be 100% !';
			for (var i2 = 0, element; element = elements[i2++];) { 
				var id_el = String(element.id) ;
				if ( !id_el.includes('_nv')){ continue ;}
				element.style = "border: 1px solid #ff5604;"; 
			}
				
				error_ = 1 ;
			}
		}
		
			console.log(parm0);
		if (error_== 0 ){ post('edit_rotate.php',parm0);    }
		// document.getElementById('form1').submit();
	}
	
		
	
	
function del_row(r_id){  document.getElementById(r_id).remove();  fix_num() ;	}
	
function fix_num(){
var elements = document.getElementById("links").children;
			var total_ = 1 ;
			for (var i2 = 0, element; element = elements[i2++];) {
				var id_el = String(element.id) ;
				console.log(id_el,';');
                document.getElementById(id_el+"_n").innerHTML = 'Rotate link #'+total_ ;
                total_ = total_ + 1 ;
			}
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
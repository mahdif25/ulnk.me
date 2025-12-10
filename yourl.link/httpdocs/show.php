<?php
if (isset($_GET['id'])) {
}else{echo 'Error in url id !' ; exit;}
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>
<body>

<center>	
<h2>Redirecting To Amazon </h2>

<div class="loader"></div>
</center>
</body>
</html>

<script>

$.ajax({
    type: 'POST',
    url: 'go.php?id=<?=$_GET['id']?>',
    data: {
        menu: 55
    },
    beforeSend: function(){
        console.log("sorting", "info");
    },
    success: function(data) {
		console.log(data);
		var obj = JSON.parse(JSON.stringify(data));
		console.log(obj.url);
		window.location.replace(obj.url);
    },
    error: function (data) {
        console.log('Error');


	}
    });

</script>
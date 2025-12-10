<?php
include 'main.php';
check_loggedin($pdo);

include 'menu.php';


	if (isset($_GET['id'])) {
		$id = preg_replace('/[^0-9]/', '', $_GET['id'] );
	

			// Get the account from the database
			$stmt = $pdo_coints->prepare('SELECT * FROM `btc` WHERE id = ?');
			$stmt->execute([ $id ]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row){}else{
		echo '<br><br><br><br>  ID not found !' ; exit ;
		}
			// ID param exists, edit an existing account
		
	}else{
		exit ;
	}	


$taged_users_ = $row["taged_users"] ;
$taged_users_ = str_replace("#"," .",$taged_users_  );
$taged_users_ = trim(preg_replace('/\s+/', ' ', $taged_users_));



$num_of_tweets = $row["num_of_tweets"] ;
$btc_price = $row["btc_price"] ;
$time_ =date('m/d/Y',  $row["time"] );


	
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="generator" content="Codeply" />
  <title>simple preview</title>
  <base target="_self">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />

  <style></style>
</head>
<body >
  <div class="container">
    <div class="row my-3">
        <div class="col">
            <h4>Data for #Bitcoin </h4>
			
			
        </div>
    </div>
    <div class="row my-2">
        <div class="col-md-6 py-1">
            <div class="card">
                <div class="card-body">
                  <p>Number of tweets this week</p>
                    <canvas id="chLine"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 py-1">
            <div class="card">
                <div class="card-body">
                  <p>Price change vs Num of tweets</p>
                    <canvas id="chBar"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-4 py-1">
            <div class="card">
                <div class="card-body">
					<p>Top 7 hachtags</p>
                    <canvas id="chDonut1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-1">
            <div class="card">
                <div class="card-body">
					<p>Top 7 users</p>
                    <canvas id="chDonut2"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-1">
            <div class="card">
                <div class="card-body">
                  <h5><span class="badge badge-secondary">AVG post time
                    <span class="badge badge-light">  <?=$row["avg_post_time"]  ?> Post/second</span>
                  </span></h5><br>


 
                </div>
            </div>
        </div>
    </div>
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>

  <script>
  /* chart.js chart examples */

var json_data = <?= $row["related_hashtags"] ?> ;
var json_a = [];
var json_b = [];
var json_a_7 = [];
var json_b_7 = [];
var t7 = 0 ;
for(var i in json_data){
	if (json_data [i] >3){
		json_a.push(i);
		json_b.push(json_data [i]);
		if (t7 < 7){
			t7 = t7 +1 ;
			json_a_7.push(i);
			json_b_7.push(json_data [i]);
		}
	}	 
}

//////////////////////////////////////////////
var u_json_data = <?= $taged_users_ ?> ;
var u_json_a = [];
var u_json_b = [];
var u_json_a_7 = [];
var u_json_b_7 = [];
var t7 = 0 ;
for(var i in u_json_data){
	if (u_json_data [i] >2){
		u_json_a.push(i);
		u_json_b.push(json_data [i]);
		if (t7 < 7){
			t7 = t7 +1 ;
			u_json_a_7.push(i);
			u_json_b_7.push(u_json_data [i]);
		}
	}	
}	  
	  
	  
// chart colors
var colors = ['#28a745', '#dc3545', '#007bff','#333333','#c3e6cb','#6c757d','#6c450d'];

/* large line chart */
var chLine = document.getElementById("chLine");
var chartData = {
  labels: ['<?= $time_ ?>'],
  datasets: [{
    data: ['<?= $num_of_tweets ?>'],
    backgroundColor: 'transparent',
    borderColor: colors[2],
    borderWidth: 4,
    pointBackgroundColor: colors[0]
  }
//   {
//     data: [639, 465, 493, 478, 589, 632, 674],
//     backgroundColor: colors[3],
//     borderColor: colors[1],
//     borderWidth: 4,
//     pointBackgroundColor: colors[1]
//   }
  ]
};
if (chLine) {
  new Chart(chLine, {
  type: 'line',
  data: chartData,
  options: {
    scales: {
      xAxes: [{
        ticks: {
          beginAtZero: false
        }
      }]
    },
    legend: {
      display: false
    },
    responsive: true
  }
  });
}

/* large pie/donut chart */
var chPie = document.getElementById("chPie");
if (chPie) {
  new Chart(chPie, {
    type: 'pie',
    data: {
      labels: ['Desktop', 'Phone', 'Tablet', 'Unknown'],
      datasets: [
        {
          backgroundColor: [colors[1],colors[0],colors[2],colors[5]],
          borderWidth: 0,
          data: [50, 40, 15, 5]
        }
      ]
    },
    plugins: [{
      beforeDraw: function(chart) {
        var width = chart.chart.width,
            height = chart.chart.height,
            ctx = chart.chart.ctx;
        ctx.restore();
        var fontSize = (height / 70).toFixed(2);
        ctx.font = fontSize + "em sans-serif";
        ctx.textBaseline = "middle";
        var text = chart.config.data.datasets[0].data[0] + "%",
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
        ctx.fillText(text, textX, textY);
        ctx.save();
      }
    }],
    options: {layout:{padding:0}, legend:{display:false}, cutoutPercentage: 80}
  });
}

	  	  


/* bar chart */
var chBar = document.getElementById("chBar");
if (chBar) {
  new Chart(chBar, {
  type: 'bar',
  data: {
    labels: ['<?= $time_ ?>'],
    datasets: [{
      data: ['<?= $num_of_tweets ?>'],
      backgroundColor: colors[2]
    },
    {
      data: ['<?= $btc_price ?>'],
      backgroundColor: colors[4]
    }]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        barPercentage: 0.4,
        categoryPercentage: 0.5
      }]
    }
  }
  });
}

/* 3 donut charts */
var donutOptions = {
  cutoutPercentage: 85,
  legend: {position:'bottom', padding:5, labels: {pointStyle:'circle', usePointStyle:true}}
};

// donut 1
var chDonutData1 = {
    labels: json_a_7, //['LTC', 'XRP', 'DOGE', 'XLM', 'ETH', 'BCH', 'BNB'],
    datasets: [
      {
        backgroundColor: colors.slice(0,6),
        borderWidth: 0,
        data: json_b_7, //[74, 11, 40, 11, 30, 53, 47]
      }
    ]
};

var chDonut1 = document.getElementById("chDonut1");
if (chDonut1) {
  new Chart(chDonut1, {
      type: 'pie',
      data: chDonutData1,
      options: donutOptions
  });
}

// donut 2
var chDonutData2 = {

    labels: u_json_a_7 , //['Positive', 'Negative', 'Neutral'],
    datasets: [
      {
        backgroundColor: colors.slice(0,3),
        borderWidth: 0,
        data: u_json_b_7, //[64, 11, 25]
      }
    ]
};
var chDonut2 = document.getElementById("chDonut2");
if (chDonut2) {
  new Chart(chDonut2, {
      type: 'pie',
      data: chDonutData2,
      options: donutOptions
  });
}

// donut 3
var chDonutData3 = {
    labels: ['Angular', 'React', 'Other'],
    datasets: [
      {
        backgroundColor: colors.slice(0,3),
        borderWidth: 0,
        data: [21, 45, 55, 33]
      }
    ]
};
var chDonut3 = document.getElementById("chDonut3");
if (chDonut3) {
  new Chart(chDonut3, {
      type: 'pie',
      data: chDonutData3,
      options: donutOptions
  });
}

/* 3 line charts */
var lineOptions = {
    legend:{display:false},
    tooltips:{interest:false,bodyFontSize:11,titleFontSize:11},
    scales:{
        xAxes:[
            {
                ticks:{
                    display:false
                },
                gridLines: {
                    display:false,
                    drawBorder:false
                }
            }
        ],
        yAxes:[{display:false}]
    },
    layout: {
        padding: {
            left: 6,
            right: 6,
            top: 4,
            bottom: 6
        }
    }
};

var chLine1 = document.getElementById("chLine1");
if (chLine1) {
  new Chart(chLine1, {
      type: 'line',
      data: {
          labels: ['Jan','Feb','Mar','Apr','May'],
          datasets: [
            {
              backgroundColor:'#ffffff',
              borderColor:'#ffffff',
              data: [10, 11, 4, 11, 4],
              fill: false
            }
          ]
      },
      options: lineOptions
  });
}
var chLine2 = document.getElementById("chLine2");
if (chLine2) {
  new Chart(chLine2, {
      type: 'line',
      data: {
          labels: ['A','B','C','D','E'],
          datasets: [
            {
              backgroundColor:'#ffffff',
              borderColor:'#ffffff',
              data: [4, 5, 7, 13, 12],
              fill: false
            }
          ]
      },
      options: lineOptions
  });
}

var chLine3 = document.getElementById("chLine3");
if (chLine3) {
  new Chart(chLine3, {
      type: 'line',
      data: {
          labels: ['Pos','Neg','Nue','Other','Unknown'],
          datasets: [
            {
              backgroundColor:'#ffffff',
              borderColor:'#ffffff',
              data: [13, 15, 10, 9, 14],
              fill: false
            }
          ]
      },
      options: lineOptions
  });
}
  </script>

</body>
</html>

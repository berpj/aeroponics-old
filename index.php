<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  
  <title>Aeroponics</title>
  
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <style>  
    html {
      margin: 0;
    }
    
    body {
      background: url(pic.jpg) no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
    
    .navbar-brand {
      color: white !important;
      font-size: 1.5em;
    }
    
    rect[fill="#F4B400"] {
      height: 100% !important;
    }
  </style>
</head>

<body>
  
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href=""><i class="fa fa-leaf"></i> Aeroponics</a>
      </div>
    </div>
  </nav>
  
  <script type="text/javascript">
  google.setOnLoadCallback(drawChart);
  
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Time', 'Leafs temperature (#1)', 'Roots temperature (#2)', 'Solution PH'],
      <?php
        date_default_timezone_set('Europe/Paris');
        
        $file = file("temp.txt");
        $lines = array_slice($file, -288);
        
        $row = 0;
        while (isset($lines[$row]))
        {
          $line = explode(',', $lines[$row]);
          $legend = date('H:i', $line[0]);
          
          if (!isset($fake_ph))
            $fake_ph = 6;
          else
            $fake_ph = $last_fake_ph + (rand(1 * 10, 1.1 * 10) / 10 - 1.052) + 1.08 * (6.4 / $last_fake_ph / 100);
          $last_fake_ph = $fake_ph;
          
          echo "['$legend', $line[1], $line[2], $fake_ph],\n";
          $row++;
        }
      ?>
    ]);
    
    var options = {
      vAxis: {format:'0.00'},
      curveType: 'function',
      legend: { position: 'bottom' },
      series: {
        0: {targetAxisIndex: 0},
        1: {targetAxisIndex: 0},
        2: {targetAxisIndex: 1}
      },
      vAxes: {
        0: {title: 'Temp. (°C)'},
        1: {title: 'PH', minValue: 0, maxValue:14}
      }
    };
    
    var chart = new google.visualization.LineChart(document.getElementById('temperatures'));
    
    chart.draw(data, options);
  }
  </script>
  
  <div class="container" style="margin-top: 70px; margin-left: 2%!important; margin-right: 2%!important; width: 95%">
    <div class="row">
      <div class="col-md-6" style="padding: 15px">
        <div style="background-color: white; padding: 10px; min-height: 360px!important">
          <h4>Temperatures</h4>
          <div id="temperatures" style="opacity: 0.9; min-height: 280px"></div>
        </div>
      </div>
      <div class="col-md-6" style="padding: 15px">
        
        <script type="text/javascript">
        google.setOnLoadCallback(drawChart);
        
        function drawChart() {
          var container = document.getElementById('relays');
          var chart = new google.visualization.Timeline(container);
          var dataTable = new google.visualization.DataTable();
          dataTable.addColumn({ type: 'string', id: 'Room' });
          dataTable.addColumn({ type: 'string', id: 'Name' });
          dataTable.addColumn({ type: 'date', id: 'Start' });
          dataTable.addColumn({ type: 'date', id: 'End' });
          dataTable.addRows([
            [ 'Lamp (#1)', '',     new Date(0,0,0,8,0,0), new Date(0,0,0,22,0,0) ],
            [ 'Lamp (#2)', '',     new Date(0,0,0,8,0,0), new Date(0,0,0,22,0,0) ],
            <?php
              for ($i = 0; $i < 24; $i++)
                echo "[ 'Pomp', '', new Date(0,0,0,$i,0,0),  new Date(0,0,0,$i,30,0) ],";
            ?>
            [ '.', 'Now (<?php echo date('H:i') ?>)', new Date(0,0,0,<?php echo date('H,i') ?>,0), new Date(0,0,0,<?php echo date('H,i') ?>,0) ]
          ]);
          
          var options = {
            height: 300
          };
          
          chart.draw(dataTable, options);
        }
        </script>
        
        <div style="background-color: white; padding: 10px; min-height: 360px!important">
          <h4>Relays</h4>
          <div id="relays"></div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-k2/8zcNbxVIh5mnQ52A0r3a6jAgMGxFJFE2707UxGCk= sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==" crossorigin="anonymous">
  <script type="text/javascript" src="https://www.google.com/jsapi?autoload={ 'modules':[{ 'name':'visualization', 'version':'1', 'packages':['corechart', 'timeline'] }] }"></script>
</body>
</html>

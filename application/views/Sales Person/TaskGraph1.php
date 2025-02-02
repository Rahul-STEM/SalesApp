<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="wi$dth=device-wi$dth, initial-scale=1">
  <title>STEM APP | WebAPP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/jqvmap.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/daterangepicker.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/summernote-bs4.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/css/buttons.bootstrap4.min.css">
  <style>
      .scrollme {
    overflow-x: auto;
}
  </style>
  

  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php require('nav.php');?>

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <h4></h4>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="card col-12  p-3 text-center">
              <center><h5>My Funnel</h5></center><hr>
              
              
              <style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<form class="p-3" method="POST" action="TaskGraph1">
    <input type="date" name="sdate" class="mr-2" value="<?=$sd?>" min="2023-04-01">
    <input type="date" name="edate" class="mr-2" value="<?=$ed?>">
    <button type="submit" class="bg-primary text-light">Filter</button>
</form>



      
<div class="row">
 <div id="piechart1" class="col-6 mt-50"></div>
 <div id="piechart2" class="col-6 mt-50"></div>
 <div id="piechart3" class="col-6 mt-50"></div>
 <div id="piechart4" class="col-6 mt-50"></div>
 <div id="piechart5" class="col-6 mt-50"></div>
 <div id="piechart6" class="col-6 mt-50"></div>
 <div id="piechart7" class="col-6 mt-50"></div>
 <div id="piechart8" class="col-6 mt-50"></div>
 <div id="piechart9" class="col-6 mt-50"></div>
 <div id="piechart10" class="col-6 mt-50"></div>
 <div id="piechart11" class="col-6 mt-50"></div>
 <div id="piechart12" class="col-6 mt-50"></div>
 <div id="piechart13" class="col-6 mt-50"></div>
 <div id="piechart14" class="col-6 mt-50"></div>
 <div id="piechart15" class="col-6 mt-50"></div>
 <div id="piechart16" class="col-6 mt-50"></div>
 <div id="piechart17" class="col-6 mt-50"></div>
 <div id="piechart18" class="col-6 mt-50"></div>
</div>      
    
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
      
      google.charts.load("current", {packages:["corechart"]});
      
      google.charts.setOnLoadCallback(drawChart1);
      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'No of Task'],
            <?php $status = $this->Menu_model->get_taskstatuswisebwdall($uid,$sd,$ed);
             foreach($status as $st){?>
             ["<?=$st->stname?> (<?=$st->cont?>)", <?=$st->cont?>],
    	    <?php } ?>
        ]);

        var options = {
          title: 'Action Wise All Task Done',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
        chart.draw(data, options);
      }
      
      
      google.charts.setOnLoadCallback(drawChart2);
      function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'No of Task'],
            <?php $status = $this->Menu_model->get_taskstatuswisebwdanpn($uid,$sd,$ed);
             foreach($status as $st){?>
             ["<?=$st->stname?> (<?=$st->cont?>)", <?=$st->cont?>],
    	    <?php } ?>
        ]);

        var options = {
          title: 'Action Wise ANPN Task Done',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart3);
      function drawChart3() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'No of Compnay'],
            <?php $status = $this->Menu_model->get_taskstatuswisebwdaypn($uid,$sd,$ed);
             foreach($status as $st){?>
             ["<?=$st->stname?> (<?=$st->cont?>)", <?=$st->cont?>],
    	    <?php } ?>
        ]);

        var options = {
          title: 'Action Wise ANPN Task Done',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
        chart.draw(data, options);
      }
      
      
      google.charts.setOnLoadCallback(drawChart4);
      function drawChart4() {
        var data = google.visualization.arrayToDataTable([
          ['Type of Task', 'No of Task'],
            <?php $status = $this->Menu_model->get_taskstatuswisebwdaypy($uid,$sd,$ed);
             foreach($status as $st){?>
             ["<?=$st->stname?> (<?=$st->cont?>)", <?=$st->cont?>],
    	    <?php } ?>
        ]);

        var options = {
          title: 'Action Wise ANPN Task Done',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart4'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart5);
      function drawChart5() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $status = $this->Menu_model->get_meetingtypewise($uid,$sd,$ed);
             foreach($status as $st){?>
             ["<?=$st->remarks?> (<?=$st->cont?>)", <?=$st->cont?>],
    	    <?php } ?>
        ]);

        var options = {
          title: 'Meeting',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart5'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart6);
      function drawChart6() {
        var data = google.visualization.arrayToDataTable([
          ['Task Action Type', 'Count'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'1');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Call (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart6'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart7);
      function drawChart7() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'2');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Email (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart7'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart8);
      function drawChart8() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'3');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Schedule Meeting (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart8'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart9);
      function drawChart9() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'4');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Bargin Meeting (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart9'));
        chart.draw(data, options);
      }
      
      google.charts.setOnLoadCallback(drawChart10);
      function drawChart10() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'5');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Whatsapp Activity (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart10'));
        chart.draw(data, options);
      }
      
      
      google.charts.setOnLoadCallback(drawChart11);
      function drawChart11() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'6');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'MOM (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart11'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart12);
      function drawChart12() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'7');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Write Proposal (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart12'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart13);
      function drawChart13() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'8');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Review (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart13'));
        chart.draw(data, options);
      }
      
      
      google.charts.setOnLoadCallback(drawChart14);
      function drawChart14() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'9');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Roster Calling (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart14'));
        chart.draw(data, options);
      }
      
      
      
      
      
      
      
      
      google.charts.setOnLoadCallback(drawChart15);
      function drawChart15() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'10');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Research (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart15'));
        chart.draw(data, options);
      }
      
      
      
      google.charts.setOnLoadCallback(drawChart16);
      function drawChart16() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'13');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Social Networking (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart16'));
        chart.draw(data, options);
      }
      
      
      google.charts.setOnLoadCallback(drawChart17);
      function drawChart17() {
        var data = google.visualization.arrayToDataTable([
          ['Type Meeting', 'Meeting'],
            <?php $task = $this->Menu_model->get_actiontypewbwdap($uid,$sd,$ed,'14');?>
             ["ANPN (<?=$task[0]->anpn?>)", <?=$task[0]->anpn?>],
             ["AYPN (<?=$task[0]->aypn?>)", <?=$task[0]->aypn?>],
             ["AYPY (<?=$task[0]->aypy?>)", <?=$task[0]->aypy?>]
        ]);

        var options = {
          title: 'Social Activity (<?=$task[0]->cont?>)',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart17'));
        chart.draw(data, options);
      }
      
</script>      
      
      
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>

    <div style="width: 80%; margin: auto;">
        <canvas id="stackedChartID21"></canvas>
    </div>

    <script>
        var myContext = document.getElementById("stackedChartID21").getContext('2d');
        var myChart21 = new Chart(myContext, {
            type: 'bar',
            data: {
                labels: [
                    
                    <?php   $currentDate = new DateTime();
                            $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                            for ($month = 4; $month <= 15; $month++) {
                                $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                                $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                                $monthName = DateTime::createFromFormat('!m', $adjustedMonth)->format('F');?>
                    "<?=$monthName?> (<?=$year?>)", <?php } ?>],
                datasets: [
                    
                    <?php 
                    $colors = array('red','blue','green','yellow','purple','orange','pink','brown','cyan','magenta','teal','lime','violet','indigo','gray');

                    $action = $this->Menu_model->get_action(); $i=0; foreach($action as $ac){
                        $acid = $ac->id; ?>
                    {
                        label: '<?=$ac->name?>',
                        backgroundColor: "<?=$colors[$i]?>",
                        data: [
                            
                            <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mywisetaskall($uid,$month,$year,$acid);?>
                            <?=$accont[0]->cont?>,<?php } ?>],
                        stack: 'Stack 0',
                    },
                    <?php $i++;} ?>
                ],
            },
            options: {
                
                plugins: {
                    title: {
                        display: true,
                        text: 'Month Wise No of Task'
                    },
                    
                
            },
            onClick: function (evt, activeElements) {
                if (activeElements && activeElements.length) {
                    const clickedDatasetIndex = activeElements[0].datasetIndex;

                    let allOthersHidden = true;
                    for (let i = 0; i < myChart21.data.datasets.length; i++) {
                        if (i !== clickedDatasetIndex && !myChart21.getDatasetMeta(i).hidden) {
                            allOthersHidden = false;
                            break;
                        }
                    }

                    if (allOthersHidden) {
                        for (let i = 0; i < myChart21.data.datasets.length; i++) {
                            myChart21.getDatasetMeta(i).hidden = false;
                        }
                    } else {
                        for (let i = 0; i < myChart21.data.datasets.length; i++) {
                            myChart21.getDatasetMeta(i).hidden = (i !== clickedDatasetIndex);
                        }
                    }

                    myChart21.update();
                }
            }
        }
    });
    </script>
      
      
      
      
      
      

    
    
    <div style="width: 80%; margin: auto;">
        <canvas id="stackedChartID1"></canvas>
    </div>

    <script>
    
    
        var myContext = document.getElementById("stackedChartID1").getContext('2d');
        var myChart1 = new Chart(myContext, {
            type: 'bar',
            data: {
                labels: [
                    
                    <?php   $currentDate = new DateTime();
                            $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                            for ($month = 4; $month <= 15; $month++) {
                                $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                                $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                                $monthName = DateTime::createFromFormat('!m', $adjustedMonth)->format('F');?>
                    "<?=$monthName?> (<?=$year?>)", <?php } ?>],
                datasets: [
                    
                    <?php 
                    $colors = array('red','blue','green','yellow','purple','orange','pink','brown','cyan','magenta','teal','lime','violet','indigo','gray'); ?>
                    
                    {
                        label: '',
                        backgroundColor: "purple",
                        data: [
                            
                            <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mypnutaskactionwisep($uid,$month,$year,'1');?>
                            <?=$accont[0]->cont?>,<?php } ?>],
                        stack: 'Stack 0',
                    },
                    
                    {
                        label: '',
                        backgroundColor: "yellow",
                        data: [
                            
                            <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mypnutaskactionwisei($uid,$month,$year,'1');?>
                            <?=$accont[0]->cont?>,<?php } ?>],
                        stack: 'Stack 0',
                    },
                    
                    {
                        label: '',
                        backgroundColor: "green",
                        data: [
                            
                            <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mypnutaskactionwiseu($uid,$month,$year,'1');?>
                            <?=$accont[0]->cont?>,<?php } ?>],
                        stack: 'Stack 0',
                    },
                    
                    {
                        label: 'Plan-Initiated Early',
                        backgroundColor: "red",
                        data: [
                            <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mypnutaskaptiol($uid,$month,$year,'1');?>
                            <?=$accont[0]->late?>,<?php } ?>
                            
                            ],
                        stack: 'Stack 1'
                    },
                    
                    {
                        label: 'Plan-Initiated Late',
                        backgroundColor: "green",
                        data: [
                            <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mypnutaskaptiol($uid,$month,$year,'1');?>
                            <?=$accont[0]->ontime?>,<?php } ?>
                            
                            ],
                        stack: 'Stack 1'
                    },
                    
                    
                   
                    {
                        label: 'Initiated-Update',
                        backgroundColor: "red",
                        data: [
                            <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mypnutaskaituol($uid,$month,$year,'1');?>
                            <?=$accont[0]->late?>,<?php } ?>
                            
                            ],
                        stack: 'Stack 2'
                    },
                    
                    {
                        label: 'Initiated-Update',
                        backgroundColor: "green",
                        data: [
                            <?php $currentDate = new DateTime();
                        $financialYear = ($currentDate->format('m') >= 4) ? $currentDate->format('Y') : ($currentDate->format('Y') - 1);
                        for ($month = 4; $month <= 15; $month++) {
                            $adjustedMonth = ($month <= 12) ? $month : ($month - 12);
                            $year = ($month <= 12) ? $financialYear : ($financialYear + 1);
                            $accont = $this->Menu_model->get_mypnutaskaituol($uid,$month,$year,'1');?>
                            <?=$accont[0]->ontime?>,<?php } ?>
                            
                            ],
                        stack: 'Stack 2'
                    },
                   
                ],
            },
            options: {
                
                plugins: {
                    legend: {
                display: false, // Hide the legend
            },
                    title: {
                        display: true,
                        text: '<?=$ac->name?> Plan to Update Detail'
                    },
                    
                
            },
            onClick: function (evt, activeElements) {
                if (activeElements && activeElements.length) {
                    const clickedDatasetIndex = activeElements[0].datasetIndex;

                    let allOthersHidden = true;
                    for (let i = 0; i < myChart1.data.datasets.length; i++) {
                        if (i !== clickedDatasetIndex && !myChart1.getDatasetMeta(i).hidden) {
                            allOthersHidden = false;
                            break;
                        }
                    }

                    if (allOthersHidden) {
                        for (let i = 0; i < myChart1.data.datasets.length; i++) {
                            myChart1.getDatasetMeta(i).hidden = false;
                        }
                    } else {
                        for (let i = 0; i < myChart1.data.datasets.length; i++) {
                            myChart1.getDatasetMeta(i).hidden = (i !== clickedDatasetIndex);
                        }
                    }

                    myChart1.update();
                }
            }
        }
    });
    </script>   
      
      
      





      
      
      
          </div>
      </div>
    </section>
   </div>
</div> 
    
  <footer class="main-footer">
    <strong>Copyright &copy; 2021-2022 <a href="<?=base_url();?>">Stemlearning</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
<script src="<?=base_url();?>assets/js/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?=base_url();?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url();?>assets/js/Chart.min.js"></script>
<script src="<?=base_url();?>assets/js/sparkline.js"></script>
<script src="<?=base_url();?>assets/js/jquery.vmap.min.js"></script>
<script src="<?=base_url();?>assets/js/jquery.vmap.usa.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?=base_url();?>assets/js/moment.min.js"></script>
<script src="<?=base_url();?>assets/js/daterangepicker.js"></script>
<script src="<?=base_url();?>assets/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?=base_url();?>assets/js/summernote-bs4.min.js"></script>
<script src="<?=base_url();?>assets/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?=base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>assets/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url();?>assets/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url();?>assets/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url();?>assets/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url();?>assets/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url();?>assets/js/jszip.min.js"></script>
<script src="<?=base_url();?>assets/js/pdfmake.min.js"></script>
<script src="<?=base_url();?>assets/js/vfs_fonts.js"></script>
<script src="<?=base_url();?>assets/js/buttons.html5.min.js"></script>
<script src="<?=base_url();?>assets/js/buttons.print.min.js"></script>
<script src="<?=base_url();?>assets/js/buttons.colVis.min.js"></script>
<script src="<?=base_url();?>assets/js/adminlte.js"></script>
<script src="<?=base_url();?>assets/js/dashboard.js"></script>

<script>
    $("#example1").DataTable({
      "responsive": false, "lengthChange": false, "autoWi$dth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appen$dto('#example1_wrapper .col-md-6:eq(0)');
</script>
</body>
</html>

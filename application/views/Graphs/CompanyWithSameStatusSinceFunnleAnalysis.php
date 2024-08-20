<style>
    #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        /* color: #0062cc; */
        background-color: #ffc107;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bolder;
    }
    .nav-tabs .nav-link{
        background-color: white;
        color: black;
        font-weight: 600;
    }
    .nav-tabs .nav-link:hover {
    background-color: #dfd5ef;
    color: #000;
    /* border-color: #007bff; Add a border color on hover */
    border-radius: 0.25rem; /* Optional: Rounded corners */
}
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <br>
            <section class="FilterSection">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <center>
                                <h5>Company with Same Status Since Analysis</h5>
                            </center>
                        </div>
                        <div class="card-body FilterSection">
                            <form method="POST" action="<?=base_url();?>GraphNew/CompanyWithSameStatusSinceFunnleAnalysis/<?php ?>">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="startDate">Start Date</label>
                                        <input id="startDate" name="startDate" class="form-control" type="date" value="<?=$sdate ?>"/>
                                        
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="endDate">End Date</label>
                                        <input id="endDate" class="form-control" name="endDate" type="date" value="<?=$edate ?>"/>
                                    </div>
                                    
                                    <!-- Partner Type -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Status</label>
                                            <select class="custom-select rounded-0" name="status[]" id="status" multiple>
                                                <option value="select_all">Select All</option>
                                                <?php foreach($status as $SingleStatus) { ?>
                                                    <option value="<?= $SingleStatus->id ?>" <?= in_array($SingleStatus->id, $SelectedStatus) ? 'selected' : '' ?>><?= htmlspecialchars($SingleStatus->name) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-sm-6">
                                        <br>
                                       <button type="submit" name="submit" class="btn btn-primary"> Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </section>
            <br>
            <section class="GraphSection">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-body">
                                <div id="CompanyWithSameStatusChart" style="width: 100%; height: 400px;"></div>
                                <hr>
                                <div id="StatusWisePieChart1">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav_GridView" data-toggle="tab" href="#GridView" role="tab" aria-controls="GridView" aria-selected="true">Grid View</a>
                                            <a class="nav-item nav-link" id="nav_TableView" data-toggle="tab" href="#TableView" role="tab" aria-controls="TableView" aria-selected="false">XLS View</a>
                                            <a class="nav-item nav-link" id="nav_TabView" data-toggle="tab" href="#TabView" role="tab" aria-controls="TabView" aria-selected="false">Tab View</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="GridView" role="tabpanel" aria-labelledby="nav_GridView">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row">

                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div> 
            </section>
        </div>
    </div>

<script src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
google.charts.load("current", { packages: ['corechart'] });


google.charts.setOnLoadCallback(drawStackedColumnChart);
    function drawStackedColumnChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Status');
        data.addColumn('number', '0-10');
        data.addColumn({type: 'string', role: 'annotation'});
        data.addColumn('number', '10-20');
        data.addColumn({type: 'string', role: 'annotation'});
        data.addColumn('number', '20-30');
        data.addColumn({type: 'string', role: 'annotation'});
        data.addColumn('number', '30+');
        data.addColumn({type: 'string', role: 'annotation'});
        data.addColumn({type: 'string', role: 'annotationText'});
        data.addRows([

        <?php
        
        // $status = $this->Menu_model->get_status();

        foreach($SelectedStatus as $SelectedSingleStatus){
            // SelectedStatus
            // $SingleStatus = $SingleStatus->id;

            if($SelectedSingleStatus !='14'){

            // $opensday = $this->Menu_model->get_opensday($uid,$stid,$sd,$ed);
            $opensday = SameStatusTillDate($uid, $userTypeid, $sdate, $edate, $SelectedSingleStatus);
            
            // echo "<pre>";
            // var_dump($opensday);die;
            $countLessThan10 = 0;
            $countLessThan20 = 0;
            $countLessThan30 = 0;
            $countMoreThan30 = 0;

            foreach ($opensday as $object) {

                if ($object->opensday <= 10) {
                        $countLessThan10++;
                    } elseif ($object->opensday <= 20) { // Corrected condition
                        $countLessThan20++;
                    } elseif ($object->opensday <= 30) { // Corrected condition
                        $countLessThan30++;
                    } else {
                        $countMoreThan30++;
                    }
            }
            ?>
            ['<?=$object->name?>', <?=$countLessThan10?>, '<?=$countLessThan10?>', <?=$countLessThan20?>, '<?=$countLessThan20?>', <?=$countLessThan30?>, '<?=$countLessThan30?>', <?=$countMoreThan30?>, '<?=$countMoreThan30?>', '<?=$SelectedSingleStatus?>'],
            <?php
            }
        }
        ?>
        ]);
        
        var options = {
           
            legend: { position: 'right' },
            isStacked: true,
            hAxis: {
                title: 'Status',
            },
            vAxis: {
                title: 'Count',
                minValue: 0,
            },
            tooltip: {
                trigger: 'both',
                isHtml: true,
            },
            annotations: {
                alwaysOutside: false,
                textStyle: {
                fontSize: 8,
                },
            },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('CompanyWithSameStatusChart'));

        chart.draw(data, options);
    }

</script>


<script>
    $("#example1").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

    // Get all category cards
        const categoryCards = document.querySelectorAll('.card-header .card');
        // Get all filter items
        const filterItems = document.querySelectorAll('.filter-item');

    // Function to filter grid items
            function filterItemsByCategory(partnerType) {
                filterItems.forEach(item => {
                    // Check if the data-partnerType matches the selected partnerType
                    if (item.dataset.partnertype1 === partnerType || partnerType === 'All') {
                        item.style.display = 'block';  // Show item
                    } else {
                        item.style.display = 'none';   // Hide item
                    }
                });
            }

            // Attach click event listeners to category cards
            categoryCards.forEach(card => {
                card.addEventListener('click', function() {
                    const partnerType = this.dataset.partnertype1;
                    console.log('Selected Partner Type:', partnerType); // Debugging
                    filterItemsByCategory(partnerType);
                });
            });

            // Optional: Show all items by default
            filterItemsByCategory('All');
    });
</script>

<script>
    $(document).ready(function() {
        
        $("#status").change(function(){

            var selectedPartnerType = $(this).val(); 

            if (selectedPartnerType.includes('select_all')) {
            // Select all options
                $('#status option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedPartnerType = $('#status option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();

                selectedPartnerType = selectedPartnerType.filter(function(value) {
                    return value !== null;
                });
            }
        });
            
    });
</script>



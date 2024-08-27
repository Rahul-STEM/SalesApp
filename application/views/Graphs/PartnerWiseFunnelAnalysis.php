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
                                <h5>Partner Wise Funnel Analysis</h5>
                            </center>
                        </div>
                        <div class="card-body FilterSection">
                            <form method="POST" action="<?=base_url();?>GraphNew/PartnerWiseFunnelAnalysis/<?php ?>">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="startDate">Start Date</label>
                                        <input id="startDate" name="startDate" class="form-control" type="date" value="<?=$sdate ?>"/>
                                        
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="endDate">End Date</label>
                                        <input id="endDate" class="form-control" name="endDate" type="date" value="<?=$edate ?>"/>
                                    </div>
                                    
                                    <!-- Cluster -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Partner Type</label>
                                            <select class="custom-select rounded-0" name="partnerType[]" id="partnerType" multiple>
                                                <option value="select_all">Select All</option>
                                                <?php foreach($partner_type as $partner) { ?>
                                                    <option value="<?= $partner->id ?>"><?= $partner->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Users -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select User</label>
                                            <select id="user" class="custom-select rounded-0" name="user[]" data-live-search="true" multiple>
                                            </select>
                                        </div>
                                    </div> -->

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
                                <div id="PartnerWisePieChart" style="width: 100%; height: 400px;"></div>
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
                                                        <?php foreach ($GraphData as $GraphDataSingle) { 
                                                            // var_dump($GraphDataSingle);
                                                            ?>
                                                            <div class="col-md-2 mb-2" >
                                                                <div class="card card p-2 col-sm m-auto bg-light" data-partnerType1="<?= htmlspecialchars($GraphDataSingle->PartnerMasterName) ?>">
                                                                    <strong>
                                                                        <a href="#" style="color:<?=$GraphDataSingle->PartnerMasterclr?>">
                                                                            <?=$GraphDataSingle->PartnerMasterName?> - <?=$GraphDataSingle->cont?>
                                                                        </a>
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                    <?php foreach($TableData as $TableDataGrid){
                                                        $tblc=$this->Graph_Model->get_tblbyidwithremark($TableDataGrid->ic_id);
                                                        if (sizeof($tblc) != 0) {
                                                            $remark=$tblc[0]->remarks;
                                                            $lastUpdateDate = $tblc[0]->updateddate;
                                                            $currentDate = new DateTime();
                                                            // var_dump($currentDate);die;
                                                           $NoUpdateSince = date_diff_format($lastUpdateDate, $currentDate->format('Y-m-d H:i:s'));
                                                        }else{
                                                            $remark= "";
                                                            $lastUpdateDate = "";
                                                            $NoUpdateSince = "";
                                                        }   
                                                        ?> 
                                                        <div class="col-md-4 mb-4 filter-item" data-partnerType1="<?= htmlspecialchars($TableDataGrid->partner_typeName) ?>">
                                                            <div class="card-body p-3 border rounded border-success hover-div d-flex flex-column align-items-stretch h-100 text-dark">
                                                                <!-- City : <br>
                                                                <strong><?= $TableDataGrid->city ?></strong><hr> -->
                                                                Current Status : <br>
                                                                <strong><?= $TableDataGrid->stname ?></strong><hr>
                                                                Company Name : <br>
                                                                <strong><?= $TableDataGrid->company_name ?></strong><hr>
                                                                Partner Type : <br>
                                                                <strong style="color:<?=$TableDataGrid->PartnerMasterclr?>"><?= $TableDataGrid->partner_typeName ?></strong><hr>
                                                                Current Remark<br><b style=""><?=$remark?></b><hr>
                                                                Last Action Date<br><b><?=$lastUpdateDate?></b><hr>
                                                                Same Status Since<br><b><?=$NoUpdateSince?></b><hr>
                                                                <div class="rounded-circle bg-danger" style="position: absolute;bottom: -10px; left: 40%; transform: translateX(-50%); width: 20px; height: 20px;"></div>
                                                                <div class="rounded-circle bg-danger" style="position: absolute;bottom: -10px; left: 60%; transform: translateX(-50%); width: 20px; height: 20px;"></div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="tab-pane fade" id="TableView" role="tabpanel" aria-labelledby="nav_TableView">
                                            <div class="card card-body">
                                                <div class="table-responsive" id="tbdata">
                                                    <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <!-- <th>City</th> -->
                                                            <th>Current Status</th>
                                                            <th>Company Name</th>
                                                            <th>Partner Type</th>
                                                            <th>Current Remark</th>
                                                            <th>Last Action Date</th>
                                                            <th>Same Status Since</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 

                                                                $i=1;
                                                                foreach($TableData as $TableRow){ 
                                                                    $tblc=$this->Graph_Model->get_tblbyidwithremark($TableRow->ic_id);
                                                                        if (sizeof($tblc) != 0) {
                                                                            $remark=$tblc[0]->remarks;
                                                                            $lastUpdateDate = $tblc[0]->updateddate;
                                                                            $currentDate = new DateTime();
                                                                            // var_dump($currentDate);die;
                                                                        $NoUpdateSince = date_diff_format($lastUpdateDate, $currentDate->format('Y-m-d H:i:s'));
                                                                        }else{
                                                                            $remark= "";
                                                                            $lastUpdateDate = "";
                                                                            $NoUpdateSince = "";
                                                                        }   
                                                                    ?> 
                                                                    <tr>
                                                                        <!-- <td><?= $TableRow->city ?></td> -->
                                                                        <td><?= $TableRow->stname ?></td>
                                                                        <td><?= $TableRow->company_name ?></td>
                                                                        <td style="color:<?=$TableRow->PartnerMasterclr?>"><?= $TableRow->partner_typeName ?></td>
                                                                        <td><?= $remark ?></td>
                                                                        <td><?= $lastUpdateDate ?></td>
                                                                        <td><?= $NoUpdateSince ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="tab-pane fade" id="TabView" role="tabpanel" aria-labelledby="nav_TabView">
                                            <div class="card-body">
                                                <div class="row">
                                                <?php foreach ($GraphData as $GraphDataGrid) { 
                                                    
                                                    $formId = 'hiddenForm_' . htmlspecialchars($GraphDataGrid->PartnerMasterID);
                                                    
                                                    ?>
                                                    <form id="<?= $formId; ?>" action="<?= base_url(); ?>GraphNew/PartnerWiseFunnelGraphData/<?=$GraphDataGrid->PartnerMasterID?>" method="POST" style="display: none;" target="_blank">

                                                        <input type="hidden" name="partnetType_id" value="<?= htmlspecialchars($GraphDataGrid->PartnerMasterID); ?>">
                                                        <input type="hidden" name="sdate" value="<?= htmlspecialchars($sdate); ?>">
                                                        <input type="hidden" name="edate" value="<?= htmlspecialchars($edate); ?>">
                                                    </form>
                                                    <div class="col-md-3 mb-2" >
                                                        <div class="card card p-3 col-sm m-auto bg-light">
                                                            <strong>
                                                                <a href="#" onclick="document.getElementById('<?= $formId; ?>').submit();"  style="color:<?=$GraphDataGrid->PartnerMasterclr ?>"><?=$GraphDataGrid->PartnerMasterName?> - <?=$GraphDataGrid->cont?>
	                                                            </a>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
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
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
    function drawChart() {

        const GraphData = <?php echo json_encode($GraphData); ?>;
        var sdate = <?php echo json_encode($sdate); ?>;
        var edate = <?php echo json_encode($edate); ?>;


        const code = '';
        // console.log(chartData);
        const filteredData = GraphData.filter(item => item.PartnerMasterName && item.cont && item.PartnerMasterID);

        const labels = filteredData.map(item => item.PartnerMasterName);
        const dataValues = filteredData.map(item => Number(item.cont));
        const PartnerMasterID = filteredData.map(item => Number(item.PartnerMasterID));

        const dataArray = [
            ['Partners', 'Count','PartnerTypeId']  // Adjust column names as needed
        ];

        for (let i = 0; i < labels.length; i++) {
            dataArray.push([labels[i],dataValues[i],PartnerMasterID[i]]);
        }

        const data = google.visualization.arrayToDataTable(dataArray);
        const options = {
            title:'Partner Wise Funnel Graph',
            is3D:true
        };

        const chart = new google.visualization.PieChart(document.getElementById('PartnerWisePieChart'));

        google.visualization.events.addListener(chart, 'select', function() {

            var selection = chart.getSelection()[0];
            if (selection) {

                var PartnerMasterID = data.getValue(selection.row, 2);

            // Redirect to another URL with stid and uuid as parameters
                // window.location.href = '<?=base_url();?>GraphNew/CityWiseFunnelGraphData/' + cityid + '/' + sdate + '/' + edate ;
                var url = '<?=base_url();?>GraphNew/PartnerWiseFunnelGraphData/' + PartnerMasterID + '/' + sdate + '/' + edate;
                window.open(url, '_blank');
            }
        });

        chart.draw(data, options);
    }
</script>

<script>
    // Function to handle radio button change
    function handleRadioChange() {
        const selectedRadio = document.querySelector('input[name="radioFilter"]:checked');
        
        if (selectedRadio) {
            const selectedOption = selectedRadio.id;
            
            const filterByClusterID = document.getElementById('cluster');
            const filterByRoleID = document.getElementById('userType');
            
            if (selectedOption === 'filterByCluster') {
                
                filterByClusterID.disabled = false;
                filterByRoleID.disabled = true;

            } else if (selectedOption === 'filterByRole') {

                filterByClusterID.disabled = true;
                filterByRoleID.disabled = false;
            }
        }
    }

    // Attach change event listener to all radio buttons
    document.querySelectorAll('input[name="option"]').forEach(radio => {
        radio.addEventListener('change', handleRadioChange);
    });

</script>

<script>
    $(document).ready(function() {
        
        $("#partnerType").change(function(){

            var selectedPartnerType = $(this).val(); 

            if (selectedPartnerType.includes('select_all')) {
            // Select all options
                $('#partnerType option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedPartnerType = $('#partnerType option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();

                selectedPartnerType = selectedPartnerType.filter(function(value) {
                    return value !== null;
                });
            }
        });
            
    });
</script>



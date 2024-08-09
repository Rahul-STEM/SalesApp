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
                                <h5>Funnel Analysis</h5>
                            </center>
                        </div>
                        <div class="card-body FilterSection">
                            <form method="POST" action="<?=base_url();?>GraphNew/FunnelAnalysis/<?php ?>">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="startDate">Start Date</label>
                                        <input id="startDate" name="startDate" class="form-control" type="date" value="<?=$sdate ?>"/>
                                        
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="endDate">End Date</label>
                                        <input id="endDate" class="form-control" name="endDate" type="date" value="<?=$edate ?>"/>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="endDate">Select User Filter</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioFilter" id="filterByRole" onchange="handleRadioChange()">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Filter By Role
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioFilter" id="filterByCluster" onchange="handleRadioChange()">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Filter By Cluster
                                                </label>
                                            </div>
                                    </div>
                                    <!-- User Role -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Role</label>
                                            <select class="custom-select rounded-0" name="userType[]" id="userType" multiple disabled>
                                                <option value="select_all">Select All</option>
                                                <?php foreach($roles as $r) {
                                                ?>
                                                <option value="<?= $r->id ?>"><?= $r->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Cluster -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Cluster</label>
                                            <select class="custom-select rounded-0" name="cluster[]" id="cluster" multiple disabled>
                                                <option value="select_all">Select All</option>
                                                <?php foreach($clusters as $cluster) {
                                                ?>
                                                    <option value="<?= $cluster->id ?>"><?= $cluster->cluster_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Users -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select User</label>
                                            <select id="user" class="custom-select rounded-0" name="user[]" data-live-search="true" multiple>
                                                

                                            </select>
                                        </div>
                                    </div>

                                    <!-- Partner Type -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Partner Type</label>
                                            <select class="custom-select rounded-0" name="partnerType[]" id="partnerType" multiple>
                                                <option value="select_all">Select All</option>
                                                <?php foreach($partner_type as $pt) {
                                                ?>
                                                <option value="<?= $pt->id ?>"><?= $pt->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Category Type -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Category</label>
                                            <select class="custom-select rounded-0" name="category[]" id="category" multiple>
                                                <option value="select_all">Select All</option>
                                                <option value="upsell_client">Upsell Client</option>
                                                <option value="focus_funnel">Focus Funnel</option>
                                                <option value="keycompany">Key Client</option>
                                                <option value="pkclient">Positive Key Client</option>
                                                <option value="priorityc">Priority Calling</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
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
                                <div id="StatusWisePieChart" style="width: 100%; height: 400px;"></div>

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
                                                        <?php foreach ($FunnelData as $FunnelDataSingle) { ?>
                                                            <div class="col-md-2 mb-2" >
                                                                <div class="card card p-2 col-sm m-auto bg-light" data-category="<?= htmlspecialchars($FunnelDataSingle->stname) ?>">
                                                                    <strong>
                                                                        <a href="#" style="color:<?=$FunnelDataSingle->stclr?>">
                                                                            <?=$FunnelDataSingle->stname?> - <?=$FunnelDataSingle->cont?>
                                                                        </a>
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        <?php    }?>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                    <?php foreach($TableData as $TableDataGrid){ 
                                                            // echo "<pre>";
                                                            // print_r($TableData);die;
                                                            $tblc=$this->Graph_Model->get_tblbyidwithremark($TableDataGrid->ic_id);

                                                            if(!empty($tblc[0]->updateddate) ){

                                                                $updatedDate = $tblc[0]->updateddate;
                                                                $currentDate = new DateTime();
                                                                $updatedDateObj = new DateTime($updatedDate);
                                                                $interval = $currentDate->diff($updatedDateObj);
                                                                $diffInDays = $interval->days;
                                                                $diffInHours = $interval->h;
                                                                $diffInMinutes = $interval->i;

                                                            // Create a single string variable
                                                                $diffString = sprintf('%d days, %d hours, %d minutes', $diffInDays, $diffInHours, $diffInMinutes);
                                                            }else{
                                                                $updatedDate = 'NA';
                                                                $diffString ='NA';
                                                            }
                                                            // $updatedDate = $tblc[0]->updateddate;
                                                            
                                                            // var_dump($interval);die;
                                                        ?>
                                                        <div class="col-md-4 mb-4 filter-item" data-category="<?= htmlspecialchars($TableDataGrid->stname) ?>">
                                                            <div class="card-body p-3 border rounded border-success hover-div d-flex flex-column align-items-stretch h-100 text-dark">

                                                                Current Status<br><b style="color:<?=$TableDataGrid->stclr?>"><?=$TableDataGrid->stname?></b><hr>
                                                                Company Name<br><b><?=$TableDataGrid->company_name?></b><hr>
                                                                <!-- Address<br><b><?=$TableDataGrid->company_address?></b><hr>
                                                                City<br><b><?=$TableDataGrid->city?></b><hr>
                                                                State<br><b><?=$TableDataGrid->state?></b><hr> -->
                                                                Partner Type<br><b style=""><?=$TableDataGrid->partner_type?></b><hr>
                                                                Current Remark<br><b style=""><?=$tblc[0]->remarks?></b><hr>
                                                                Last Action Done By<br><b><?=$tblc[0]->last_updated_by?></b><hr>
                                                                Last Action Date<br><b><?=$tblc[0]->updateddate?></b><hr>
                                                                <!-- Last Remark on the company<br><hr> -->
                                                                Same Status Since<br><b><?=$diffString?></b><hr>
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
                                                            <tr>
                                                                <th>S NO</th>
                                                                <th>Current Status</th>
                                                                <th>Company Name</th>
                                                                <!-- <th>Address</th>
                                                                <th>City</th>
                                                                <th>State</th> -->
                                                                <th>Partner Type</th>
                                                                <!-- <th>Category</th> -->
                                                                <th>Current Remark</th>
                                                                <!-- <th>Last Action Done By</th> -->
                                                                <th>Last Updated</th>
                                                                <th>Same Status from Current Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 

                                                                $i=1;
                                                                foreach($TableData as $TableRow){

                                                                    $tblc=$this->Graph_Model->get_tblbyidwithremark($TableRow->ic_id);
                                                                    if(!empty($tblc[0]->updateddate) ){

                                                                    $updatedDate = $tblc[0]->updateddate;
                                                                    $currentDate = new DateTime();
                                                                    $updatedDateObj = new DateTime($updatedDate);
                                                                    $interval = $currentDate->diff($updatedDateObj);
                                                                    $diffInDays = $interval->days;
                                                                    $diffInHours = $interval->h;
                                                                    $diffInMinutes = $interval->i;

                                                                // Create a single string variable
                                                                    $diffString = sprintf('%d days, %d hours, %d minutes', $diffInDays, $diffInHours, $diffInMinutes);
                                                                }else{
                                                                    $updatedDate = 'NA';
                                                                    $diffString ='NA';
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td><?= $i++?></td>
                                                                <td><?= $TableRow->stname?></td>
                                                                <td><?= $TableRow->company_name?></td>
                                                                <!-- <td><?= $TableRow->company_address?></td>
                                                                <td><?= $TableRow->city?></td>
                                                                <td><?= $TableRow->state?></td> -->
                                                                <td><?= $TableRow->partner_type?></td>
                                                                <td><?= $tblc[0]->remarks?></td>
                                                                <!-- <td><?= $tblc[0]->last_updated_by?></td> -->
                                                                <td><?= $tblc[0]->updateddate?></td>
                                                                <td><?= $diffString?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        
                                                        </tbody>
                                                    </table>
    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="TabView" role="tabpanel" aria-labelledby="nav_TabView">
                                            <div class="card card-body">
                                                <div class="row">
                                                    <?php

                                                        $arrayselected_partnerType = json_encode($selected_partnerType);
                                                        $arrayselected_cluster = json_encode($selected_cluster);
                                                        $arrayselected_user = json_encode($selected_users);
                                                        $arrayselected_category = json_encode($selected_category);
           
                                                    ?>
                                                    <?php foreach ($FunnelData as $FunnelDataSingle) { 

                                                            $formId = 'hiddenForm_' . htmlspecialchars($FunnelDataSingle->stid);
                                                        ?>
                                                        
                                                        <form id="<?= $formId; ?>" action="<?= base_url(); ?>GraphNew/StatusWiseFunnelData/<?=$FunnelDataSingle->stid?>" method="POST" style="display: none;">
                                                            <input type="hidden" name="selected_partnerType" value="<?= htmlspecialchars($arrayselected_partnerType); ?>">

                                                            <input type="hidden" name="arrayselected_cluster" value="<?= htmlspecialchars($arrayselected_cluster)?>">

                                                            <input type="hidden" name="arrayselected_user" value="<?=htmlspecialchars($arrayselected_user) ?>">

                                                            <input type="hidden" name="stid" value="<?= htmlspecialchars($FunnelDataSingle->stid); ?>">

                                                            <input type="hidden" name="sdate" value="<?= htmlspecialchars($sdate); ?>">
                                                            <input type="hidden" name="edate" value="<?= htmlspecialchars($edate); ?>">
                                                        </form>
                                                        <div class="col-md-3 mb-2" >
                                                            <div class="card card p-3 col-sm m-auto bg-light">
                                                                <strong>
                                                                    <a href="#" onclick="document.getElementById('<?= $formId; ?>').submit();" style="color:<?=$FunnelDataSingle->stclr?>">
                                                                        <?=$FunnelDataSingle->stname?> - <?=$FunnelDataSingle->cont?>
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
    function filterItemsByCategory(category) {
        filterItems.forEach(item => {
            if (item.dataset.category === category || category === 'All') {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Attach click event listeners to category cards
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.dataset.category;
            filterItemsByCategory(category);
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

        const chartData = <?php echo json_encode($FunnelData); ?>;
        // const code = <?php //echo ($code); ?>;
        var sdate = <?php echo json_encode($sdate); ?>;
        var edate = <?php echo json_encode($edate); ?>;
        var selected_partnerType = <?php echo json_encode($selected_partnerType); ?>;
        var selected_category = <?php echo json_encode($selected_category); ?>;

        // console.log(sdate);
        const code = '';
        // console.log(chartData);
        const filteredData = chartData.filter(item => item.stname && item.cont);

                // Map labels and values
        const labels = filteredData.map(item => item.stname);
        const dataValues = filteredData.map(item => Number(item.cont));

        const dataArray = [
            ['Status', 'Count']  // Adjust column names as needed
        ];

        for (let i = 0; i < labels.length; i++) {
            dataArray.push([labels[i], dataValues[i]]);
        }

        const data = google.visualization.arrayToDataTable(dataArray);
        const options = {
            title:'Status Wise Funnel Graph',
            is3D:true
        };

        const chart = new google.visualization.PieChart(document.getElementById('StatusWisePieChart'));

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
        
        $("#userType").change(function(){

            var selectedUserType = $(this).val(); 
            if (selectedUserType.includes('select_all')) {
            // Select all options
                $('#userType option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedUserType = $('#userType option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();

                selectedUserType = selectedUserType.filter(function(value) {
                    return value !== null;
                });
            }

            $.ajax({
                url: '<?=base_url();?>Dashboard/getRoleUser_New',
                type: 'POST', 
                data: {RoleId: selectedUserType},
                success: function(response) {
                    // alert(response);
                    $("#user").html(response);
                    $('#user').prop('required',true);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $("#user").change(function(){

            var selectedUser = $(this).val(); 
            if (selectedUser.includes('select_all')) {
            // Select all options
                $('#user option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedUser = $('#user option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();

                selectedUser = selectedUser.filter(function(value) {
                    return value !== null;
                });
            }
            // var selectedValues = $("#userType").val(); // Get selected values
        });


        $("#cluster").change(function(){

            var selectedCluster = $(this).val(); 

            if (selectedCluster.includes('select_all')) {
            // Select all options
                $('#cluster option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedCluster = $('#cluster option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();

                selectedCluster = selectedCluster.filter(function(value) {
                    return value !== null;
                });
            }

            $.ajax({
                url: '<?=base_url();?>GraphNew/getUserByCluster',
                type: 'POST', 
                data: {clusterId: selectedCluster},
                success: function(response) {
                    $("#user").html(response);
                    $('#user').prop('required',true);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        });

        $("#category").change(function(){

            var selectedCategory = $(this).val(); 

            if (selectedCategory.includes('select_all')) {
            // Select all options
                $('#category option').prop('selected', true);
                // Remove 'select_all' from the selected values
                selectedCategory = $('#category option').map(function() {
                    return this.value !== 'select_all' ? this.value : null;
                }).get();

                selectedCategory = selectedCategory.filter(function(value) {
                    return value !== null;
                });
            }

        });

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
<!--  -->


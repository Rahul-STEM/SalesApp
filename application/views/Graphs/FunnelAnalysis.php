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
<style type="text/css">      
      html, body, #container { 
        width: 100%; height: 100%; margin: 0; padding: 0; 
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
                                    <?php
                                        // var_dump($userType);die;
                                    ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Role</label>
                                            <select class="custom-select rounded-0" name="userType[]" id="userType" multiple disabled>
                                                <option value="select_all">Select All</option>
                                                <?php foreach($roles as $r) {
                                                ?>
                                                <option value="<?= $r->id ?>" <?= in_array($r->id, $userType) ? 'selected' : '' ?>><?= $r->name ?></option>
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
                                                    <option value="<?= $cluster->id ?> <?= in_array($cluster->id, $selected_cluster) ? 'selected' : '' ?>"><?= $cluster->cluster_name ?></option>
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
                                                <option value="<?= $pt->id ?>"  <?= in_array($pt->id, $selected_partnerType) ? 'selected' : '' ?>><?= $pt->name ?></option>
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
                                                <!-- <option value="upsell_client">Upsell Client</option>
                                                <option value="focus_funnel">Focus Funnel</option>
                                                <option value="keycompany">Key Client</option>
                                                <option value="pkclient">Positive Key Client</option>
                                                <option value="priorityc">Priority Calling</option> -->
                                                <option value="topspender" <?= in_array('topspender', $selected_category) ? 'selected' : '' ?>>Top Spender</option>
                                                <option value="focus_funnel" <?= in_array('focus_funnel', $selected_category) ? 'selected' : '' ?>>Focus Funnel</option>
                                                <option value="upsell_client" <?= in_array('upsell_client', $selected_category) ? 'selected' : '' ?>>Upsell Client</option>
                                                <option value="keycompany" <?= in_array('keycompany', $selected_category) ? 'selected' : '' ?>>Key Company</option>
                                                <option value="pkclient" <?= in_array('pkclient', $selected_category) ? 'selected' : '' ?>>Key Client</option>
                                                <option value="priorityc" <?= in_array('priorityc', $selected_category) ? 'selected' : '' ?>>Priority Client</option>
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

                                <div id="container" style="width: 100%; height: 400px;"></div>
                                
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

                                                        ?>
                                                        <div class="col-md-4 mb-4 filter-item" data-category="<?= htmlspecialchars($TableDataGrid->stname) ?>">
                                                            <div class="card-body p-3 border rounded border-success hover-div d-flex flex-column align-items-stretch h-100 text-dark">

                                                                Current Status<br><b style="color:<?=$TableDataGrid->stclr?>"><?=$TableDataGrid->stname?></b><hr>
                                                                Company Name<br><b><?=$TableDataGrid->company_name?></b><hr>
                                                                Partner Type<br><b style=""><?=$TableDataGrid->partner_type?></b><hr>
                                                                Current Remark<br><b style=""><?=$tblc[0]->remarks?></b><hr>
                                                                Last Action Done By<br><b><?=$tblc[0]->last_updated_by?></b><hr>
                                                                Last Action Date<br><b><?=$tblc[0]->updateddate?></b><hr>
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
                                                        $arrayselected_userType = json_encode($userType);
           
                                                    ?>
                                                    <?php foreach ($FunnelData as $FunnelDataSingle) { 

                                                            $formId = 'hiddenForm_' . htmlspecialchars($FunnelDataSingle->stid);
                                                        ?>
                                                        
                                                        <form id="<?= $formId; ?>" action="<?= base_url(); ?>GraphNew/StatusWiseFunnelData/<?=$FunnelDataSingle->stid?>" method="POST" style="display: none;" target="_blank">
                                                            <input type="hidden" name="selected_partnerType" value="<?= htmlspecialchars($arrayselected_partnerType); ?>">

                                                            <input type="hidden" name="arrayselected_cluster" value="<?= htmlspecialchars($arrayselected_cluster)?>">

                                                            <input type="hidden" name="arrayselected_user" value="<?=htmlspecialchars($arrayselected_user) ?>">

                                                            <input type="hidden" name="arrayselected_userType" value="<?=htmlspecialchars($arrayselected_userType) ?>">

                                                            <input type="hidden" name="arrayselected_category" value="<?=htmlspecialchars($arrayselected_category) ?>">

                                                            <input type="hidden" name="stid" value="<?= htmlspecialchars($FunnelDataSingle->stid); ?>">

                                                            <input type="hidden" name="sdate" value="<?= htmlspecialchars($sdate); ?>">
                                                            <input type="hidden" name="edate" value="<?= htmlspecialchars($edate); ?>">
                                                        </form>
                                                        <div class="col-md-3 mb-2" >
                                                            <div class="card card p-3 col-sm m-auto bg-light">
                                                                <strong>
                                                                    <a href="javascript:void(0);" onclick="document.getElementById('<?= $formId; ?>').submit();" style="color:<?=$FunnelDataSingle->stclr?>">
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
        var sdate = <?php echo json_encode($sdate); ?>;
        var edate = <?php echo json_encode($edate); ?>;
        var selected_category = <?php echo json_encode($selected_category); ?>;
        var selected_partnerType = <?php echo json_encode($selected_partnerType); ?>;
        var selected_userType = <?php echo json_encode($userType); ?>;
        var selected_cluster = <?php echo json_encode($selected_cluster); ?>;
        var selected_users = <?php echo json_encode($selected_users); ?>;
        var uid = <?php echo json_encode($uid); ?>;
        
        // console.log(selected_cluster);

        var selectedPartnerTypeString = JSON.stringify(selected_partnerType);
        var selected_categoryString = JSON.stringify(selected_category);
        var selected_clusterString = JSON.stringify(selected_cluster);
        var selected_usersString = JSON.stringify(selected_users);
        var selected_userTypeString = JSON.stringify(selected_userType);
        // var uid = JSON.stringify(uid);

        // console.log(selectedPartnerTypeString);
        const code = '';
        const filteredData = chartData.filter(item => item.stname && item.cont && item.stid);
        // console.log(chartData);

                // Map labels and values
        const labels = filteredData.map(item => item.stname);
        const dataValues = filteredData.map(item => Number(item.cont));
        const stid = filteredData.map(item => Number(item.stid));

        const dataArray = [
            ['Status', 'Count','StatusID']  // Adjust column names as needed
        ];

        for (let i = 0; i < labels.length; i++) {
            dataArray.push([labels[i], dataValues[i], stid[i]]);
        }

        const data = google.visualization.arrayToDataTable(dataArray);
        const options = {
            title:'Status Wise Funnel Graph',
            is3D:true
        };

        const chart = new google.visualization.PieChart(document.getElementById('StatusWisePieChart'));

        google.visualization.events.addListener(chart, 'select', function() {
            var selection = chart.getSelection()[0];
            if (selection) {


                var stid = data.getValue(selection.row, 2);
                // var sdate = encodeURIComponent(sdate);
                // var edate = encodeURIComponent(edate);
                // var selected_partnerType = encodeURIComponent(selected_partnerType);

                // Create a hidden form
                var form = document.createElement('form');
                form.method = 'POST'; // Use POST method
                form.action = '<?=base_url();?>GraphNew/StatusWiseFunnelGraphData';
                form.target = '_blank';

                // Create hidden input fields
                var inputStid = document.createElement('input');
                inputStid.type = 'hidden';
                inputStid.name = 'stid';
                inputStid.value = stid;
                form.appendChild(inputStid);

                var inputSdate = document.createElement('input');
                inputSdate.type = 'hidden';
                inputSdate.name = 'sdate';
                inputSdate.value = sdate;
                form.appendChild(inputSdate);

                var inputEdate = document.createElement('input');
                inputEdate.type = 'hidden';
                inputEdate.name = 'edate';
                inputEdate.value = edate;
                form.appendChild(inputEdate);

                var inputuid = document.createElement('input');
                inputuid.type = 'hidden';
                inputuid.name = 'uid';
                inputuid.value = uid;
                form.appendChild(inputuid);
                

                var inputSelectedPartnerType = document.createElement('input');
                inputSelectedPartnerType.type = 'hidden';
                inputSelectedPartnerType.name = 'selected_partnerType';
                inputSelectedPartnerType.value = selectedPartnerTypeString;
                form.appendChild(inputSelectedPartnerType);

                var inputselected_userType = document.createElement('input');
                inputselected_userType.type = 'hidden';
                inputselected_userType.name = 'selected_userType';
                inputselected_userType.value = selected_userTypeString;
                form.appendChild(inputselected_userType);

                var inputselected_cluster = document.createElement('input');
                inputselected_cluster.type = 'hidden';
                inputselected_cluster.name = 'selected_cluster';
                inputselected_cluster.value = selected_clusterString;
                form.appendChild(inputselected_cluster);

                var inputselected_users = document.createElement('input');
                inputselected_users.type = 'hidden';
                inputselected_users.name = 'selected_users';
                inputselected_users.value = selected_usersString;
                form.appendChild(inputselected_users);

                var inputselected_category = document.createElement('input');
                inputselected_category.type = 'hidden';
                inputselected_category.name = 'selected_category';
                inputselected_category.value = selected_categoryString;
                form.appendChild(inputselected_category);
                // Append the form to the body and submit
                
                document.body.appendChild(form);
                form.submit();

            }
        });

        chart.draw(data, options);
    }
</script>


<!-- <script src="https://d3js.org/d3.v5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3-sankey/0.12.3/d3-sankey.v0.12.3.min.js"></script> -->


<!-- <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-sankey.min.js"></script> -->


<script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-bundle.min.js"></script>


<!-- <script>
      anychart.onDocumentReady(function () {
  
        // add data
        const data = [
          {from: "First Class", to: "Child", value: 6},
          {from: "Second Class", to: "Child", value: 24},
          {from: "Third Class", to: "Child", value: 79},
          {from: "Crew", to: "Child", value: 0},
          {from: "First Class", to: "Adult", value: 319},
          {from: "Second Class", to: "Adult", value: 261},
          {from: "Third Class", to: "Adult", value: 627},
          {from: "Crew", to: "Adult", value: 885},
          {from: "Child", to: "Female", value: 45},
          {from: "Child", to: "Male", value: 64},
          {from: "Adult", to: "Female", value: 425},
          {from: "Adult", to: "Male", value: 1667},
          {from: "Female", to: "Survived", value: 344},
          {from: "Female", to: "Perished", value: 126},
          {from: "Male", to: "Survived", value: 367},
          {from: "Male", to: "Perished", value: 1364}
        ];
  
        // create a sankey diagram instance
        let chart = anychart.sankey();

        // load the data to the sankey diagram instance
        chart.data(data);

        // set the chart's padding
        // chart.padding(20, 40);
        // chart.height(1000)
        // add a title
        chart.title('Titanic Survivors');
  
        // set the chart container id
        chart.container("container");

        // draw the chart
        chart.draw();
  
      });
    </script> -->


<!-- <script>
    anychart.onDocumentReady(function () {
        // Get nodes and links data from PHP
        const nodes = <?php echo json_encode($nodesJson); ?>;
        const links = <?php echo json_encode($linksJson); ?>;

        // Check if links is an array
        if (!Array.isArray(links)) {
            console.error("Links is not an array:", links);
            return;
        }

        // Prepare the data for AnyChart
        // const data = links.map(link => {

        //     const sourceNode = nodes[link.IDsource];
        //     const targetNode = nodes[link.IDtarget];

        //     // Check if both source and target nodes are defined
        //     if (!sourceNode || !targetNode) {
        //         console.error("Invalid source or target node:", link);
        //         return null; // Skip invalid entries
        //     }

        //     // Assuming IDValue should be a property directly in link
        //     const value = link.IDValue || 0; // Ensure value is defined

        //     return {
        //         from: sourceNode.name,
        //         to: targetNode.name,
        //         value: value
        //     };

        // }).filter(item => item !== null); // Filter out any null entries

        

        // console.log("Prepared Data for Sankey:", data);

        // // Create a Sankey diagram instance
        // let chart = anychart.sankey();

        // // Load the data into the Sankey diagram instance
        // chart.data(data);

        // // Add a title
        // chart.title('Status Wise Sankey Chart');

        // // Set the chart container id
        // chart.container("container");

        // // Draw the chart
        // chart.draw();
    });
</script> -->


<!-- <script>
    anychart.onDocumentReady(function () {
  
    // Get nodes and links data from PHP
        const nodes = <?php // echo json_encode($nodesJson); ?>;
        const links = <?php // echo json_encode($linksJson); ?>;

    // console.log("links:", links);
    // Prepare the data for AnyChart
        if (!Array.isArray(links)) {
        console.error("Links is not an array:", links);
        return;
        }

    // Prepare the data for AnyChart
        const data = links.map(link => {

            const sourceNode = nodes[link.IDsource];
            const targetNode = nodes[link.IDtarget];


            // Check if both source and target nodes are defined
            return {
                from: sourceNode.name,
                to: targetNode.name,
                value: link.IDValue || 0 
            };
        }).filter(item => item !== null); // Filter out any null entries

        console.log("data", data);

        // Create a sankey diagram instance
        let chart = anychart.sankey();

        // Load the data to the sankey diagram instance
        chart.data(data);

        // Add a title
        chart.title('Status Wise Sankey Chart');

        // Set the chart container id
        chart.container("container");
        // Draw the chart
        chart.draw();
    });
</script> -->


<!-- <script>
    const nodes = <?php // echo $nodesJson; ?>;
    const links = <?php // echo $linksJson; ?>;

    // console.log(nodes);
    // Set the dimensions and margins of the diagram
    const margin = {top: 10, right: 30, bottom: 30, left: 40},
          width = 800 - margin.left - margin.right,
          height = 600 - margin.top - margin.bottom;

    const svg = d3.select("#StatusWiseSankeyChart").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    const sankey = d3.sankey()
        .nodeWidth(40)
        .nodePadding(20)
        .size([width, height]);

    const path = sankey.link();

    // Create the sankey diagram
    const graph = {nodes: nodes, links: links};

    sankey(graph);

    // Add in the links
    const link = svg.append("g").selectAll(".link")
        .data(graph.links)
      .enter().append("path")
        .attr("class", "link")
        .attr("d", path)
        .style("stroke-width", d => Math.max(1, d.value))
        .style("fill", "none")
        .style("stroke", "#000");

    // Add the node rectangles
    const node = svg.append("g").selectAll(".node")
        .data(graph.nodes)
      .enter().append("g")
        .attr("class", "node")
        .attr("transform", d => "translate(" + d.x0 + "," + d.y0 + ")");

    node.append("rect")
        .attr("height", d => d.y1 - d.y0)
        .attr("width", sankey.nodeWidth())
        .style("fill", "#aaa")
        .append("title")
        .text(d => d.name);

    // Add the node text labels
    node.append("text")
        .attr("x", -6)
        .attr("y", d => (d.y1 + d.y0) / 2)
        .attr("dy", "0.35em")
        .attr("text-anchor", "end")
        .text(d => d.name)
      .filter(d => d.x0 < width / 2)
        .attr("x", 6 + sankey.nodeWidth())
        .attr("text-anchor", "start");
</script> -->


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




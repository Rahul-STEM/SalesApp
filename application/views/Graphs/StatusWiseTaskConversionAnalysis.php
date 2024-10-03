<style>
    #tabs .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        /* color: #0062cc; */
        background-color: #ffc107;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bolder;
    }

    .nav-tabs .nav-link {
        background-color: white;
        color: black;
        font-weight: 600;
    }

    .nav-tabs .nav-link:hover {
        background-color: #dfd5ef;
        color: #000;
        /* border-color: #007bff; Add a border color on hover */
        border-radius: 0.25rem;
        /* Optional: Rounded corners */
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
                                <h5>Status Wise Task Conversion</h5>
                            </center>
                        </div>
                        <div class="card-body FilterSection">
                            <form method="POST" action="<?= base_url(); ?>GraphNew/StatusWiseTaskConversion/<?php ?>">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="startDate">Start Date</label>
                                        <input id="startDate" name="startDate" class="form-control" type="date" value="<?= $sdate ?>" />
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="endDate">End Date</label>
                                        <input id="endDate" class="form-control" name="endDate" type="date" value="<?= $edate ?>" />
                                    </div>
                                    <!-- <div class="col-lg-3 col-sm-6">
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
                                    </div> -->
                                    
                                    <!-- User Role -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Role</label>
                                            <select class="custom-select rounded-0" name="userType[]" id="userType" multiple required>
                                                <option value="select_all">Select All</option>
                                                <?php foreach ($roles as $r) {
                                                ?>
                                                    <option value="<?= $r->id ?>" <?= in_array($r->id, $Selected_userType) ? 'selected' : '' ?>><?= $r->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Cluster -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Cluster</label>
                                            <select class="custom-select rounded-0" name="cluster[]" id="cluster" multiple disabled>
                                                <option value="select_all">Select All</option>
                                                <?php foreach ($clusters as $cluster) {
                                                ?>
                                                    <option value="<?= $cluster->id ?>"><?= $cluster->cluster_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> -->

                                    <!-- Users -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select User</label>
                                            <select id="user" class="custom-select rounded-0" name="user[]" data-live-search="true" multiple required>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Partner Type -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Partner Type</label>
                                            <select class="custom-select rounded-0" name="partnerType[]" id="partnerType" multiple>
                                                <option value="select_all">Select All</option>
                                                <?php foreach ($partner_type as $pt) {
                                                ?>
                                                    <option value="<?= $pt->id ?>" <?= in_array($pt->id, $selected_partnerType) ? 'selected' : '' ?>><?= $pt->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!-- Category Type -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Category</label>
                                            <select class="custom-select rounded-0" name="category[]" id="category" multiple>
                                                <option value="select_all">Select All</option>
                                                <option value="topspender" <?= in_array('topspender', $selected_category) ? 'selected' : '' ?>>Top Spender</option>
                                                <option value="focus_funnel" <?= in_array('focus_funnel', $selected_category) ? 'selected' : '' ?>>Focus Funnel</option>
                                                <option value="upsell_client" <?= in_array('upsell_client', $selected_category) ? 'selected' : '' ?>>Upsell Client</option>
                                                <option value="keycompany" <?= in_array('keycompany', $selected_category) ? 'selected' : '' ?>>Key Company</option>
                                                <option value="pkclient" <?= in_array('pkclient', $selected_category) ? 'selected' : '' ?>>Key Client</option>
                                                <option value="priorityc" <?= in_array('priorityc', $selected_category) ? 'selected' : '' ?>>Priority Client</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-3 col-sm-6">
                                        <button type="submit" name="submit" class="btn btn-primary">Filter</button>
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
                                <canvas id="ActionWiseTaskConversion" style="width: 100%; height: 300px;"></canvas>

                                <hr>

                                <div id="StatusWisePieChart1">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav_GridView" data-toggle="tab" href="#GridView" role="tab" aria-controls="GridView" aria-selected="true">Grid View</a>
                                            <a class="nav-item nav-link" id="nav_TableView" data-toggle="tab" href="#TableView" role="tab" aria-controls="TableView" aria-selected="false">XLS View</a>
                                            <!-- <a class="nav-item nav-link" id="nav_TabView" data-toggle="tab" href="#TabView" role="tab" aria-controls="TabView" aria-selected="false">Tab View</a> -->
                                        </div>
                                    </nav>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="GridView" role="tabpanel" aria-labelledby="nav_GridView">
                                            <div class="card">
                                                <div class="card-body">
                                                    
                                                <div class="row">
                                                    <?php 

                                                        $oldd = '';
                                                        $newd='';
                                                    
                                                    foreach($TableData as $TableDataGrid){ 
                                                            // echo "<pre>";
                                                            // print_r($TableDataGrid);die;
                                                            if($oldd==''){
                                                                
                                                                $oldd = $TableDataGrid->updateddate;
                                                            } 
                                                            
                                                            $newd = $TableDataGrid->updateddate;

                                                        ?>
                                                        <div class="col-md-4 mb-4 filter-item" data-category="">
                                                            <div class="card p-3 border rounded border-success hover-div d-flex flex-column align-items-stretch h-100 text-center">
                                                                <div class="custom-border-card">
                                                                    <!-- <span class="custom-border-text"><h5>Time Diff Between to Task : <?=$this->Menu_model->timediff($oldd, $newd);?></h5>
                                                                </span> -->
                                                                    <div class="card-body">
                                                                        Action<br><b style="color:<?=$TableDataGrid->aclr?>"><?=$TableDataGrid->acname?></b><hr>
                                                                        Before Status<br><b style="color:<?=$TableDataGrid->bsclr?>"><?=$TableDataGrid->bstatus?></b><hr>
                                                                        After Status<br><b style="color:<?=$TableDataGrid->asclr?>"><?=$TableDataGrid->astatus?></b><hr>
                                                                        Company Name<br><a href="<?=base_url();?>Menu/CompanyDetails/<?=$TableDataGrid->cid?>"><b style="color:<?=$TableDataGrid->pclr?>"><?=$TableDataGrid->compname?><a></a><br>(<?=$TableDataGrid->pname?>)</b><hr>
                                                                        Task By<br><b><?=$TableDataGrid->uname?></b><hr>
                                                                        Task Plan<br><b><?=$this->Menu_model->get_dformat($TableDataGrid->appointmentdatetime)?></b><hr>
                                                                        Task Inistaed<br><b><?=$this->Menu_model->get_dformat($TableDataGrid->initiateddt)?></b><br>
                                                                        Time Diff : <?=date_diff_format($TableDataGrid->appointmentdatetime,$TableDataGrid->initiateddt);?><hr>
                                                                        Task Updated<br><b><?=$this->Menu_model->get_dformat($TableDataGrid->updateddate)?></b><br>
                                                                        Time Diff : <?=date_diff_format($TableDataGrid->initiateddt,$TableDataGrid->updateddate);?><hr>
                                                                        Remark/MOM <br><b><?=$TableDataGrid->remarks?><?=$TableDataGrid->mom?></b><hr>
                                                                        <div class="rounded-circle bg-danger" style="position: absolute;
                                                                            bottom: -10px; left: 40%; transform: translateX(-50%); width: 20px; height: 20px;">
                                                                        </div>
                                                                        <div class="rounded-circle bg-danger" style="position: absolute;
                                                                            bottom: -10px; left: 60%; transform: translateX(-50%); width: 20px; height: 20px;">
                                                                        </div> 
                                                                    </div>
                                                                </div>
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
                                                                <th>Action</th>
                                                                <th>Before Status</th>
                                                                <th>After Status</th>
                                                                <th>Company Name</th>
                                                                <th>Partner Type</th>
                                                                <th>Task By</th>
                                                                <th>Task Plan</th>
                                                                <th>Task Initiated</th>
                                                                <th>Time Diff</th>
                                                                <th>Task Updated</th>
                                                                <th>Time Diff</th>
                                                                <th>Remark</th>
                                                                <th>MOM</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                            $i = 1;
                                                            foreach ($TableData as $TableDataGrid) {

                                                                // var_dump($TableDataGrid);

                                                            ?>
                                                                <tr>
                                                                    <td><?= $i++ ?></td>
                                                                    <td><b style="color:<?= $TableDataGrid->aclr ?>"><?= $TableDataGrid->acname ?></b></td>
                                                                    <td><b style="color:<?= $TableDataGrid->bsclr ?>"><?= $TableDataGrid->bstatus ?></b></td>
                                                                    <td><b style="color:<?= $TableDataGrid->asclr ?>"><?= $TableDataGrid->astatus ?></b></td>
                                                                    <td><a href="<?= base_url(); ?>Menu/CompanyDetails/<?= $TableDataGrid->cid ?>"><b style="color:"><?= $TableDataGrid->compname ?></b></a></td>
                                                                    <td><b style="color:<?= $TableDataGrid->pclr ?>"><?= $TableDataGrid->pname ?></b></td>
                                                                    <td><?= $TableDataGrid->uname ?></td>
                                                                    <td><?= $this->Menu_model->get_dformat($TableDataGrid->appointmentdatetime) ?></td>
                                                                    <td><?= $this->Menu_model->get_dformat($TableDataGrid->initiateddt) ?></td>
                                                                    <td><?= date_diff_format($TableDataGrid->appointmentdatetime, $TableDataGrid->initiateddt) ?></td>
                                                                    <td><?= $this->Menu_model->get_dformat($TableDataGrid->updateddate) ?></td>
                                                                    <td><?= date_diff_format($TableDataGrid->initiateddt, $TableDataGrid->updateddate) ?></td>
                                                                    <td><?= $TableDataGrid->remarks ?></td>
                                                                    <td><?= $TableDataGrid->mom ?></td>
                                                                </tr>
                                                            <?php } ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <!-- <div class="tab-pane fade" id="TabView" role="tabpanel" aria-labelledby="nav_TabView">
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
                                                        
                                                        <form id="<?= $formId; ?>" action="<?= base_url(); ?>GraphNew/StatusWiseFunnelData/<?= $FunnelDataSingle->stid ?>" method="POST" style="display: none;" target="_blank">
                                                            <input type="hidden" name="selected_partnerType" value="<?= htmlspecialchars($arrayselected_partnerType); ?>">

                                                            <input type="hidden" name="arrayselected_cluster" value="<?= htmlspecialchars($arrayselected_cluster) ?>">

                                                            <input type="hidden" name="arrayselected_user" value="<?= htmlspecialchars($arrayselected_user) ?>">

                                                            <input type="hidden" name="arrayselected_userType" value="<?= htmlspecialchars($arrayselected_userType) ?>">

                                                            <input type="hidden" name="arrayselected_category" value="<?= htmlspecialchars($arrayselected_category) ?>">

                                                            <input type="hidden" name="stid" value="<?= htmlspecialchars($FunnelDataSingle->stid); ?>">

                                                            <input type="hidden" name="sdate" value="<?= htmlspecialchars($sdate); ?>">
                                                            <input type="hidden" name="edate" value="<?= htmlspecialchars($edate); ?>">
                                                        </form>
                                                        <div class="col-md-3 mb-2" >
                                                            <div class="card card p-3 col-sm m-auto bg-light">
                                                                <strong>
                                                                    <a href="javascript:void(0);" onclick="document.getElementById('<?= $formId; ?>').submit();" style="color:<?= $FunnelDataSingle->stclr ?>">
                                                                        <?= $FunnelDataSingle->stname ?> - <?= $FunnelDataSingle->cont ?>
                                                                    </a>
                                                                    
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div> 
                                        </div> -->
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>
<?php $colors = array('red','blue','yellow','purple','orange','pink','brown','cyan','magenta','teal','lime','violet','indigo','gray');?>

<script>
    var combinedData1 = {

        labels: [
            <?php 
                $status = getStatus(); 
                // var_dump($actions);die;
                $i=1; 
                foreach($status as $st){ $stid = $st->id;?> '<?=$st->name?>', <?php }  ?>],

        datasets: [

                {
                    label: 'Before Status',
                    backgroundColor: ['green'],
                    data: [
                        <?php 
                        $status3  = getStatus(); $i=1; foreach($status3 as $st3){ $stid3 = $st3->id;
                        // $task = get_tasktypeconvstion($uid,$sd,$ed,$acid);
                        $task = getStatusTaskTypeConversion($uid,$sdate,$edate,$stid3,$Selected_userType,$selected_users);

                        foreach($task as $ts){
                        ?>
                        <?=$ts->count?>,
                        <?php }} ?>],
                        stack: 'Stack 0'
                        
                },

                <?php  $status1 = getStatus(); $i=1; foreach($status1 as $st1){ $stid1 = $st1->id;?>
                
                {
                    label: '<?=$st1->name?>',
                    backgroundColor: ['<?=$colors[$i]?>'],
                    data: [
                        <?php 
                            $status2  = getStatus(); $i=1; foreach($status2 as $st2){ $stid2 = $st2->id;
                            $task2 = get_StatustaskTypeConversionByStatus($uid,$sdate,$edate,$stid2,$stid1,$Selected_userType,$selected_users);
                            foreach($task2 as $ts2){ ?>
                            <?=$ts2->count?>,
                            <?php }} ?>],
                            stack: 'Stack 1'
                            
                        <?php $i++; ?>
                },
                <?php } ?>
        ]
    };
        console.log(combinedData1);
        // alert(combinedData1);
        // return false;
        var combinedCtx = document.getElementById("ActionWiseTaskConversion").getContext('2d');
        var combinedChart = new Chart(combinedCtx, {
            type: 'bar',
            data: combinedData1,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Action Wise Task Conversion'
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
</script>

<script>
    $("#example1").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>



<!-- <script>
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
</script> -->

    

<!-- <script>
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
</script> -->

<script>
    $(document).ready(function() {

        $("#userType").change(function() {

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
                url: '<?= base_url(); ?>Dashboard/getRoleUser_New',
                type: 'POST',
                data: {
                    RoleId: selectedUserType
                },
                success: function(response) {
                    // alert(response);
                    $("#user").html(response);
                    $('#user').prop('required', true);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $("#user").change(function() {

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


        // $("#cluster").change(function() {

        //     var selectedCluster = $(this).val();

        //     if (selectedCluster.includes('select_all')) {
        //         // Select all options
        //         $('#cluster option').prop('selected', true);
        //         // Remove 'select_all' from the selected values
        //         selectedCluster = $('#cluster option').map(function() {
        //             return this.value !== 'select_all' ? this.value : null;
        //         }).get();

        //         selectedCluster = selectedCluster.filter(function(value) {
        //             return value !== null;
        //         });
        //     }

        //     $.ajax({
        //         url: '<?= base_url(); ?>GraphNew/getUserByCluster',
        //         type: 'POST',
        //         data: {
        //             clusterId: selectedCluster
        //         },
        //         success: function(response) {
        //             $("#user").html(response);
        //             $('#user').prop('required', true);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Error:', error);
        //         }
        //     });

        // });

        // $("#category").change(function() {

        //     var selectedCategory = $(this).val();

        //     if (selectedCategory.includes('select_all')) {
        //         // Select all options
        //         $('#category option').prop('selected', true);
        //         // Remove 'select_all' from the selected values
        //         selectedCategory = $('#category option').map(function() {
        //             return this.value !== 'select_all' ? this.value : null;
        //         }).get();

        //         selectedCategory = selectedCategory.filter(function(value) {
        //             return value !== null;
        //         });
        //     }

        // });

        // $("#partnerType").change(function() {

        //     var selectedPartnerType = $(this).val();

        //     if (selectedPartnerType.includes('select_all')) {
        //         // Select all options
        //         $('#partnerType option').prop('selected', true);
        //         // Remove 'select_all' from the selected values
        //         selectedPartnerType = $('#partnerType option').map(function() {
        //             return this.value !== 'select_all' ? this.value : null;
        //         }).get();

        //         selectedPartnerType = selectedPartnerType.filter(function(value) {
        //             return value !== null;
        //         });
        //     }
        // });

    });
</script>
    <!--  -->
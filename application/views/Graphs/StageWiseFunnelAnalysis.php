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
                                <h5>Stage Wise Funnel Analysis Graph</h5>
                            </center>
                        </div>
                        <div class="card-body FilterSection">
                            <form method="POST"
                                action="<?= base_url(); ?>GraphNew/StageWiseFunnleAnalysis/<?php ?>">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="startDate">Start Date</label>
                                        <input id="startDate" name="startDate" class="form-control" type="date"
                                            value="<?= $sdate ?>" />
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="endDate">End Date</label>
                                        <input id="endDate" class="form-control" name="endDate" type="date"
                                            value="<?= $edate ?>" />
                                    </div>

                                    <!-- Partner Type -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Status</label>
                                            <select class="custom-select rounded-0" name="status[]" id="status"
                                                multiple>
                                                <option value="select_all">Select All</option>
                                                <?php foreach ($status as $SingleStatus) { ?>
                                                    <option value="<?= $SingleStatus->id ?>" <?= in_array($SingleStatus->id, $SelectedStatus) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($SingleStatus->name) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Partner Type</label>
                                            <select class="custom-select rounded-0" name="partnerType[]"
                                                id="partnerType" multiple>
                                                <option value="select_all">Select All</option>
                                                <?php foreach ($partner_type as $partner) { ?>
                                                    <option value="<?= $partner->id ?>" <?= in_array($partner->id, $SelectedpartnerType) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($partner->name) ?></option>
                                                    
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Category</label>
                                            <select class="custom-select rounded-0" name="category[]" id="category"
                                                multiple>
                                                <option value="select_all">Select All</option>
                                                <option value="topspender" <?= in_array('topspender', $SelectedCategory) ? 'selected' : '' ?>>Top Spender</option>
                                                <option value="focus_funnel" <?= in_array('focus_funnel', $SelectedCategory) ? 'selected' : '' ?>>Focus Funnel</option>
                                                <option value="upsell_client" <?= in_array('upsell_client', $SelectedCategory) ? 'selected' : '' ?>>Upsell Client</option>
                                                <option value="keycompany" <?= in_array('keycompany', $SelectedCategory) ? 'selected' : '' ?>>Key Company</option>
                                                <option value="pkclient" <?= in_array('pkclient', $SelectedCategory) ? 'selected' : '' ?>>Key Client</option>
                                                <option value="priorityc" <?= in_array('priorityc', $SelectedCategory) ? 'selected' : '' ?>>Priority Client</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!-- Cluster -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select Cluster</label>
                                            <select class="custom-select rounded-0" name="cluster[]" id="cluster"
                                                multiple>
                                                <option value="select_all">Select All</option>
                                                <?php foreach ($clusters as $cluster) {
                                                    ?>
                                                    <option value="<?= $cluster->id ?>"><?= $cluster->cluster_name ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!--Cluster Users -->
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Select User</label>
                                            <select id="user" class="custom-select rounded-0" name="user[]"
                                                data-live-search="true" multiple>

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
                                
                                <div id="StageWiseFunnelAnalysis" style="width: 100%; height: 500px;"></div>
                                
                                <hr>
                                <div class="row">
                                    <div class="col-md-6" id="Stage_1" style="width: 100%; height: 300px;">

                                    </div>
                                    <div class="col-md-6" id="Stage_2" style="width: 100%; height: 300px;">

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6" id="Stage_3" style="width: 100%; height: 300px;">

                                    </div>
                                    <div class="col-md-6" id="Stage_4" style="width: 100%; height: 300px;">

                                    </div>
                                </div>
                                <br>
                                <div>
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav_GridView" data-toggle="tab"
                                                href="#GridView" role="tab" aria-controls="GridView" aria-selected="true">Grid View</a>
                                                
                                            <a class="nav-item nav-link" id="nav_TableView" data-toggle="tab" href="#TableView" role="tab" aria-controls="TableView" aria-selected="false">XLS View</a>

                                        </div>
                                    </nav>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    <!-- AM Charts -->
    <script>

        am5.ready(function() {

        var root = am5.Root.new("StageWiseFunnelAnalysis");

        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        
        var chart = root.container.children.push(am5percent.SlicedChart.new(root, {
            layout: root.verticalLayout
        }));
        
        var series = chart.series.push(am5percent.FunnelSeries.new(root, {
            alignLabels: false,
            orientation: "vertical",
            valueField: "value",
            categoryField: "category"
        }));
        
        series.data.setAll([
            
            <?php //$stage = $this->Menu_model->get_fannals($uid,'1');
                foreach($FunnelData as $SingleData){
            ?>
                { value: <?=$SingleData->stage1?>, category: "Qualification Stage (<?=$SingleData->stage1?>)" },
                // { value: 0, category: "<?=round(($SingleData->stage2/$SingleData->stage1)*100)?>%" },
                { value: <?=$SingleData->stage2?>, category: "Meeting (<?=$SingleData->stage2?>)" },
                // { value: 0, category: "<?=round(($SingleData->stage3/$SingleData->stage2)*100)?>%" },
                { value: <?=$SingleData->stage3?>, category: "Proposal (<?=$SingleData->stage3?>)" },
                // { value: 0, category: "<?=round(($SingleData->stage4/$SingleData->stage3)*100)?>%" },
                { value: <?=$SingleData->stage4?>, category: "Closure (<?=$SingleData->stage4?>)" },
        	<?php } ?>
        ]);
        
        series.appear();
        
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50,
            marginTop: 15,
            marginBottom: 15
        }));
        
        legend.data.setAll(series.dataItems);
        chart.appear(1000, 100);
    });

    </script>

    <!-- Bar Graphs START -->

    <script>
        google.charts.load("current", { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart1);

        function drawChart1() {
            var data = google.visualization.arrayToDataTable([
                ['Stage', 'Count', { role: 'style' }, { role: 'tooltip' }, { role: 'annotation' }],
                
                <?php 
                    $statusArray = [1, 8, 2, 10, 11];
                    $colors = ['#b87333', '#ff6f61', '#6b8e23', '#4682b4', '#d2691e'];
                    $mdata = getFunnelDetails($uid, $userTypeid, $sdate, $edate, $status, $SelectedCluster, $SelectedCategory, $SelectedUsers, $SelectedpartnerType, $statusArray);

                    $dataStrings = [];
                    $colorIndex = 0;
                    foreach ($mdata as $dt) {
                        // Escape and format data for JavaScript
                        $statusName = json_encode($dt->statusName);
                        $cont = intval($dt->cont);
                        $color = $colors[$colorIndex % count($colors)];
                        $dataStrings[] = "[$statusName, $cont, '$color', '$uid', '1']";
                        $colorIndex++;
                    }
                    echo implode(",\n", $dataStrings);
                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 2]);

            var options = {
                title: "Qualification Stage: Open, Open RPEM, Reachout, TTD Reachout, WNO Reachout",
                // width: 600,
                // height: 400,
                bar: { groupWidth: "95%" },
                legend: { position: "none" },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('Stage_1'));

            chart.draw(view, options);
        }
    </script>

    <script>
        google.charts.load("current", { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart1);

        function drawChart1() {
            var data = google.visualization.arrayToDataTable([
                ['Stage', 'Count', { role: 'style' }, { role: 'tooltip' }, { role: 'annotation' }],
                
                <?php 
                    $statusArray = [6, 9, 12, 13];
                    $colors = ['#b87333', '#ff6f61', '#6b8e23', '#4682b4', '#d2691e'];
                    $mdata = getFunnelDetails($uid, $userTypeid, $sdate, $edate, $status, $SelectedCluster, $SelectedCategory, $SelectedUsers, $SelectedpartnerType, $statusArray);

                    $dataStrings = [];
                    $colorIndex = 0;
                    foreach ($mdata as $dt) {
                        // Escape and format data for JavaScript
                        $statusName = json_encode($dt->statusName);
                        $cont = intval($dt->cont);
                        $color = $colors[$colorIndex % count($colors)];
                        $dataStrings[] = "[$statusName, $cont, '$color' , '$uid', '1']";
                        $colorIndex++;
                    }
                    echo implode(",\n", $dataStrings);
                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 2]);

            var options = {
                title: "Proposal : Positive, Positive NAP, Very Positive, Very Positive NAP",
                // width: 600,
                // height: 400,
                bar: { groupWidth: "95%" },
                legend: { position: "none" },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('Stage_2'));

            chart.draw(view, options);
        }
    </script>

    <script>
        google.charts.load("current", { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart3);

        function drawChart3() {
            var data = google.visualization.arrayToDataTable([
                ['Stage', 'Count', { role: 'style' }, { role: 'tooltip' }, { role: 'annotation' }],
                
                <?php 
                    $statusArray = [3];
                    $colors = ['#b87333', '#ff6f61', '#6b8e23', '#4682b4', '#d2691e'];
                    $mdata = getFunnelDetails($uid, $userTypeid, $sdate, $edate, $status, $SelectedCluster, $SelectedCategory, $SelectedUsers, $SelectedpartnerType, $statusArray);

                    $dataStrings = [];
                    $colorIndex = 0;
                    foreach ($mdata as $dt) {
                        // Escape and format data for JavaScript
                        $statusName = json_encode($dt->statusName);
                        $cont = intval($dt->cont);
                        $color = $colors[$colorIndex % count($colors)];
                        $dataStrings[] = "[$statusName, $cont, '$color' , '$uid', '1']";
                        $colorIndex++;
                    }
                    echo implode(",\n", $dataStrings);
                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 2]);

            var options = {
                title: "Meeting Stage : Tentative",
                // width: 600,
                // height: 400,
                bar: { groupWidth: "95%" },
                legend: { position: "none" },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('Stage_3'));

            chart.draw(view, options);
        }
    </script>

    <script>
        google.charts.load("current", { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart4);

        function drawChart4() {
            var data = google.visualization.arrayToDataTable([
                ['Stage', 'Count', { role: 'style' }, { role: 'tooltip' }, { role: 'annotation' }],
                
                <?php 
                    $statusArray = [7];
                    $colors = ['#b87333', '#ff6f61', '#6b8e23', '#4682b4', '#d2691e'];
                    $mdata = getFunnelDetails($uid, $userTypeid, $sdate, $edate, $status, $SelectedCluster, $SelectedCategory, $SelectedUsers, $SelectedpartnerType, $statusArray);

                    $dataStrings = [];
                    $colorIndex = 0;
                    foreach ($mdata as $dt) {
                        // Escape and format data for JavaScript
                        $statusName = json_encode($dt->statusName);
                        $cont = intval($dt->cont);
                        $color = $colors[$colorIndex % count($colors)];
                        $dataStrings[] = "[$statusName, $cont, '$color' , '$uid', '1']";
                        $colorIndex++;
                    }
                    echo implode(",\n", $dataStrings);
                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 2]);

            var options = {
                title: "Closure Stage : Closure",
                // width: 600,
                // height: 400,
                bar: { groupWidth: "95%" },
                legend: { position: "none" },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('Stage_4'));

            chart.draw(view, options);
        }
    </script>

    <!-- Bar Graphs END -->

    <script>
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const categoryCards = document.querySelectorAll('.card-header .card');

            const filterItems = document.querySelectorAll('.filter-item');

            // Function to filter grid items
            function filterItemsByCategory(partnerType) {
                filterItems.forEach(item => {

                    if (item.dataset.partnertype1 === partnerType || partnerType === 'All') {
                        item.style.display = 'block'; // Show item
                    } else {
                        item.style.display = 'none'; // Hide item
                    }
                });
            }

            categoryCards.forEach(card => {
                card.addEventListener('click', function () {
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
        $(document).ready(function () {

            $("#status").change(function () {

                var selectedPartnerType = $(this).val();

                if (selectedPartnerType.includes('select_all')) {
                    // Select all options
                    $('#status option').prop('selected', true);
                    // Remove 'select_all' from the selected values
                    selectedPartnerType = $('#status option').map(function () {
                        return this.value !== 'select_all' ? this.value : null;
                    }).get();

                    selectedPartnerType = selectedPartnerType.filter(function (value) {
                        return value !== null;
                    });
                }
            });

            $("#category").change(function () {

                var selectedCategory = $(this).val();

                if (selectedCategory.includes('select_all')) {
                    // Select all options
                    $('#category option').prop('selected', true);
                    // Remove 'select_all' from the selected values
                    selectedCategory = $('#category option').map(function () {
                        return this.value !== 'select_all' ? this.value : null;
                    }).get();

                    selectedCategory = selectedCategory.filter(function (value) {
                        return value !== null;
                    });
                }

            });

            $("#partnerType").change(function () {

                var selectedPartnerType = $(this).val();

                if (selectedPartnerType.includes('select_all')) {
                    // Select all options
                    $('#partnerType option').prop('selected', true);
                    // Remove 'select_all' from the selected values
                    selectedPartnerType = $('#partnerType option').map(function () {
                        return this.value !== 'select_all' ? this.value : null;
                    }).get();

                    selectedPartnerType = selectedPartnerType.filter(function (value) {
                        return value !== null;
                    });
                }
            });

            $("#cluster").change(function () {

                var selectedCluster = $(this).val();

                if (selectedCluster.includes('select_all')) {
                    // Select all options
                    $('#cluster option').prop('selected', true);
                    // Remove 'select_all' from the selected values
                    selectedCluster = $('#cluster option').map(function () {
                        return this.value !== 'select_all' ? this.value : null;
                    }).get();

                    selectedCluster = selectedCluster.filter(function (value) {
                        return value !== null;
                    });
                }

                $.ajax({
                    url: '<?= base_url(); ?>GraphNew/getUserByCluster',
                    type: 'POST',
                    data: {
                        clusterId: selectedCluster
                    },
                    success: function (response) {
                        $("#user").html(response);
                        $('#user').prop('required', true);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });

            });

            $("#user").change(function () {

                var selectedUser = $(this).val();
                if (selectedUser.includes('select_all')) {
                    // Select all options
                    $('#user option').prop('selected', true);
                    // Remove 'select_all' from the selected values
                    selectedUser = $('#user option').map(function () {
                        return this.value !== 'select_all' ? this.value : null;
                    }).get();

                    selectedUser = selectedUser.filter(function (value) {
                        return value !== null;
                    });
                }
            });

        });
    </script>
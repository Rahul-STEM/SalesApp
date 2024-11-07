<?php include_once('header.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>CRM Target Questions Form</title>
    <style>
        .form-container {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .image-container {
            text-align: center;
        }
        .tagline-list {
    background-color: #e9f5ff; /* Light blue background */
    padding: 15px; /* Padding around the list */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

.tagline-list li {
    margin-bottom: 10px; /* Space between list items */
    font-weight: 500; /* Slightly bolder font */
    color: #333; /* Darker text color */
}
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 form-container">
            <h3>Target Questions Form For <?php echo $username;?> - <?php echo $reviewType." Review "; ?></h3>
            <form method="post" name="targetQandA" action="targetQandA">
                <!-- Prospecting Section -->
                <!-- <h5>Prospectinggg</h5>
                <div class="form-group">
                    <label for="prospectingCompanies">How Many No. Of Prospecting Companies?</label>
                    <input type="number" class="form-control" id="prospectingCompanies" name="prospecting_companies" required>
                </div>
                <div class="form-group">
                    <label for="partnerType">Select Partner Type</label>
                    <select class="form-control" id="partnerType" name="partner_type"  required>
                        <option value="" disabled selected>Select Partner Type</option>
                        <?php foreach($partnerType as $partnerValue){ ?>
                                <option value="<?php echo $partnerValue->id; ?>">
                                    <?php echo $partnerValue->name; ?>
                                </option>
                        <?php } ?>
                    </select>
                </div> -->
                
                <input type="hidden" name="review_user_id" value="<?php echo $review_user_id;?>">
                <input type="hidden" name="reviewType" value="<?php echo $reviewType;?>">
                <div class="parnerType-section">
                    <div class="form-group">
                        <label for="partnerType">Select Partner Type</label>
                        <select class="form-control" id="partnerType" name="partner_type[]"  required>
                            <option value="" disabled selected>Select Partner Type</option>
                            <?php foreach($partnerType as $partnerValue){ ?>
                                    <option value="<?php echo $partnerValue->id; ?>">
                                        <?php echo $partnerValue->name; ?>
                                    </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <!-- Prospecting Section -->
                <h5>Prospecting</h5>
                <!-- <div class="form-group">
                    <label for="prospectingCompanies">How Many No. Of Prospecting Companies?</label>
                    <input type="number" class="form-control" id="prospectingCompanies" name="prospecting_companies" required>
                </div> -->
                
                <div id="prospecting-container">
                    <div class="prospecting-section">
                        <div class="form-group">
                            <label for="prospectingCompanies">How Many No. Of Prospecting Companies?</label>
                            <input type="number" class="form-control" id="prospectingCompanies" name="prospecting_companies[]" required>
                        </div>
                    </div>
                </div>

                <button type="button" id="addProspecting" class="btn btn-primary">Add Another Prospecting Section</button>

                <!-- Proposals Section -->
                <h5>Proposals</h5>
                <div class="form-group">
                    <label for="newProposals">New Proposals To Be Handed Over?</label>
                    <input type="number" class="form-control" id="proposal_no_of_schools" name="proposal_no_of_schools"  required>
                </div>
                <div class="form-group">
                    <label for="proposalRevenue">Proposal Revenue</label>
                    <input type="number" class="form-control" id="proposal_revenue" name="proposal_revenue" required>
                </div>

                <!-- Closure Section -->
                <h5>Closure</h5>
                <div class="form-group">
                    <label for="clients">No. of Clients</label>
                    <input type="number" class="form-control" id="closure_no_of_clients" name="closure_no_of_clients" required>
                </div>
                <div class="form-group">
                    <label for="schools">Enter No. of Schools</label>
                    <input type="number" class="form-control" id="closure_no_of_Schools" name="closure_no_of_Schools" required>
                </div>
                <div class="form-group">
                    <label for="revenue">Revenue</label>
                    <input type="number" class="form-control" id="closure_revenue" name="closure_revenue" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col-md-6 image-container">
            <!-- <h3>Target Q&A</h3> -->
            <h3>Previous Target vs Achievement Data</h3>
            <!-- <canvas id="targetChart" class="mt-4"></canvas> -->
            <canvas id="myChart" width="400" height="200"></canvas>

        </div>
    </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

<?php 
    $userData = reset($targetVsAchieved);

    $data = [
        'prospecting_target' => $userData['prospecting_target'],
        'prospecting_achieved' => $userData['prospective_achieved'],
        'proposal_target' => $userData['proposal_target'],
        'proposal_achieved' => $userData['proposal_achieved'],
        'proposal_revenue' => $userData['proposal_revenue'],
        'proposal_revenue_achieved' => $userData['proposal_revenue_achieved'],
        'closure_client_target' => $userData['closure_client_target'],
        'closure_clients_achieved' => $userData['closure_clients_achieved'],
    ];

    // print_r($targetVsAchieved['prospecting_target']);die;
    $chartData = [
        'labels' => ['Prospecting', 'Proposal', 'Revenue', 'Closure Clients'],
        'targets' => [
            (int)$data['prospecting_target'],
            (int)$data['proposal_target'],
            (int)$data['proposal_revenue'],
            (int)$data['closure_client_target'],
        ],
        'achieved' => [
            (int)$data['prospecting_achieved'],
            (int)$data['proposal_achieved'],
            (int)$data['proposal_revenue_achieved'],
            (int)$data['closure_clients_achieved'],
        ],
    ];

    ?>
        var ctx = document.getElementById('myChart').getContext('2d');
        var chartData = <?php echo json_encode($chartData); ?>;

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Targets',
                        data: chartData.targets,
                        backgroundColor: 'rgba(222, 16, 16)',
                        // borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Achieved',
                        data: chartData.achieved,
                        backgroundColor: 'rgba(23, 227, 18)',
                        // borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
</script>

<script>
    // Wait for the DOM to be fully loaded before running the script
    document.addEventListener('DOMContentLoaded', function() {
        // JavaScript to handle the cloning of the prospecting section
        document.getElementById('addProspecting').addEventListener('click', function() {
            // Get the prospecting container and the section to clone
            var container = document.getElementById('prospecting-container');
            var sectionToClone = document.querySelector('.prospecting-section');
            var parnerTypeToClone = document.querySelector('.parnerType-section');
            
            if (sectionToClone) { // Ensure the section exists before cloning
                // Clone the section and append it to the container
                var clonedSection = sectionToClone.cloneNode(true);

                var clonedpartnerType = parnerTypeToClone.cloneNode(true);
                // Optionally, you can clear the inputs inside the cloned section if you don't want the same values copied over
                var inputs = clonedSection.querySelectorAll('input');
                inputs.forEach(function(input) {
                    input.value = ''; // Reset the input value
                });

                var inputs = clonedpartnerType.querySelectorAll('input');
                inputs.forEach(function(input) {
                    input.value = ''; // Reset the input value
                });

                // Append the cloned section to the container
                container.appendChild(clonedpartnerType);
                container.appendChild(clonedSection);

            } else {
                console.error('Section to clone not found!');
            }
        });
    });
</script>

<?php include_once('footer.php');?>

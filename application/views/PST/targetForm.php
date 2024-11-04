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
                <h5>Prospectinggg</h5>
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
                </div>

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
            <h3>Target Q&A</h3>        
        </div>
    </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include_once('footer.php');?>

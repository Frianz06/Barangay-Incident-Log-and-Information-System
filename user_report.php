<?php include 'includes/headers/header_user_dashboard.php';


if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
    echo '
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="text-center">
            <h1 class="text-danger">Error: User is not logged in.</h1>
            <p class="text-secondary">You will be redirected to the login page shortly.</p>
        </div>
    </div>
    <meta http-equiv="refresh" content="4;url=../user_log.php">';
    exit;
}

?>

<!-- Begin the Report Form Section -->
<div class="d-flex justify-content-center align-items-center">

    <div class="form-container bg-dark p-5 rounded" style="width: 650px;">

        <h2 class="text-white text-center mb-4">Report Form</h2>

        <?php include 'includes/user_report_form.php'?>

        <form method="POST" class="text-white">

            <!-- Text Input Fields -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Reporter's Name</label>
                    <input type="text" value="<?php echo $_SESSION['user_name']?>" class="form-control" placeholder="Reporter's Name" readonly required>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Incident Status</label>
                    <select name="status" class="form-control form-select" required>
                        <option value=""></option>  <option value="Urgent">Urgent</option>  <option value="Non-urgent">Non-urgent</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <input type="hidden" name="gender" class="form-control" value="<?php echo $_SESSION['gender'] ?>" required>
                </div>
                
            </div>

            <div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Incident's Location</label>
        <input type="text" name="incident_location" class="form-control" placeholder="Incident's Location" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Type of Incident</label>
        <select id="incidentTypes" name="incident_types" class="form-control form-select" required>
            <option value=""></option>  
            <option value="Vehicle">Vehicle incident</option>  
            <option value="Water">Water incident</option>
            <option value="Electrical">Electrical incident</option>
            <option value="Fire">Fire incident</option>
            <option value="Other">Other:</option>
        </select>
    </div>
</div>

<!-- Hidden "Other" Input -->
<div id="otherInput" class="row mb-3" style="display: none;">
    <div class="col-md-12">
        <label for="other" class="form-label">Other: (please specify)</label>
        <input type="text" id="other" name="other" class="form-control" placeholder="Please specify the incident type">
    </div>
</div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="py-2">Date of Incident</label>
                    <input type="date" name="incident_date" class="form-control" required>
                </div>


                <div class="col-md-6">
                    <label class="py-2">Time of Incident</label>
                    <input type="time" name="incident_time" class="form-control" required>
                </div>
            </div>


            <div class="mb-3">
                <label class="py-2">Description of Incident</label>
                <textarea class="form-control" id="area" name="incident_description" placeholder="Describe the Incident" required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            

        </form>

    </div>

</div>
<!-- End the Report Form Section -->

<style>
    #area {
    min-width: 100%;
    max-width: 100%;
    min-height: 100px;
    }
</style>

<script>
    $(document).ready(function () {
        $('#incidentTypes').on('change', function () {
            if ($(this).val() === 'Other') {
                $('#otherInput').fadeIn(); // Show the hidden input with animation
            } else {
                $('#otherInput').fadeOut(); // Hide the input with animation
                $('#other').val(''); // Clear the input value
            }
        });
    });
</script>

</body>
</html>

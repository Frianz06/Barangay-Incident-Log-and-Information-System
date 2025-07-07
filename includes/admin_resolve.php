<?php include '../includes/headers/header_admin_main1.php';

if (!isset($_SESSION['admin_name']) || empty($_SESSION['admin_name'])) {
    echo '
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="text-center">
            <h1 class="text-danger">Error: Admin is not logged in.</h1>
            <p class="text-secondary">You will be redirected to the login page shortly.</p>
        </div>
    </div>
    <meta http-equiv="refresh" content="4;url=../admin_log.php">';
    exit;
}


?>
<?php 

    if (isset($_GET['incident_ID'])) {
        $incident_ID = $_GET['incident_ID'];

        //echo $incident_ID;
        $stmt = $db->prepare("SELECT * FROM incident_table WHERE incident_ID = ?");
        $stmt->bind_param("i", $incident_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $incident = $result->fetch_assoc();

    }
    else {
        die("No incident ID provided!");
    }
?>

<div class="container-md mt-5"> 
  
    <div class="row justify-content-center">

        <!-- 1st Card -->
        <div class="col-md-4">

            <div class="card text-bg-dark p-2" style="width: 30rem;">

                <div class="card-header card-title text-center"><h3>Submit Resolution Details</h3></div>

                <div class="card-body">
                    <form method="POST">
                        <?php include 'admin_resolve_form.php'?>

                        <div class="mb-3">
                            <label for="incident_ID" class="form-label"><strong>Incident ID:</strong></label>
                            <select name="incident_ID" id="incident_ID" class="form-select" readonly required>
                            <option value="<?php echo $incident_ID; ?>"><?php echo $incident_ID; ?></option>
                            </select>
                        </div>
        

                        <div class="mb-3">
                            <label class="form-label"><strong>Location:</strong></label>
                            <input type="text" class="form-control" value="<?php echo $incident['incident_location']; ?>" required readonly>
                        </div>
        

                        <div class="mb-3">
                            <label class="form-label"><strong>Date:</strong></label>
                            <input type="date" class="form-control" name value="<?php echo $incident['incident_date']; ?>" required readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Incident Description:</strong></label>
                            <textarea  id="area" class="form-control" name="incident_description"
                             rows="3" required readonly><?php echo $incident['incident_description']; ?></textarea>
                        </div>
        

                        <div class="mb-3">
                            <label for="resolution_description" class="form-label"><strong>Resolution Description:</strong></label>
                            <textarea name="resolution_description" id="area" class="form-control" rows="3"  required></textarea>
                        </div>
        

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Mark Incident as Resolved</button>
                        </div>
        

                    </form>
                </div>

            </div>

        </div>

    </div>

</div>

<style>
    #area {
    min-width: 100%;
    max-width: 100%;
    min-height: 100px;
    }
</style>
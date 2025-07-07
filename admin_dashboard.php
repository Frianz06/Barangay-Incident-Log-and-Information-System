<?php include 'includes/headers/header_admin_main.php'; 

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


<div class="container-fluid">

    <div class="row justify-content-center mt-4">

        <!-- Overview Heading (inside the dashboard row) -->
        <div class="col-12 text-center">
            <h1 class="mb-4">Overview</h1>
        </div>

        <!-- Dashboard -->
        <div class="col-md-10 col-lg-11">

            <div class="row justify-content-center">

                <!-- Incidents Reported (This Month) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Unsolved / Archived Incident Cases
                                    </div>
                                    <!-- auto change of how many incidents reported -->
                                    <?php 
                                    $stmt = $db->prepare("SELECT COUNT(incident_ID) AS last_incident_ID FROM archive_table");
                                    $stmt->execute();
                                    $stmt->bind_result($last_incident_ID);
                                    $stmt->fetch();

                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$last_incident_ID.'</div>';

                                    $stmt->close();
                                    ?>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Annual) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Resolved Incident Cases
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php 
                                    $stmt = $db->prepare("SELECT COUNT(resolve_ID) AS last_resolve_ID FROM resolve_table");
                                    $stmt->execute();
                                    $stmt->bind_result($last_resolve_ID);
                                    $stmt->fetch();

                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$last_resolve_ID.'</div>';

                                    $stmt->close();
                                    ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Incident Cases
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php 
                                    $stmt = $db->prepare("SELECT COUNT(incident_ID) AS total_incidents FROM incident_table");
                                    $stmt->execute();
                                    $stmt->bind_result($total_incidents);
                                    $stmt->fetch();

                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.$total_incidents.'</div>';

                                    $stmt->close();
                                    ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End of Dashboard -->

    </div>


    <div class="footer-mission-vision">
    <div class="row justify-content-center mt-4">
            <div class="col-6 text-center">
                <h3 class="mb-4">Mission</h3>
                <p>"Our mission at Barangay San Francisco is to ensure the safety and well-being of our<br> community
                by promptly addressing and resolving reported incidents. Through efficient management and swift
                action, we strive to create a secure and peaceful environment for all residents."</p>
            </div>

            <div class="col-6 text-center">
                <h3 class="mb-4">Vision</h3>
                <p>"Our vision is to foster a thriving and harmonious community in Barangay San Francisco,<br>
                where every resident enjoys a high quality of life, characterized by safety, unity, and active civic engagement.
                We aim to be a model of efficient governance and social responsibility, with a proactive approach to community development."</p>
            </div>
        </div>
    </div>

</div>

<style> 
        /* Internal CSS for Mission & Vision Footer */
        .footer-mission-vision {
            background-color: #f0f0f0;
            padding: 15px 0;
            text-align: center;
            color: #555;
            font-size: 14px;
            border-top: 2px solid #ddd;
            margin-top: 90px;
        }
        
        .footer-mission-vision p {
            margin: 0;
        }
    </style>


</body>
</html>

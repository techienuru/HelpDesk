<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (isset($_SESSION["help_desk_id"])) {
    $user_id = $_SESSION["help_desk_id"];

    $selecting_user_details = mysqli_query($connect, "SELECT * FROM `help_desk` WHERE help_desk_id = $user_id");
    $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);

    $name = $fetching_user_details["name"];
} else {
    redirectToLogin();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Campus Help Desk - Resolved Tickets</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.png" />

    <style>
        .card {
            border-radius: 15px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
        }

        .card-metric {
            font-size: 20px;
        }

        .bg-primary {
            background-color: #4CAF50 !important;
        }

        .bg-secondary {
            background-color: #FF9800 !important;
        }

        .bg-tertiary {
            background-color: #F44336 !important;
        }

        .card-icon {
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="dashboard.php">
                    <h1>CHD</h1>
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
                </ul>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="pending-tickets.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Pending Tickets</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="resolved-tickets.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Resolved Tickets</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">Resolved Tickets</h3>
                                    <h6 class="font-weight-normal mb-0">Here are all the resolved tickets</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resolved Tickets Table -->
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Resolved Tickets</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Ticket ID</th>
                                                    <th>Date Resolved</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- PHP code to fetch resolved tickets from the database -->
                                                <?php
                                                include_once "../includes/connect.php";
                                                $query = "SELECT * FROM `my_ticket` INNER JOIN `student` ON `my_ticket`.student_id = `student`.student_id  WHERE `status`='Resolved'";
                                                $result = mysqli_query($connect, $query);

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['fullname'] . "</td>";
                                                    echo "<td>" . $row['my_ticket_id'] . "</td>";
                                                    echo "<td>" . $row['response_date'] . "</td>";
                                                    echo "<td><label class='badge badge-success'>Resolved</label></td>";
                                                    echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#ticketModal'  data-id='" . $row['my_ticket_id'] . "' data-subject='" . $row['subject'] . "' data-message='" . $row['message'] . "' data-date_resolved='" . $row['response_date'] . "'>View</button></td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Modal -->
                    <div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ticket Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="ticketForm">
                                        <div class="form-group">
                                            <label for="subject">Subject</label>
                                            <input type="text" class="form-control" id="subject" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea class="form-control" id="message" rows="6" cols="6" readonly></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="date_resolved">Date Resolved</label>
                                            <input type="text" class="form-control" id="date_resolved" readonly>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Campus Help Desk. All rights reserved.</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../vendors/chart.js/Chart.min.js"></script>
    <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="../js/dataTables.select.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../js/dashboard.js"></script>
    <script src="../js/Chart.roundedBarCharts.js"></script>
    <!-- End custom js for this page-->

    <script>
        $('#ticketModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var message = button.data('message');
            var subject = button.data('subject');
            var date_resolved = button.data('date_resolved');

            var modal = $(this);
            modal.find('#subject').val(subject);
            modal.find('#message').val(message);
            modal.find('#date_resolved').val(date_resolved);
        });
    </script>
</body>

</html>
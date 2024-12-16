<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Campus Help Desk - Activity Check</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
  <!-- Custom CSS -->
  <style>
    .card-summary {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-summary h4 {
      font-weight: bold;
    }

    .activity-table {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 1rem;
    }

    .modal-content {
      border-radius: 15px;
    }

    .modal-header {
      border-bottom: 1px solid #ddd;
    }

    .modal-body {
      max-height: 60vh;
      overflow-y: auto;
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
            <a class="nav-link" href="user.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Add/remove user</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="activity-check.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Activity Check</span>
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
                  <h3 class="font-weight-bold">Activity Check</h3>
                  <h6 class="font-weight-normal mb-0">Monitor all tickets</h6>
                </div>
              </div>
            </div>
          </div>
          <!-- Live Chat History Table -->
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="card activity-table">
                <div class="card-body">
                  <h4 class="font-weight-bold">Ticket History</h4>
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Ticket ID</th>
                        <th>Student Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $selecting_tickets = mysqli_query($connect, "SELECT * FROM ((`my_ticket` INNER JOIN `student` ON `my_ticket`.student_id = `student`.student_id) LEFT JOIN `help_desk` ON `my_ticket`.help_desk_id = `help_desk`.help_desk_id)");

                      while ($fetching_tickets = mysqli_fetch_assoc($selecting_tickets)) {
                        $my_ticket_id = $fetching_tickets["my_ticket_id"];
                        $fullname = $fetching_tickets["fullname"];
                        $email = $fetching_tickets["email"];
                        $subject = $fetching_tickets["subject"];
                        $message = $fetching_tickets["message"];
                        $status = $fetching_tickets["status"];
                        $date_sent = $fetching_tickets["date_sent"];
                        $response_message = $fetching_tickets["response_message"];
                        $help_desk_id = $fetching_tickets["help_desk_id"];
                        $name = $fetching_tickets["name"];
                        $response_date = $fetching_tickets["response_date"];
                        echo "
                                  <tr>
                                    <td>$my_ticket_id</td>
                                    <td>$fullname</td>
                                    <td>$status</td>
                                    <td><button class='btn btn-info btn-sm' data-toggle='modal' data-target='#chatDetailsModal-$my_ticket_id'>View</button></td>
                                  </tr>

                              ";

                        echo "
                              <div class='modal fade' id='chatDetailsModal-$my_ticket_id' tabindex='-1' role='dialog' aria-labelledby='chatDetailsModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog modal-lg' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title' id='chatDetailsModalLabel'>Chat Details</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <div class='modal-body'>
                                        <h6>Student: $fullname</h6>
                                        <h6>Help Desk: $name</h6>
                                        <div class='chat-details'>
                                          <div class='chat-message'>
                                            <strong>Student:</strong> 
                                            $message
                                          </div>
                                        <p>
                                          Sent Date:
                                          $date_sent
                                        </p>
                                          <div class='chat-message'>
                                            <strong>Help Desk:</strong>
                                            $response_message
                                          </div>
                                        </div>
                                        <p>
                                          Response Date:
                                          $response_date
                                        </p>
                                      </div>
                                      <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>                              
                              ";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- JS Plugins -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <!-- Custom JS -->
  <script src="../js/vertical-layout-light/off-canvas.js"></script>
  <script src="../js/vertical-layout-light/hoverable-collapse.js"></script>
  <script src="../js/vertical-layout-light/misc.js"></script>
  <script src="../js/vertical-layout-light/settings.js"></script>
  <script src="../js/vertical-layout-light/todolist.js"></script>
</body>

</html>
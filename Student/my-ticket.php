<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (isset($_SESSION["student_id"])) {
  $user_id = $_SESSION["student_id"];

  $selecting_user_details = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id = $user_id");
  $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);

  $fullname = $fetching_user_details["fullname"];
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
  <title>Campus Help Desk</title>
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
            <a class="nav-link" href="submit-ticket.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Submit ticket</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="my-ticket.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">My tickets</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="faqs.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">FAQs</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="profile.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Profile</span>
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
            <div class="col-md-12">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">My Tickets</h3>
                  <h6 class="font-weight-normal mb-0">All your submitted tickets appear here</h6>
                </div>
              </div>
            </div>
          </div>

          <div class="container-scroller">
            <div class="container-fluid page-body-wrapper">
              <div class="main-panel">
                <div class="content-wrapper">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="font-weight-bold">My Tickets</h3>
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Ticket ID</th>
                              <th>Subject</th>
                              <th>Status</th>
                              <th>Date Submitted</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $selecting_tickets = mysqli_query($connect, "SELECT * FROM ((`my_ticket` INNER JOIN `student` ON `my_ticket`.student_id = `student`.student_id) LEFT JOIN `help_desk` ON `my_ticket`.help_desk_id = `help_desk`.help_desk_id) WHERE my_ticket.student_id = $user_id");
                            while ($row = mysqli_fetch_assoc($selecting_tickets)) {
                              $my_ticket_id = $row["my_ticket_id"];
                              $subject = $row["subject"];
                              $status = $row["status"];
                              $message = $row["message"];
                              $date = $row["date_sent"];
                              $name = $row["name"];
                              $response_message = $row["response_message"];
                              $response_date = $row["response_date"];

                              echo "
                                  <tr>
                                    <th>$my_ticket_id</th>
                                    <th>$subject</th>
                                    <th>$status</th>
                                    <th>$date</th>
                                    <th>
                                      <button class='btn btn-primary' data-toggle='modal' data-target='#modal-$my_ticket_id'>View message</button>
                                    </th>
                                  </tr> 

                                  <!-- Bootstrap Modal -->
                                  <div class='modal fade' id='modal-$my_ticket_id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                      <div class='modal-content'>
                                        <div class='modal-header'>
                                          <h5 class='modal-title' id='exampleModalLabel'>Ticket Details</h5>
                                          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                          </button>
                                        </div>
                                        <div class='modal-body'>
                                          <div class='card'>
                                            <div class='card-body'>
                                              <h5 class='card-title'>Subject: $subject</h5>
                                              <p class='card-text'>
                                                <span class='font-weight-bold'>Message: </span> 
                                                $message
                                              </p>
                                              <p class='card-text'>
                                                <span class='font-weight-bold'>Date Sent:</span> 
                                                 $date
                                              </p>
                                              <p class='card-text'>
                                                <span class='font-weight-bold'>Help Desk: </span>  
                                                $name
                                              </p>
                                              <p class='card-text'>
                                                <span class='font-weight-bold'>Response: </span>   
                                                $response_message
                                              </p>
                                              <p class='card-text'>
                                                <span class='font-weight-bold'>Response date: </span>    
                                                $response_date
                                              </p>
                                            </div>
                                          </div>
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
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024. Campus Help Desk </a> All rights reserved.</span>
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
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
      Tawk_LoadStart = new Date();
    (function() {
      var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/66acb6201601a2195b9fefab/1i49aet42';
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
  </script>
  <!--End of Tawk.to Script-->
</body>

</html>
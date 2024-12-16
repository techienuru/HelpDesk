<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (isset($_SESSION["help_desk_id"])) {
  $user_id = $_SESSION["help_desk_id"];

  $selecting_user_details = mysqli_query($connect, "SELECT * FROM `help_desk` WHERE help_desk_id = $user_id");
  $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);

  $name = $fetching_user_details["name"];

  // Fetching Total numbers of tickets that are pending
  $selecting_pending_tickets = mysqli_query($connect, "SELECT COUNT(my_ticket_id) AS noOfPendingTickets FROM `my_ticket` WHERE status = 'Pending'");
  $fetching_pending_tickets = mysqli_fetch_assoc($selecting_pending_tickets);
  $noOfPendingTickets = $fetching_pending_tickets["noOfPendingTickets"] ?? 0;

  // Fetching Total numbers of tickets that has been resolved
  $selecting_resolved_tickets = mysqli_query($connect, "SELECT COUNT(my_ticket_id) AS noOfResolvedTickets FROM `my_ticket` WHERE status = 'Resolved'");
  $fetching_resolved_tickets = mysqli_fetch_assoc($selecting_resolved_tickets);
  $noOfResolvedTickets = $fetching_resolved_tickets["noOfResolvedTickets"] ?? 0;

  // Fetching Total numbers of tickets
  $selecting_total_tickets = mysqli_query($connect, "SELECT COUNT(my_ticket_id) AS noOfTotalTickets FROM `my_ticket`");
  $fetching_total_tickets = mysqli_fetch_assoc($selecting_total_tickets);
  $noOfTotalTickets = $fetching_total_tickets["noOfTotalTickets"] ?? 0;
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
  <style>
    /* styles.css */

    /* Custom card styling */
    .ticket-card {
      position: relative;
      overflow: hidden;
      border-radius: 15px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .ticket-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Add color gradients */
    #total-tickets-card {
      background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    #active-chats-card {
      background: linear-gradient(135deg, #f6d365, #fda085);
    }

    #new-tickets-card {
      background: linear-gradient(135deg, #84fab0, #8fd3f4);
    }

    #pending-tickets-card {
      background: linear-gradient(135deg, #ff9a9e, #fad0c4);
    }

    #assigned-tickets-card {
      background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
    }

    #resolved-tickets-card {
      background: linear-gradient(135deg, #c2e9fb, #a1c4fd);
    }

    /* Card body text */
    .card-body {
      text-align: center;
      color: #fff;
    }

    .card-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .card-text {
      font-size: 24px;
      font-weight: bold;
      margin: 0;
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
                  <h3 class="font-weight-bold">Welcome <?php echo $name; ?></h3>
                </div>
                <div id="dashboard-content" class="container mt-4">
                  <header class="mb-4">
                    <p>Overview of current activities and important metrics.</p>
                  </header>
                  <section class="row">
                    <div class="col-md-4 mb-4">
                      <div class="card ticket-card" id="total-tickets-card">
                        <div class="card-body">
                          <h5 class="card-title">Pending Tickets</h5>
                          <p class="card-text" id="total-tickets-count">
                            <?php echo $noOfPendingTickets; ?>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-4">
                      <div class="card ticket-card" id="active-chats-card">
                        <div class="card-body">
                          <h5 class="card-title">Resolved Tickets</h5>
                          <p class="card-text" id="active-chats-count">
                            <?php echo $noOfResolvedTickets; ?>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-4">
                      <div class="card ticket-card" id="new-tickets-card">
                        <div class="card-body">
                          <h5 class="card-title">Total Tickets</h5>
                          <p class="card-text" id="new-tickets-count">
                            <?php echo $noOfTotalTickets; ?>
                          </p>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
    <script>
      // scripts.js

      $(document).ready(function() {
        $('.ticket-card').on('click', function() {
          const card = $(this);
          card.find('.card-text').animate({
            fontSize: "3rem"
          }, 300, function() {
            card.find('.card-text').animate({
              fontSize: "2.5rem"
            }, 300);
          });
        });
      });
    </script>
</body>

</html>
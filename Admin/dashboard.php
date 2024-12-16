<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (isset($_SESSION["admin_id"])) {
  $user_id = $_SESSION["admin_id"];

  $selecting_user_details = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_id = $user_id");
  $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);


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
  <title>Campus Help Desk - Admin Dashboard</title>
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
    .ticket-card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .ticket-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .ticket-card .card-body {
      text-align: center;
      color: #fff;
    }

    .ticket-card .card-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .ticket-card .card-text {
      font-size: 24px;
      font-weight: bold;
      margin: 0;
    }

    /* Custom card colors */
    #total-tickets-card {
      background: linear-gradient(135deg, #f093fb, #f5576c);
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
                  <h3 class="font-weight-bold">Dashboard</h3>
                  <h6 class="font-weight-normal mb-0">Overview of current activities and important metrics</h6>
                </div>
              </div>
            </div>
          </div>
          <!-- Dashboard Cards -->
          <div class="row mt-4">
            <div class="col-md-4 mb-4">
              <div class="card ticket-card" id="total-tickets-card">
                <div class="card-body">
                  <h5 class="card-title">Total Tickets</h5>
                  <p class="card-text" id="total-tickets-count">
                    <?php echo $noOfTotalTickets; ?>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card ticket-card" id="pending-tickets-card">
                <div class="card-body">
                  <h5 class="card-title">Pending Tickets</h5>
                  <p class="card-text" id="pending-tickets-count">
                    <?php echo $noOfPendingTickets; ?>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card ticket-card" id="resolved-tickets-card">
                <div class="card-body">
                  <h5 class="card-title">Resolved Tickets</h5>
                  <p class="card-text" id="resolved-tickets-count">
                    <?php echo $noOfResolvedTickets; ?>
                  </p>
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
  <script>
    // Custom animation for cards
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.ticket-card');
      cards.forEach(card => {
        card.addEventListener('mouseover', () => {
          card.style.transform = 'translateY(-10px)';
          card.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.2)';
        });
        card.addEventListener('mouseout', () => {
          card.style.transform = 'translateY(0)';
          card.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
        });
      });
    });
  </script>
</body>

</html>
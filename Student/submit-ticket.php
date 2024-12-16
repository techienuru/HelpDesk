<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (isset($_SESSION["student_id"])) {
  $user_id = $_SESSION["student_id"];

  $selecting_user_details = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id = $user_id");
  $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);

  $fullname = $fetching_user_details["fullname"];
  $email = $fetching_user_details["email"];

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $my_ticket_id = "HD" . $user_id . rand(100, 99999);

    $inserting_into_DB = mysqli_query($connect, "INSERT INTO `my_ticket` (my_ticket_id,student_id,fullname,email,subject,message,status) VALUES('$my_ticket_id',$user_id,'$name','$email','$subject','$message','Pending')");

    if ($inserting_into_DB) {
      echo "
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('ticketModal').style.display = 'block';
            document.getElementById('ticketID').innerText = '$my_ticket_id';
          });
        </script>
      ";
    }
  }
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
    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      text-align: center;
    }

    .modal-button {
      padding: 10px 20px;
      margin-top: 10px;
      border: none;
      background-color: #007bff;
      color: white;
      cursor: pointer;
    }

    .modal-button:hover {
      background-color: #0056b3;
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
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Ticket Submission</h3>
                  <h6 class="font-weight-normal mb-0">fill the form below and submit your complaints! track complaints with your ticket id <span class="text-primary">
                </div>
                <div class="main-panel">
                  <div class="content-wrapper">
                    <div class="row">
                      <div class="col-md-12 grid-margin">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">Submit Ticket</h4>
                            <form action="submit-ticket.php" method="POST">
                              <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" value="<?php echo $fullname ?>" name="name" readonly required>
                              </div>
                              <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" value="<?php echo $email ?>" class="form-control" id="email" name="email" readonly required>
                              </div>
                              <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                              </div>
                              <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                              </div>
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- content-wrapper ends -->
                  <!-- partial -->
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

  <!-- Modal -->
  <div id="ticketModal" class="modal">
    <div class="modal-content">
      <h2>Ticket Submitted Successfully!</h2>
      <p>Your Ticket ID: <span id="ticketID"></span></p>
      <button class="modal-button" onclick="copyTicketID()">Copy Ticket ID</button>
      <button class="modal-button" onclick="closeModal()">OK</button>
    </div>
  </div>

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
    function copyTicketID() {
      const ticketID = document.getElementById('ticketID').innerText;
      navigator.clipboard.writeText(ticketID).then(() => {
        alert('Ticket ID copied to clipboard');
      });
    }

    function closeModal() {
      document.getElementById('ticketModal').style.display = 'none';
      window.location.href = 'submit-ticket.php';
    }
  </script>

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
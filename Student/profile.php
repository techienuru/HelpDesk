<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (isset($_SESSION["student_id"])) {
  $user_id = $_SESSION["student_id"];

  $selecting_user_details = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id = $user_id");
  $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);

  $fullname = $fetching_user_details["fullname"];
  $matricno = $fetching_user_details["matricno"];
  $email = $fetching_user_details["email"];


  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $modified_fullname = $_POST["fullname"];
    $modified_matricno = $_POST["matricno"];
    $modified_email = $_POST["email"];
    $modified_password = $_POST["password"];

    $sql = mysqli_query($connect, "UPDATE `student` SET fullname = '$modified_fullname',matricno = '$modified_matricno',email = '$modified_email',password = '$modified_password' WHERE student_id = $user_id");

    if ($sql) {
      echo "
        <script>
          alert('Success');
          window.location.href='profile.php';
        </script>
      ";
      die();
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
  <title>Profile Page</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <style>
    .profile-container {
      margin-top: 20px;
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
      margin-bottom: 20px;
    }

    .btn-update-profile {
      margin-top: 20px;
    }

    .modal-body {
      padding: 20px;
    }

    .form-group label {
      font-weight: bold;
    }

    .form-control {
      border-radius: 5px;
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
                  <div class="profile-container">
                    <div class="profile-header">
                      <h3 class="font-weight-bold">Profile Information</h3>
                    </div>
                    <form>
                      <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" class="form-control" id="fullname" value="<?php echo $fullname ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="matricNo">Matric No</label>
                        <input type="text" class="form-control" id="matricNo" value="<?php echo $matricno ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $email ?>" readonly>
                      </div>
                      <button type="button" class="btn btn-primary btn-update-profile" data-toggle="modal" data-target="#updateProfileModal">
                        Update Profile
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- Profile Update Modal -->
        <div class="modal fade" id="updateProfileModal" tabindex="-1" role="dialog" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                  <div class="form-group">
                    <label for="updateFullname">Full Name</label>
                    <input type="text" name="fullname" class="form-control" id="updateFullname" value="<?php echo $fullname ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="updateMatricNo">Matric No</label>
                    <input type="text" name="matricno" class="form-control" id="updateMatricNo" value="<?php echo $matricno ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="updateEmail">Email Address</label>
                    <input type="email" name="email" class="form-control" id="updateEmail" value="<?php echo $email ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="updatePassword">New Password</label>
                    <input type="password" name="password" class="form-control" id="updatePassword" placeholder="Enter new password" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Profile Update Modal End -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 Campus Help Desk. All rights reserved.</span>
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

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
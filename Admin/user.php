<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (isset($_SESSION["admin_id"])) {
  $user_id = $_SESSION["admin_id"];

  $selecting_user_details = mysqli_query($connect, "SELECT * FROM `admin` WHERE admin_id = $user_id");
  $fetching_user_details = mysqli_fetch_assoc($selecting_user_details);

  if (isset($_POST["add_help_desk"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $insert_into_DB = mysqli_query($connect, "INSERT INTO `help_desk` (name,email,password) VALUES('$name','$email','$password')");

    if ($insert_into_DB) {
      echo "
        <script>
          alert('Success');
          window.location.href='user.php';
        </script>
      ";
      die();
    }
  }

  if (isset($_POST["save_changes"])) {
    $help_desk_id = $_POST["help_desk_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $update_DB = mysqli_query($connect, "UPDATE `help_desk` SET name = '$name',email = '$email',password = '$password' WHERE help_desk_id = $help_desk_id");

    if ($update_DB) {
      echo "
        <script>
          alert('Success');
          window.location.href='user.php';
        </script>
      ";
      die();
    }
  }


  if (isset($_GET["remove"])) {
    
    switch ($_GET["remove"]) {
      case 'help_desk':
        $help_desk_id = $_GET["help_desk_id"];

        $delete_from_DB = mysqli_query($connect, "DELETE FROM `help_desk` WHERE help_desk_id = $help_desk_id");

        if ($delete_from_DB) {
          echo "
            <script>
              alert('Success');
              window.location.href='user.php';
            </script>
          ";
          die();
        }
        break;

      case 'student':
        $student_id = $_GET["student_id"];

        $delete_from_DB = mysqli_query($connect, "DELETE FROM `student` WHERE student_id = $student_id");

        if ($delete_from_DB) {
          echo "
            <script>
              alert('Success');
              window.location.href='user.php';
            </script>
          ";
          die();
        }
        break;
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
  <title>Campus Help Desk - Admin Dashboard</title>
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
  <!-- Custom CSS -->
  <style>
    .card-summary {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-summary h4 {
      font-weight: bold;
    }

    .activity-feed {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 1rem;
    }

    .activity-feed .activity-item {
      border-bottom: 1px solid #eee;
      padding: 0.5rem 0;
    }

    .activity-feed .activity-item:last-child {
      border-bottom: none;
    }

    .quick-actions {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 1rem;
      text-align: center;
    }

    .quick-actions .btn {
      margin: 0.5rem;
    }

    .modal-header,
    .modal-body {
      padding: 1.5rem;
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
        <ul class="navbar-nav navbar-nav-right"></ul>
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
        <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist"></ul>
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
              <span class="menu-title">Add/Remove User</span>
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
                  <h3 class="font-weight-bold">Admin Dashboard</h3>
                  <h6 class="font-weight-normal mb-0">Manage users and representatives</h6>
                </div>
              </div>
              <!-- Customer Care Representatives Section -->
              <div class="row mt-4">
                <div class="col-md-12 mb-4">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Manage Customer Care Representatives</h4>
                    </div>
                    <div class="card-body">
                      <form id="add-representative-form" action="user.php" method="post">
                        <div class="form-group">
                          <label for="rep-name">Name</label>
                          <input type="text" class="form-control" id="rep-name" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                          <label for="rep-email">Email</label>
                          <input type="email" class="form-control" id="rep-email" name="email" placeholder="Enter email" required>
                        </div>

                        <div class="form-group">
                          <label for="rep-email">Password</label>
                          <input type="password" class="form-control" id="rep-password" name="password" placeholder="Assign password" required>
                        </div>
                        <button type="submit" name="add_help_desk" class="btn btn-primary">Add HelpDesk</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Registered Representatives Table -->
              <div class="row mt-4">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Existing Customer Care Representatives</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $selecting_help_desk = mysqli_query($connect, "SELECT * FROM `help_desk`");

                            while ($fetching_help_desk = mysqli_fetch_assoc($selecting_help_desk)) {
                              $help_desk_id = $fetching_help_desk["help_desk_id"];
                              $name = $fetching_help_desk["name"];
                              $email = $fetching_help_desk["email"];
                              echo "
                                  <tr>
                                    <td>$name</td>
                                    <td>$email</td>
                                    <td>
                                      <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editRepModal-$help_desk_id'>Edit</button>
                                      <a href='user.php?remove=help_desk&help_desk_id=$help_desk_id' class='btn btn-danger btn-sm'>Remove</a>
                                    </td>
                                  </tr>
                              ";

                              // Start of Bootstrap Modal
                              echo "
                                   <div class='modal fade' id='editRepModal-$help_desk_id' tabindex='-1' role='dialog' aria-labelledby='editRepModalLabel' aria-hidden='true'>
                                      <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h5 class='modal-title' id='editRepModalLabel'>Edit Representative</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                              <span aria-hidden='true'>&times;</span>
                                            </button>
                                          </div>
                                          <div class='modal-body'>
                                            <form id='edit-representative-form' action='user.php' method='post'>
                                              <input type='text' name='help_desk_id' value='$help_desk_id' hidden>

                                              <div class='form-group'>
                                                <label for='edit-rep-name'>Name</label>
                                                <input type='text' class='form-control' id='edit-rep-name' name='name' value='$name' required>
                                              </div>
                                              
                                              <div class='form-group'>
                                                <label for='edit-rep-email'>Email</label>
                                                <input type='email' class='form-control' id='edit-rep-email' name='email' value='$email' required>
                                              </div>

                                              <div class='form-group'>
                                                <label for='edit-rep-password'>Password</label>
                                                <input type='password' class='form-control' id='edit-rep-password' name='password' required>
                                              </div>

                                              <button type='submit' name='save_changes' class='btn btn-primary'>Save changes</button>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                        ";
                              // End of Bootstrap Modal
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Registered Students Section -->
              <div class="row mt-4">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Registered Students</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $select_reg_student = mysqli_query($connect, "SELECT * FROM `student`");
                            while ($row = mysqli_fetch_assoc($select_reg_student)) {
                              $student_id = $row["student_id"];
                              $fullname = $row["fullname"];
                              $email = $row["email"];

                              echo "
                                    <tr>
                                      <td>$fullname</td>
                                      <td>$email</td>
                                      <td>
                                        <a href='user.php?remove=student&student_id=$student_id' class='btn btn-danger btn-sm'>Remove</a>
                                      </td>
                                    </tr>  
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
      </div>
    </div>


  </div>

  <!-- JS scripts -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
</body>

</html>
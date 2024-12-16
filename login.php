<?php
session_start();
include_once "./includes/connect.php";
include_once "./includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Selecting From `admin` table
  $selecting_reg_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE email = '$email' AND password = '$password'");
  $fetching_reg_admin = mysqli_fetch_assoc($selecting_reg_admin);

  // Selecting From `help_desk` table
  $selecting_reg_help_desk = mysqli_query($connect, "SELECT * FROM `help_desk` WHERE email = '$email' AND password = '$password'");
  $fetching_reg_help_desk = mysqli_fetch_assoc($selecting_reg_help_desk);

  // Selecting From `student` table
  $selecting_reg_student = mysqli_query($connect, "SELECT * FROM `student` WHERE email = '$email' AND password = '$password'");
  $fetching_reg_student = mysqli_fetch_assoc($selecting_reg_student);

  if (mysqli_num_rows($selecting_reg_admin) > 0 || mysqli_num_rows($selecting_reg_help_desk) > 0 || mysqli_num_rows($selecting_reg_student) > 0) {

    if (mysqli_num_rows($selecting_reg_admin) > 0) {
      $_SESSION["admin_id"] = $fetching_reg_admin["admin_id"];
      redirectWithoutMsg("./Admin/dashboard.php");
    }

    if (mysqli_num_rows($selecting_reg_help_desk) > 0) {
      $_SESSION["help_desk_id"] = $fetching_reg_help_desk["help_desk_id"];
      redirectWithoutMsg("./Help Desk/dashboard.php");
    }

    if (mysqli_num_rows($selecting_reg_student) > 0) {
      $_SESSION["student_id"] = $fetching_reg_student["student_id"];
      redirectWithoutMsg("./Student/dashboard.php");
    }
  } else {
    showErrorMsg("Invalid Credentials");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo text-center">
                <h3 class="text-primary font-weight-bold">Campus HD</h3>
              </div>
              <h4>Hello! Welcome Campus Help desk lets' get started</h4>
              <h6 class="font-weight-light text-primary font-weight-bold">Sign in to continue.</h6>
              <form class="pt-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                </div>

                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.php" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
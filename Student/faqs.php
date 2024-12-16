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
  <style>
    .faq-section {
      max-width: 800px;
      margin: 0px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .faq-item {
      border-bottom: 1px solid #ddd;
      overflow: hidden;
    }

    .faq-item:last-child {
      border-bottom: none;
    }

    .faq-question {
      background-color: #007bff;
      color: white;
      cursor: pointer;
      padding: 15px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 8px 8px 0 0;
      transition: background-color 0.3s ease;
    }

    .faq-question:hover {
      background-color: #0056b3;
    }

    .faq-answer {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s ease, padding 0.5s ease;
      padding: 0 15px;
      background-color: #f1f1f1;
      border-radius: 0 0 8px 8px;
      border-top: 1px solid #ddd;
    }

    .faq-answer.show {
      max-height: 500px;
      /* Adjust based on content height */
      padding: 15px;
    }

    .faq-answer p {
      margin: 0;
    }

    .faq-answer p+p {
      margin-top: 10px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 24px;
      color: #333;
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
                  <h3 class="font-weight-bold">Frequent Asked Questions</h3>
                  <h6 class="font-weight-normal mb-0">Get quick answers from frequently asked qurstions!</h6>
                </div>
              </div>
            </div>
          </div>

          <div class="container-scroller">
            <div class="container-fluid page-body-wrapper">
              <div class="main-panel">
                <div class="content-wrapper">
                  <div class="faq-section">
                    <h2 class="font-weight-bold">Frequently Asked Questions</h2>
                    <div class="faq-item">
                      <div class="faq-question">What are the university's operating hours?</div>
                      <div class="faq-answer">
                        <p>The university operates from Monday to Friday, 8 AM to 5 PM. On weekends, the university is closed.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">How do I apply for financial aid?</div>
                      <div class="faq-answer">
                        <p>Financial aid applications can be submitted through the university's financial aid office or online portal.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">How do I register for classes?</div>
                      <div class="faq-answer">
                        <p>Registration for classes is done through the university's online registration system. Log in to your student portal to view available courses and register.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">What should I do if I miss the registration deadline?</div>
                      <div class="faq-answer">
                        <p>If you miss the registration deadline, contact the registrar's office as soon as possible. They may assist you with late registration or provide alternative solutions.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">How do I change my major or minor?</div>
                      <div class="faq-answer">
                        <p>To change your major or minor, fill out the change of major/minor form available on the student portal and submit it to the academic advising office.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">Where can I find my course grades?</div>
                      <div class="faq-answer">
                        <p>Your course grades can be accessed through the student portal. Log in and navigate to the 'Grades' section to view your academic performance.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">How do I join a student organization?</div>
                      <div class="faq-answer">
                        <p>To join a student organization, visit the student activities office or check the student portal for a list of organizations and their contact information.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">What are the options for on-campus housing?</div>
                      <div class="faq-answer">
                        <p>On-campus housing options include residence halls and apartments. Visit the housing office's website or contact them for more information and application procedures.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">How do I reset my university email password?</div>
                      <div class="faq-answer">
                        <p>To reset your university email password, use the password recovery tool available on the university's IT support website or contact the IT help desk.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">Who do I contact for technical issues with online courses?</div>
                      <div class="faq-answer">
                        <p>For technical issues with online courses, contact the e-learning support team via the support portal or email provided on the online learning platform.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">Where can I find the library?</div>
                      <div class="faq-answer">
                        <p>The library is located at the center of the campus. For directions, refer to the campus map available on the university's website or inquire at the information desk.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">What resources are available for academic support?</div>
                      <div class="faq-answer">
                        <p>Academic support resources include tutoring centers, writing labs, and study groups. Check the student services section on the university's website for more details.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">How do I make an appointment with the campus health center?</div>
                      <div class="faq-answer">
                        <p>To make an appointment with the campus health center, visit their website or call their office directly. They also offer online appointment scheduling.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">What are the counseling services available?</div>
                      <div class="faq-answer">
                        <p>The campus offers individual counseling, group therapy, and mental health workshops. Visit the counseling center's website or contact them for more information.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">What is the university's policy on academic integrity?</div>
                      <div class="faq-answer">
                        <p>The university upholds a strict academic integrity policy that prohibits plagiarism, cheating, and other forms of academic dishonesty. Refer to the student handbook for detailed policies and procedures.</p>
                      </div>
                    </div>
                    <div class="faq-item">
                      <div class="faq-question">How do I appeal a grade?</div>
                      <div class="faq-answer">
                        <p>To appeal a grade, submit a grade appeal form to the academic office within the specified time frame. Detailed instructions are provided in the student handbook.</p>
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
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Campus Help Desk </a> All rights reserved.</span>
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
    document.addEventListener('DOMContentLoaded', function() {
      var questions = document.querySelectorAll('.faq-question');

      questions.forEach(function(question) {
        question.addEventListener('click', function() {
          var answer = this.nextElementSibling;

          if (answer.classList.contains('show')) {
            answer.classList.remove('show');
          } else {
            document.querySelectorAll('.faq-answer').forEach(function(item) {
              item.classList.remove('show');
            });
            answer.classList.add('show');
          }
        });
      });
    });
  </script>
</body>

</html>
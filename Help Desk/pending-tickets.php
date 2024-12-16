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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Campus Help Desk - Pending Tickets</title>
    <link rel="stylesheet" href="../vendors/feather/feather.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
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
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
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
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Pending Tickets</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Ticket ID</th>
                                                    <th>Email</th>
                                                    <th>Subject</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $selecting_tickets = mysqli_query($connect, "SELECT * FROM `my_ticket` WHERE status = 'Pending'");
                                                while ($ticket = mysqli_fetch_assoc($selecting_tickets)) { ?>
                                                    <tr>
                                                        <td><?php echo $ticket['fullname']; ?></td>
                                                        <td><?php echo $ticket['my_ticket_id']; ?></td>
                                                        <td><?php echo $ticket['email']; ?></td>
                                                        <td><?php echo $ticket['subject']; ?></td>
                                                        <td>
                                                            <button class="btn btn-primary" data-toggle="modal" data-target="#responseModal" data-id="<?php echo $ticket['my_ticket_id']; ?>" data-email="<?php echo $ticket['email']; ?>" data-message="<?php echo htmlspecialchars($ticket['message']); ?>">View Message</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Campus Help Desk. All rights reserved.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Response Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Respond to Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="ticketMessage"></p>
                    <form method="POST" action="send_response.php">

                        <div class="form-group">
                            <label for="responseMessage">Message</label>
                            <textarea class="form-control" id="responseMessage" name="response_message" rows="4" required></textarea>
                        </div>
                        <input type="hidden" name="help_desk_id" value="<?php echo $user_id; ?>">
                        <input type="hidden" id="ticketId" name="ticket_id">
                        <input type="hidden" id="studentEmail" name="student_email">
                        <button type="submit" class="btn btn-primary">Send Response</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../vendors/chart.js/Chart.min.js"></script>
    <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="../js/dataTables.select.min.js"></script>
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
    <script src="../js/dashboard.js"></script>
    <script src="../js/Chart.roundedBarCharts.js"></script>

    <script>
        $('#responseModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var ticketId = button.data('id');
            var studentEmail = button.data('email');
            var message = button.data('message');

            var modal = $(this);
            modal.find('#ticketMessage').text(message);
            modal.find('#ticketId').val(ticketId);
            modal.find('#studentEmail').val(studentEmail);
        });
    </script>
</body>

</html>
<?php
    session_start();
    include '_dbconnect.php';
    include 'function.php';

    $username = $_SESSION['username'];
    $sql1 = "SELECT * FROM users WHERE username = '$username';";
        $result = $conn->query($sql1);
        $row = $result->fetch_assoc();

        $fname = $row['full_name'];
        $email = $row['email'];
        $uid = $row['user_id'];
        
        $sql = "SELECT COUNT(*) AS books_issued FROM issue WHERE user_id = $uid AND (return_date IS NULL or return_date > CURRENT_DATE);";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    
        $issuecount= $row['books_issued'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />

    <style>
    .tcolor {
        color: #d53b66;
    }

    .row {
        margin-left: 10px;

    }

    .dashboard-card {
        font-family: Arial, sans-serif;
        background-color: #c2bebe;
        width: 300px;
        margin: 20px 0;
    }

    .card-header {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;
    }

    .card-text {
        font-size: 1.2rem;
        margin-bottom: 15px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 1rem;
        text-decoration: none;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="admin_dashboard.php">Library Management System (LMS)</a>
            </div>
            <font style="color: white"><span><strong>Welcome: <?php echo $fname;?></strong></span></font>
            <font style="color: white"><span><strong>Email: <?php echo $email;?></strong></font>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        My Profile
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="viewprofile.php">View Profile</a></li>
                        <li><a class="dropdown-item" href="edituser.php">Edit Proflie</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav><br>

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fdf6e3;">
        <div class="container-fluid">

            <ul class="nav navbar-nav navbar-center">
                <li class="nav-item">
                    <a class="nav-link tcolor" href="userdashboard.php">Dashboard</a>
                </li>
            
               <li class="nav-item">
                   <a class="nav-link tcolor" href="issuebook.php">Issue Book</a>
                </li>
            </ul>
        </div>
    </nav><br>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-light dashboard-card">
                <div class="card-header">Not Returned Books</div>
                <div class="card-body">
                    <p class="card-text">No. of not returned books: <?php  echo $issuecount; ?></p>
                    <a class="btn btn-success" href="issuedbook.php" target="_blank">View Books</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light dashboard-card">
                <div class="card-header">Available Books</div>
                <div class="card-body">
                    <p class="card-text">Books Available: <?php  echo getbook_count(); ?> </p>
                    <a class="btn btn-danger" href="viewbook.php" target="_blank">View All Books</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light dashboard-card">
                <div class="card-header">Book Genre</div>
                <div class="card-body">
                    <p class="card-text">Book Genre: <?php  echo getgenre_count(); ?></p>
                    <a class="btn btn-primary" href="viewgenre.php" target="_blank">View Genre</a>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>

</body>

</html>
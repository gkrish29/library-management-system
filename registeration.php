<?php
$error= true;

if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        include '_dbconnect.php';

        $fname = $_POST['fname'];
        $email = $_POST['email'];
        $number = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql ="INSERT INTO `users` ( `full_name`, `email`, `phone`, `username`, `password`) VALUES ( '$fname', '$email', '$number', '$username', '$password');";
        $result = mysqli_query($conn, $sql);

        if($result){
            $error = false;
            
        }
        else{
            $error=true;
            echo $conn->error;
        }
        

    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    img {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 40px;
        width: 480px;
        margin-top: 20px;
    }



    .container h2 {
        margin-bottom: 20px;
        text-align: center;
        color: #007bff;
    }

    .form-group {
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #007bff;
        outline: none;
    }

    button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
        width: 100%;
    }

    button:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Library Management System</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">
                        <a class="nav-link" href="adminlogin.php">Admin Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registeration.php"></span>Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php 
          if(!$error){
          echo '
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success</strong> Your data has been successfully submitted.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          ';
          }
          ?>

    <div class="container">
        <div class="text-center">
            <img class="mb-4" src="liblogo.jpg" alt="" width="100" height="70" />
        </div>
        <h2>Create Your Library Account</h2>
        <form action="registeration.php" method="post">
            <div class="form-group">
                <label for="fname">Full Name:</label>
                <input type="text" id="fname" name="fname" placeholder="full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone no.:</label>
                <input type="number" id="phone" name="phone" placeholder="phone number" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>

</body>

</html>
<?php
$error = 0; // Initialize $error as false
  session_start();
  
      include '_dbconnect.php';  

    $username = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username = '$username';";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $fname = $row['full_name'];
        $email = $row['email'];
        $uid = $row['user_id'];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '_dbconnect.php';

    $title = $_POST['btitle'];
    $idate = $_POST['idate'];
    $rdate = $_POST['rdate'];
    $genre = $_POST['bgenre'];

    
    $originalDate = new DateTime($rdate);
    $retdate = $originalDate->format('Y-m-d');
    
    $originalDate = new DateTime($idate);
    $indate = $originalDate->format('Y-m-d');
    $currentDate = date('Y-m-d'); // Get the current date in 'YYYY-MM-DD' format

    $sql1 = "SELECT b.book_id,  i.return_date
            FROM books b
            LEFT JOIN issue i ON b.book_id = i.book_id
            WHERE b.book_title = '$title' AND (i.return_date IS NULL OR i.return_date < '$currentDate')";

            $result1= $conn->query($sql1);
    
    if (!$result1) {
        echo "Error: " . mysqli_error($conn); // Output any query errors
        $error = 1;
    } 
    
     else { 
            
            $num = mysqli_num_rows($result1);

            if($num)
            {
                $row = $result1->fetch_assoc();
                $bid = $row['book_id'];
                
                // Insert into book when boook title is matched
                
                $sql2 = "INSERT INTO  issue(user_id, book_id, issue_date, return_date)
                     VALUES ($uid, $bid, '$indate', '$retdate')";
                $result2= $conn->query($sql2);

                if(!$result2){
                    $error = 1;
                    echo $conn->error;
                }
                $error=2;
            }
        
         else {
            // book name is  not found
           $error = 1;
        }

    }
    
    $conn->close(); // Close the database connection
}   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
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
    input[type="date"],
    input[type="number"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="date"]:focus,
   {
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

    <?php 
          if($error==2){
          echo '
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success</strong> Book has been successfully issued.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          ';
          }
          if($error==1){
          echo '
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Unavailable</strong>  Book is currently unavailable .
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          ';
          }
          ?>

    <div class="container">
        <div class="text-center">
            <img class="mb-4" src="liblogo.jpg" alt="" width="100" height="70" />
        </div>
        <h2>Issue Book from Library</h2>
        <form action="issuebook.php" method="post">
            <div class="form-group">
                <label for="btitle">Book Title:</label>
                <input type="text" id="btitle" name="btitle" placeholder="book title" required>
            </div>
            <div class="form-group">
                <label for="bgenre">Genre:</label>
                <input type="text" id="bgenre" name="bgenre" placeholder="genre" required>
            </div>

            <div class="form-group">
                <label for="aname">Issue Date:</label>
                <input type="date" id="aname" name="idate" <?php echo "placeholder=".date('Y-m-d'); ?> required>
            </div>
            
            <div class="form-group">
                <label for="rdate">Return Date:</label>
                <input type="date" id="rdate" name="rdate" placeholder="return date" >
            </div>
            <button type="submit">Issue Book</button>
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
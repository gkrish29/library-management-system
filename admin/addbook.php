<?php
$error = true; // Initialize $error as false

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '_dbconnect.php';

    $title = $_POST['btitle'];
    $author = $_POST['aname'];
    $pyear = $_POST['pyear'];
    $genre = $_POST['bgenre'];

    $sql = "SELECT author_id FROM authors WHERE author_name = '$author'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn); // Output any query errors
        $error = true;
    } 
    
     else { 
            
            $num = mysqli_num_rows($result);

            if($num)
            {
                $row = $result->fetch_assoc();
                $aid = $row['author_id'];
                
                // Insert into book when author name is matched

                $sql1 = "INSERT INTO books (book_title, genre, PublishedYear, author_id)
                     VALUES ('$title', '$genre', $pyear, $aid)";
                $result1= $conn->query($sql1);

                if(!$result1){
                    $error = true;
                    echo $conn->error;
                }
                $error=false;
            }
        
         else {
            // Insert author if not found
            $sql2 = "INSERT INTO authors (author_name) VALUES ('$author')";
            $result2 = $conn->query($sql2);

            if(!$result2){
                echo $conn->error;
                $error = true;
            }
            
            else{
                $row = $result->fetch_assoc();
                $aid1 = mysqli_insert_id($conn);
                
                
                // Insert book data using new author id
                $sql3 = "INSERT INTO books (book_title, genre, PublishedYear, author_id)
                     VALUES ('$title', '$genre', $pyear, $aid1)";

                    $result3= $conn->query($sql3);
                    if(!$result3){
                        echo $conn->error;
                    }
                    $error = false;

            }

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
                    <a class="nav-link dropdown-toggle" href="admindboard.php" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        My Profile
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="adminprofile.php">View Profile</a></li>
                        <li><a class="dropdown-item" href="editadmin.php">Edit Proflie</a></li>
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
          if(!$error){
          echo '
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success</strong> Book has been successfully added.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          ';
          }
          ?>

    <div class="container">
        <div class="text-center">
            <img class="mb-4" src="liblogo.jpg" alt="" width="100" height="70" />
        </div>
        <h2>Add Book to Library</h2>
        <form action="addbook.php" method="post">
            <div class="form-group">
                <label for="btitle">Book Title:</label>
                <input type="text" id="btitle" name="btitle" placeholder="book title" required>
            </div>
            <div class="form-group">
                <label for="bgenre">Genre:</label>
                <input type="text" id="bgenre" name="bgenre" placeholder="genre" required>
            </div>

            <div class="form-group">
                <label for="aname">Author Name:</label>
                <input type="text" id="aname" name="aname" placeholder="author name" required>
            </div>
            
            <div class="form-group">
                <label for="pyear">Published year</label>
                <input type="number" id="pyear" name="pyear" placeholder="published year" required>
            </div>
            <button type="submit">Add Book</button>
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
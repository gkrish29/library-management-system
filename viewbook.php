<?php 
    session_start();
    include '_dbconnect.php';
    
    $username = $_SESSION['username'];
    $sql1 = "SELECT * FROM admins WHERE username = '$username';";
    $result = $conn->query($sql1);
    $row = $result->fetch_assoc();
    
    $fname = $row['full_name'];
    $email = $row['email'];
    
    $sql = " SELECT  books.book_title,books.genre, authors.author_name
    FROM books
    LEFT JOIN authors ON books.author_id = authors.author_id
    WHERE book_id NOT IN (
    SELECT books.book_id
    FROM books
    JOIN issue ON issue.book_id = books.book_id
    WHERE issue.return_date IS NULL OR issue.return_date > CURDATE()
    GROUP BY books.book_id
);
";
    
    $result= $conn->query($sql);
    
   
 


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />

        <style><style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ffffff;
    }

    h1 {
      text-align: center;
      margin-top: 20px;
    }

    /* Style the container for the table */
    .table-container {
      display: flex;
      justify-content: center;
    }

    /* Improve the table styling */
    table {
      border-collapse: collapse;
      width: 80%;
      max-width: 1000px;
      margin: 20px auto;
      box-shadow: 0 0 15px color(display-p3 0.63 0.63 0.63 / 0.67);
    background-color: #f1ecec;
    }
    th{
      background-color: burlywood;
    }
    /* Highlight table header on hover */
    th:hover {
      background-color: rgb(223, 159, 81);
    }

    /* Style the odd and even rows differently */
    tr:nth-child(odd) {
      background-color: #d4cfcf;
    }

    /* Add padding to cells */
    td, th {
      padding: 12px;
      text-align: center;
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

    <h1>Available Books</h1>

    <!-- Container for the table -->
    <div class="table-container">
        <table>
            <tbody>
                <tr>
                    <th>Sr no.</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                </tr>
                
             <?php
                    $i= 1;
                while($row = $result->fetch_assoc()){
                   echo "<tr>
                        <td>".$i."</td>
                        <td>".$row['book_title']."</td>
                        <td>".$row['author_name']."</td>
                        <td>".$row['genre']."</td>
                    </tr>";
                    $i++;
                }
             ?>
              
                <!-- Book entries... -->
            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>

</body>

</html>
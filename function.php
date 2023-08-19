<?php

  function getuser_count(){
  include '_dbconnect.php';
  $sql = "SELECT count(*) as usercount FROM users;";
  
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $user_count = $row['usercount'];
  return $user_count;
}

  function getbook_count(){
  include '_dbconnect.php';
  $sql = "SELECT count(*) as bookcount FROM books WHERE book_id NOT IN ( SELECT books.book_id FROM books JOIN issue ON issue.book_id = books.book_id WHERE issue.return_date IS NULL OR issue.return_date > CURDATE() GROUP BY books.book_id );";
  
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $book_count = $row['bookcount'];
  return $book_count;
}

  function getgenre_count(){
  include '_dbconnect.php';
  $sql = "SELECT COUNT(DISTINCT genre) AS genrecount
  FROM books;
  ";
  
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $genre_count = $row['genrecount'];
  return $genre_count;
}


  

?>
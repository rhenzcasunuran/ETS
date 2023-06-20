<?php
session_start();

if ($conn) {
  if (isset($_POST['sign-in-button'])) {
    $username = mysqli_real_escape_string($conn, $_POST['user_username']);
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);
    $sql = "SELECT * FROM user WHERE user_username='$username' AND user_password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Fetches the row from the result set
        $_SESSION['message'] = "You are now Logged In";
        $_SESSION['user_username'] = $username;
        $_SESSION['admin_id'] = $row['admin_id']; // Fetches the 'id' column value from the row
        header("location: HOM-create-post.php");
      } else {
        echo '<script>alert("Username or Password combination are incorrect")</script>';
      }
    }
  }
}
?>

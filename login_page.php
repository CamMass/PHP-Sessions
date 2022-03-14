<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Log in to Website</title>

  <style>
    input {
      margin-bottom: 0.5em;
    }
  </style>
</head>

<body>

  <!-- Put your PHP to log someone in here... Includes forwarding, storing sessions, etc. -->
  <?php

  // Connects to Database
  require_once("login.php");

  $conn = new mysqli($hn, $un, $pw, $db);

  if ($conn->connect_error) {

    die($conn->connect_error);
  }

  $username = $password = "";

  // Form submited
  if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM lab4_users WHERE username= '$username'";
    $result = $conn->query($query);

    $row = $result->fetch_array();

    if ($row["username"] == $username && $row["password"] == $password) {

      // Set session variables
      $_SESSION['currentUser'] = $username;

      if ($row["type"] == "user") {

        // Set session variables
        $_SESSION['userType'] = $row["type"];
        // Forward the browser to the user_page.php
        header("Location: user_page.php");
      } else {

        // Set session variables
        $_SESSION['userType'] = $row["type"];
        // Forward the browser to the admin_page.php
        header("Location: admin_page.php");
      }
    } else {

      $errMess = "Invalid username or password";
    }
  }

  // If User is already logged in and hasn't logged out
  if (isset($_SESSION['currentUser'])) {

    if ($_SESSION['userType'] == "user") {

      header("Location: user_page.php");
    } else {

      header("Location: admin_page.php");
    }
  }

  $conn->close();
  ?>

  <!-- HTML Code -->
  <h1>Welcome to <span style="font-style:italic; font-weight:bold; color: maroon">
      Great Web Application</span>!</h1>

  <p style="color: red">
    <!--Placeholder for error messages-->
    <?php echo $errMess; ?>

  </p>

  <form method="post" action="login_page.php">
    <label>Username: </label>
    <input required type="text" name="username" value="<?php echo $username; ?>"> <br>
    <label>Password: </label>
    <input required type="password" name="password" value="<?php echo $password; ?>"> <br>
    <input type="submit" name="submit" value="Log in">
  </form>

  <p style="font-style:italic">
    Placeholder for "forgot password" link<br><br>
    Placeholder for "create account" link
  </p>

</body>

</html>
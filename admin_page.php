<?php
// Start session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Administrator Page</title>

  <!-- Forms the lined table -->
  <style>
    td {
      border: 1px solid;
      text-align: center;
      padding: 0.5em;
    }
  </style>
</head>

<body>
  <!-- <h1>Administrator Page</h1> -->

  <!-- PHP to display admin information -->
  <?php

  if (isset($_SESSION['currentUser']) && $_SESSION['userType'] == "admin") {

    echo "<h1>Administrator Page</h1>";
    // Current user
    // $user = $_SESSION['currentUser'];

    // User table
    // Connects to Database
    require_once("login.php");

    $conn = new mysqli($hn, $un, $pw, $db);

    if ($conn->connect_error) {

      die($conn->connect_error);
    }

    // Retrives all user orders from
    $query = "SELECT * FROM lab4_orders";
    $result = $conn->query($query);

    // prints the user orders
    if ($result->num_rows > 0) {

      echo "<table>

        <tr>
          <th> Order ID </th>
          <th> Username </th>
          <th> Order Total </th>
          <th> Order Quanity </th>
          <th> Shipping Method </th>
        </tr>";
      while ($row = $result->fetch_array()) {

        echo "<tr>
          <td> " . $row["orderID"] . " </td>
          <td> " . $row["username"] . "</td>
          <td> " . $row["orderTotal"] . "</td>
          <td> " . $row["quantity"] . " </td>
          <td> " . $row["shipping"] . " </td>
        

          </tr>";
      }
      echo "</table>";
    }
    echo "<br>";
    echo "<a href=./logout_page.php>Logout</a>";
  }

  if (!(isset($_SESSION['currentUser']))) {

    // If the user in not logged in display error
    echo "<h1>ERROR</h1>";
    echo "<p>Must login. <a href=./login_page.php>Click Here</a></p>";
  }

  // If User tries to enter Admin page
  if ($_SESSION['userType'] == "user") {

    echo "<h1>ACCESS ERROR</H1>";
    echo "<p>Please go to login. <a href=./login_page.php>Click Here</a></p>";
  }
  $conn->close();
  ?>
</body>

</html>
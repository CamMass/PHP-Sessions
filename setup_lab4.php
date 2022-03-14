<?php
  require_once 'login.php';
  $connection = new mysqli($hn, $un, $pw, $db);

  if ($connection->connect_error)
    die($connection->connect_error);

// USERS
  $query = "CREATE TABLE lab4_users (
    forename VARCHAR(32),
    surname  VARCHAR(32),
    type     VARCHAR(10),
    username VARCHAR(32),
    password VARCHAR(32)
  )";
  $result = $connection->query($query);
  if (!$result)
    die($connection->error);

  $salt1    = "qm&h*";
  $salt2    = "pg!@";

  $forename = 'Bill';
  $surname  = 'Smith';
  $type     = 'user';
  $username = 'bsmith';
  $password = 'mysecret';
  $token    = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $forename, $surname, $type, $username, $token);

  $forename = 'Pauline';
  $surname  = 'Jones';
  $type     = 'user';
  $username = 'pjones';
  $password = 'acrobat';
  $token    = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $forename, $surname, $type, $username, $token);

  $forename = 'Super';
  $surname  = 'User';
  $type     = 'admin';
  $username = 'admin';
  $password = 'admin';
  $token    = hash('ripemd128', "$salt1$password$salt2");

  add_user($connection, $forename, $surname, $type, $username, $token);

  echo 'Table lab4_users created and populated<br>';

  function add_user($connection, $fn, $sn, $ty, $un, $pw)
  {
    $query  = "INSERT INTO lab4_users (forename, surname, type, username, password)
      VALUES('$fn', '$sn', '$ty', '$un', '$pw')";

    $result = $connection->query($query);

    if (!$result)
      die($connection->error);
  }

  $connection->close();

  // USER END



  // ORDERS

  $connection = new mysqli($hn, $un, $pw, $db);

  if ($connection->connect_error)
    die($connection->connect_error);

  $query = "CREATE TABLE lab4_orders (
    orderID     VARCHAR(32),
    username    VARCHAR(32),
    orderTotal  VARCHAR(32),
    quantity    VARCHAR(10),
    shipping    VARCHAR(32)
  )";

  $result = $connection->query($query);

  if (!$result)
    die($connection->error);

  add_order($connection, "0001", "pjones", "$23.85", "4", "2-day shipping");
  add_order($connection, "0002", "pjones", "$13.99", "1", "standard shipping");
  add_order($connection, "0003", "bsmith", "$35.79", "3", "standard shipping");
  add_order($connection, "0004", "pjones", "$101.14", "11", "free shipping");
  add_order($connection, "0005", "bsmith", "$189.75", "8", "free shipping");
  add_order($connection, "0006", "pjones", "$24.89", "1", "1-day shipping");
  add_order($connection, "0007", "bsmith", "$60.92", "7", "free shipping");

  function add_order($connection, $oid, $un, $ot, $qty, $sp)
  {
    $query = "INSERT INTO lab4_orders (orderID, username, orderTotal, quantity, shipping)
      VALUES ('$oid', '$un', '$ot', '$qty', '$sp')";

    $result = $connection->query($query);

    if(!$result)
      die($connection->error);
  }

  echo 'Table lab4_orders created and populated<br>';

  // ORDERS END


  $connection->close();
?>

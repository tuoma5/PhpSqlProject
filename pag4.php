<?php
  require_once('dbinfo.php');

  // Start a session
  session_start();


  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log him/her in
  if (!isset($_SESSION['userid'])) 
  {
    if (isset($_POST['loging-in'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($username) && !empty($password)) {
        // Fetch the userid, username, password, and momname from the database
        $query = "SELECT userid, username, momname FROM user WHERE username = '$username' AND password = SHA('$password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The login is OK. Set the userid, username, and momname session variables. Set the cookies. Redirect to the home page
          $row = mysqli_fetch_array($data);
          
          $_SESSION['userid'] = $row['userid'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['momname'] = $row['momname'];
          
          setcookie('userid', $row['userid'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          setcookie('momname', $row['momname'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          
          // Check this nice way to get the URL of the app's home page
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        }
        else {
          // The username or password are incorrect so set an error message
          $error_msg = 'Sorry, the username/password you entered is not correct. Try again!';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in. Try again!';
      }
    }
  }
  
?>


<html lang="en">

<?php
  // If the session data is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['userid'])) {
    echo '<p class="error">' . $error_msg . '</p>';
?>


<head>
    <meta charset="utf-8">
    <title>PHP - SQL Project</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Sweet</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li><a href="login.php">Log in</a></li>
      <li><a href="signup.php">Sign up</a></li>
      <li class="active"><a href="pag4.php">Your page</a></li>
    </ul>
  </div>
</nav>

<div class="container">
<div class="jumbotron">
	<h1 align="center">PHP - SQL Project</h1>
</div>
</div>

<div class="container">
	<div class="row">
	<div class="col-xs-12">

<?php
   }
  else {
    // Confirm the successful log-in
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');
  }
  ?>
</body>
</html>
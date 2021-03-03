<?php
session_start();

// initializing variables
$username = "";
$email = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', 'password', 'phplogin');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $ika = mysqli_real_escape_string($db, $_POST['ika']);
  $gender = mysqli_real_escape_string($db, $_POST['gender']);

  if (empty($username)) { array_push($errors, "Username puttu"); }
  if (empty($email)) { array_push($errors, "Email puuttuu"); }
  if (empty($password_1)) { array_push($errors, "Password puuttuu"); }
  if (empty($ika)) { array_push($errors, "Ikä puuttuu"); }
  if (empty($gender)) { array_push($errors, "Sukupuoli puuttuu"); }
  if ($password_1 != $password_2) { array_push($errors, "Salasanat eivät ole samat"); }
  if( preg_match( '~[A-Z]~', $password_1) &&
    preg_match( '~[a-z]~', $password_1) &&
    preg_match( '~\d~', $password_1) &&
    (strlen( $password_1) > 6))
  {
    //Good 
  } 
  else { array_push($errors, "Salasana tarvitsee yhden ison ja pienen kirjaimen ja numeron"); }
  if($ika < 15)
  {
    array_push($errors, "Olet liian nuori!");
  }

  $user_check_query = "SELECT * FROM user WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Käyttäjänimi on jo olemassa");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Sähköposti on jo olemassa");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1); //encrypt the password before saving in the database

  	$query = "INSERT INTO user (username, email, password, age, gender) 
  			  VALUES('$username', '$email', '$password', '$ika', '$gender')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "Sinut on nyt kirjattu sisään";
  	header('location: index.php');
  }
}

// ... 

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Käyttäjänimi tarvitaan");
    }
    if (empty($password)) {
        array_push($errors, "Salasana tarvitaan");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['success'] = "Olet nyt kirjautunut sisään";
          header('location: index.php');
        }else {
            array_push($errors, "Väärä käyttäjänimi/salasana yhdistelmä");
        }
    }
  }
?>
<?php include 'libs/load.php';

//this will check wheather the user loged in and it not let him to access login.php while Authenticated
if((Session::authorization($_COOKIE['sessionToken']) == true) and (isset($_SESSION['user_id'])) ) {
    ?>
<script type="text/javascript">
	window.location.href = "index.php";
</script>
<?php
}

//make sure that username and password are entered....
if(isset($_POST['username']) and !empty($_POST['username']) and isset($_POST['password']) and !empty($_POST['password'])) {
    $username = htmlentities($_POST['username']);
    $password = $_POST['password'];

    //Comparing the username and password withe existing database entry...
    $result = Session::authenticate($username, $password);

    if ($result) {
        //if there is following js script will be executed...
        ?>
	<script> 
	// if the result is true it will redirect to index.php
		window.location.href="index.php" ;
		</script>
	<?php

    }else{
		//if not a key value pair store in session and redirect again to login page...
		$_SESSION['failure'] = 'yes';
		?>
		<script> 
			window.location.href="login.php" ;
		</script>
		<?php
	}
} else {	
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="libs/img/icon.png">
	<title>Login</title>
	<link rel="stylesheet" href="css/style.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css"
		rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.popup {
			display: flex;
		}
	</style>
</head>

<body>

	<?php load_template('__login') ?>



</body>

<script src="js/index.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js">
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<?}?>

<script>

</script>
</html>
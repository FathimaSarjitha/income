<?php include 'libs/load.php';

//this will check wheather the user loged in and it not let him to access signup.php while Authenticated

if((Session::authorization($_COOKIE['sessionToken']) == true) and (isset($_SESSION['user_id'])) ) {
    ?>
<script type="text/javascript">
	window.location.href = "index.php";
</script>
<?php
}

$signup = false;
//make sure the required things are filled properly
if (isset($_POST['username']) and isset($_POST['password']) and !empty($_POST['password']) and isset($_POST['email']) and isset($_POST['phone']) and isset($_POST['job'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $job= $_POST['job'];
    $phone = $_POST['phone'];
    //it adds the user details and let him access the system
    $result = User::signup($username, $password, $email, $job, $phone);
    $signup = true;
    //check the signup is true
    if($signup) {
        //chech the result is true
        if ($result) {
            //if the result is true it redirect to index.php
            ?>
<script type="text/javascript">
	window.location.href = "index.php";
</script>
<?php
        }
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
	<title>SignUp</title>
	<link rel="stylesheet" href="css/style.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css"
		rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.popup {
			display: flex;
		}
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
	</style>
</head>

<body>
	<!--loads the signup template-->

	<?php load_template('__signup') ?>



</body>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
	crossorigin="anonymous"></script>
<script src="js/index.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js">
</script>


</html>

<?}?>
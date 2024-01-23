<?php
include 'libs/load.php';

//this code will prevent unauthorized people accessing this page...
if(empty($_SESSION['user_id'])) {
    ?>
<script type="text/javascript">
	window.location.href = "login.php";
</script>
<?php
}

//To make sure the editable datas are fetch from the another page with POST request.....
if (isset($_POST['id']) and isset($_POST['description']) and isset($_POST['date']) and isset($_POST['amount'])) {
    //Assigning variable with new value to be updated;
    $id = $_POST['id'];
    $description = $_POST['description'];
    $date =  $_POST['date'];
    $amount = $_POST['amount'];
    $type= $_POST['type'];
    //Updating the new value on database;
    $result = Daily::updateEntry($id, $description, $date, $amount);
    if ($result) {
        //if update done successfully the following javascript code will run to go existing page
        ?>
<script type="text/javascript">
	//it will go two steps back as click the back button on browser to go to the previous page
	history.go(-2)
</script>
<?php
    }
} else {
    ?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="@sweetalert2/theme-borderless/borderless.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
		integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">


</head>

<body>
	<?php load_template('__header'); ?>
	<?php load_template('__edit'); ?>
	<?php load_template('__footer'); ?>

</body>
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"
></script>

</html>
<?}

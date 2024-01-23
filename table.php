<?php
include 'libs/load.php';
if((Session::authorization($_COOKIE['sessionToken']) == false) or (!isset($_SESSION['user_id'])) ) {
    ?>
<script type="text/javascript">
	window.location.href = "login.php";
</script>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="libs/img/icon.png">
	<title><?=ucfirst($_GET['dailyincomelist'])?>
	</title>
	<link rel="stylesheet" href="@sweetalert2/theme-borderless/borderless.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
		integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

	<style>
		.popup {
			display: flex;
		}
	</style>
</head>

<body>

	<!--load the header area-->
	<?php load_template('__header');
	load_template('__filter') ?>
	

	<!--creates the table-->
	<div class="container rounded py-3" style="background-color:#F8F8F8;">

		<table class="table table-dark table-hover align-middle text-white text-center"
			style="border-bottom-left-radius:10px;border-bottom-right-radius:10px;backdrop-filter:blur(10px);">
			<thead>
				<tr>
					<th>Description</th>
					<th>Amount</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<?php

//gets the value for dailyincomelist from the get method
$type = $_GET['dailyincomelist'];
$filtering_option = $_POST['filter_type'];
$user_id = $_SESSION['user_id'];

switch ($filtering_option) {
        case 'week':
            $result = Daily::filterWeek($user_id,$type);
            break;

        case 'month':
            $result = Daily::filterMonth($user_id,$type);
            break;

        case 'year':
            $result = Daily::filterYear($_user_id,$type);
            break;

        case 'date':
			$startDate = $_POST['start_date'];
			$endDate = $_POST['end_date'];
			$result = Daily::filterWithDates($user_id, $startDate, $endDate,$type);

        default:
			$result = Daily::getListOf($user_id,$type);
            break;
    }

//This area will get value from the database and store it in the $row and with the help of loop it will show up the web..
if ($result->num_rows > 0) {
	?>
	<h1><?=strtoupper($type)?></h1>
	<?
    while ($row = $result->fetch_assoc()) {
        ?>
			<tr class="table_row">
				<td hidden class="value">
					<?=$row['id']?>
				</td>
				<td><?=$row['description']?></td>
				<td><?=number_format($row['amount'])?>
				</td>
				<td><?=$row['date']?></td>
				<td><button class="btn-primary" class="edit"><a style="text-decoration: none;"
							href="edit.php?id=<?=$row['id']?>&type=<?=$row['type']?>&description=<?=$row['description']?>&amount=<?=$row['amount']?>&date=<?=$row['date']?>"
							class="edit text-white text-decoration-none">Edit</a></button>
					<button class="delete text-decoration-none btn-primary">Delete</button>
				</td>


			</tr>
			<?}
    } else {
        ?>
			<h1>Oh. There Are No Entry Yet</h1><?php
    }
?>
		</table>
	</div>
	<?php load_template('__footer')?>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.js"></script>
<script src="js/table.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>


</html>

</html>
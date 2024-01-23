<?php include 'libs/load.php';


if((Session::authorization($_COOKIE['sessionToken']) == false) or (!isset($_SESSION['user_id'])) ) {
    ?>
<script type="text/javascript">
	window.location.href = "login.php";
</script>
<?php
}

$filtering_option = $_POST['filter_type'];
$user_id = $_SESSION['user_id'];
switch ($filtering_option) {
	case 'week':
		$resultOfIncome = Daily::filterWeek($user_id,'income');
		$resultOfExpense = Daily::filterWeek($user_id,'expense');
		break;

	case 'month':
		$resultOfIncome = Daily::filterMonth($user_id,'income');
		$resultOfExpense = Daily::filterMonth($user_id,'expense');
		break;

	case 'year':
		$resultOfIncome = Daily::filterYear($_user_id,'income');
		$resultOfExpense = Daily::filterYear($_user_id,'expense');
		break;

	case 'date':
		$startDate = $_POST['start_date'];
		$endDate = $_POST['end_date'];
		$resultOfIncome = Daily::filterWithDates($user_id, $startDate, $endDate,'income');
		$resultOfExpense = Daily::filterWithDates($user_id, $startDate, $endDate,'expense');

	default:
		$resultOfIncome = Daily::getListOf($_SESSION['user_id'], 'income');
		$resultOfExpense = Daily::getListOf($_SESSION['user_id'] , 'expense');
		break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://www.flaticon.com/free-icons/money" rel="icon">
	<title>Daily</title>
	<link rel="icon" type="image/x-icon" href="libs/img/icon.png">
	<link rel="stylesheet" href="@sweetalert2/theme-borderless/borderless.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
		integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

	<style>
		/* Styles required only for the example above */
		.scrollspy-example {
			position: relative;
			height: 500px;
			overflow: auto;
		}
	</style>
</head>


<?php load_template('__header');
load_template('__filter') ?>


<body>

	<div class="container rounded" style="background-color:#F8F8F8;">
		<h2 id="check"></h2>
		<div class="row">

			<div class="col-sm-4 justify-content-center text-center">
				<canvas id="myChart" style="position:relative;left:50%;transform:translate(-50%, 0)"></canvas>

				<div class="row justify-content-center">
					<h1 id="status"></h1>
				</div>
			</div>


			<div class="col-md-8 text-center">
				<div class="row">
					<div class="col-md-6 text-center py-3">
					<a href="table.php?dailyinccomelist=income" class="text-dark text-decoration-none">
							<!--Printing Total of Income on Webpage-->
							<h3 class="text-dark fw-bold">Income is :<span id="income-total">
							
									</span>
							</h3>
						</a>
						<div data-mdb-spy="scroll" data-mdb-target="#scrollspy1" data-mdb-offset="0"
							class="scrollspy-example">
							<!--Printing Values as table-->
							<table class="table table-dark align-middle text-white text-center rounded">
								<thead>
									<tr>
										<th>Description</th>
										<th>Date</th>
										<th>Amount</th>
										</trr>
								</thead>
								<?php
                                
if ($resultOfIncome->num_rows > 0) {

    while ($row = $resultOfIncome->fetch_assoc()) {
        ?>
								<tr class="table-row">
									<td hidden class="value">
										<?=$row['id']?>
									</td>
									<td><?=$row['description']?>
									</td>
									<td><?=$row['date']?>
									</td>
									<td>Rs.
										<?=number_format($row['amount'])?>
									</td>
								</tr>
								<?
								$incomeTotal = $incomeTotal + $row['amount'];
								
							}
    }?>
							</table>



						</div>
					</div>

					<div class="col-md-6 py-3">
					<a href="table.php?dailyinccomelist=expense" class="text-decoration-none icon-link-hover">
							<!--Printing Total of Expense on Webpage-->
							<h3 class="text-dark fw-bold">Expense is : <span id="expense-total">
									
									</span>
							</h3>
						</a>
						<div data-mdb-spy="scroll" data-mdb-target="#scrollspy1" data-mdb-offset="0"
							class="scrollspy-example">
							<!--Printing values as table-->
							<table class="table table-dark align-middle text-white text-center">
								<thead>
									<tr>
										<th>Description</th>
										<th>Date</th>
										<th>Amount</th>
										</trr>
								</thead>
								<?php
if ($resultOfExpense->num_rows > 0) {
    while ($row = $resultOfExpense->fetch_assoc()) {
        ?>
								<tr class="table-row">
									<td hidden class="value">
										<?=$row['id']?>
									</td>
									<td><?=$row['description']?>
									</td>
									<td><?=$row['date']?>
									</td>
									<td>Rs.
										<?=number_format($row['amount'])?>
									</td>
								</tr>
								<?
									$expenseTotal = $expenseTotal + $row['amount'];
								}
    }?>
							</table>
							
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>

	<div class='footer'>
		<?php load_template('__footer') ?>
	</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.js"></script>
<script src="js/table.js"></script>
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"
></script>
<!--The following code will generate Pie chart for the calcualtion....-->
<script>
	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: ['Income', 'Expense'],

			datasets: [{
				label: 'Amount is ',
				data: [ <?=$incomeTotal?> , <?=$expenseTotal?> ],

				backgroundColor: [
					'rgba(0, 0, 255, 0.7)',
					'rgba(255, 0, 0, 0.7)',
					'rgba(255, 206, 86, 1)'
				],
				borderColor: [
					'rgba(255,255,255, 1)',
					'rgba(255,255,255, 1)',
					'rgba(255,255,255, 1)'
				],
				borderWidth: 0
			}]
		},
		options: {
			responsive: false,
			plugins: {
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'Summery',
					color: 'black'
				}
			}
		}
	});
	var income = "<?=$incomeTotal?>";
	var income = Number(income);
	var expense = "<?=$expenseTotal?>";
	var expense = Number(expense);
	var total = income - expense;
	document.getElementById('income-total').innerHTML = 'Rs. ' + income;
	document.getElementById('expense-total').innerHTML = 'Rs. ' + expense;
	if (income > expense){
		document.getElementById('status').innerHTML = 'You Got Profit <br>' + total.toLocaleString('en-US');;
		// document.getElementById('amount').innerHTML = total;
	}else if (expense > income){
		var total = total * -1;
		document.getElementById('status').innerHTML = 'You Got Loss <br>' + total.toLocaleString('en-US');;
	}else{
		document.getElementById('status').innerHTML = 'No Entry';
	}

</script>


</html>
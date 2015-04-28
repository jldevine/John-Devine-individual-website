<?php
	session_start();
	if ($_SESSION['login'] != 1) {
	header('Location: login.php');
	exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>Patients</h3>
    		</div>
			<div class="row">
				<p>
					<!-- <a href="create.php" class="btn btn-success">Create</a> -->
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Name</th>
						  <th>Disease</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $Id = $_REQUEST['Id'];
					   //$condition = $_REQUEST['condition'];
					   $sql = 'SELECT * FROM Patients WHERE room = '.$Id.' ORDER BY Id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
								echo '<td>'. $row['disease'] . '</td>';
							   	echo '<td width=250>';
								echo '<a class="btn btn-success" href="create.php?id='.$Id.'">Create</a>';
							   	echo '&nbsp;'; 
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['Id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?id='.$Id.'&patientId='.$row['Id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>
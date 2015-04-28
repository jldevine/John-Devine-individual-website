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
    			<h3>Hospitals</h3>
    		</div>
			<div class="row">
				<p>
					<!-- <a href="create.php" class="btn btn-success">Create</a> -->
					<a href="logout.php" class="btn btn-success">Logout</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM Hospitals ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td width=250>';
							  	echo '<a class="btn" href="readHospitals.php?Id='.$row['Id'].'&hospital_name='.$row['name'].'">Read</a>';
							   	echo '&nbsp;';
							   	//echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
							   	//echo '&nbsp;';
							   	//echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
							   	//echo '</td>';
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
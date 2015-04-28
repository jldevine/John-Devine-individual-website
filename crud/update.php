<?php
	session_start();
	if ($_SESSION['login'] != 1) {
	header('Location: login.php');
	exit();
	}
?>

<?php 
	
	require 'database.php';

	$id = null;
	//if ( !empty($_GET['Id'])) {
		$id = $_REQUEST['id'];
	//}
		echo $id;
	if ( null==$id ) {
		
		header("Location: readPatients.php?Id=".$id."");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		//$nameError = null;
		//$emailError = null;
		$diseaseError = null;
		
		// keep track post values
		//$name = $_POST['name'];
		//$roomNumber = $_POST['room number'];
		$disease = $_POST['disease'];
		
		 //validate input
		$valid = true;
		if (empty($disease)) {
			$diseaseError = 'Please enter the disease';
			$valid = false;
		}
		
		/*if (empty($roomNumber)) {
			$emailError = 'Please enter room number';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Room Number';
			$valid = false;
		}*/
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Patients set disease = ? WHERE Id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($disease,$id));
			Database::disconnect();
			header("Location: readPatients.php?Id=".$id."");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Patients where Id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$disease = $data['disease'];
		Database::disconnect();
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
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a Patient</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  
					  <div class="control-group <?php echo !empty($diseaseError)?'error':'';?>">
					    <label class="control-label">Disease</label>
					    <div class="controls">
					      	<input name="disease" type="text"  placeholder="Disease" value="<?php echo !empty($disease)?$disease:'';?>">
					      	<?php if (!empty($diseaseError)): ?>
					      		<span class="help-inline"><?php echo $diseaseError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="readPatients.php?Id=<?php echo $id?>">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
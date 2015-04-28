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
		$nameError = null;
		$diseaseError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$disease = $_POST['disease'];

		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($disease)) {
			$diseaseError = 'Please enter Disease';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO Patients (name,disease,room) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$disease,$id));
			Database::disconnect();
			header("Location: readPatients.php?Id=".$id."");
		}
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
		    			<h3>Create Patient</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($diseaseError)?'error':'';?>">
					    <label class="control-label">Disease</label>
					    <div class="controls">
					      	<input name="disease" type="text" placeholder="Disease" value="<?php echo !empty($disease)?$disease:'';?>">
					      	<?php if (!empty($diseaseError)): ?>
					      		<span class="help-inline"><?php echo $diseaseError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="readPatients.php?Id=<?php echo $id?>">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
<?php 
	include 'php/config.php';  // Include the database connection
	session_start();
	if(isset($_POST['submit'])){ // if user click the admin btn
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, md5($_POST['password']));
		//declaring input

		if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // checking if email is valid
			$select = mysqli_query($conn, "SELECT * FROM user_form WHERE email = '$email'
															AND password = '$password' "); // Checking if user already exist
				if(mysqli_num_rows($select) > 0){
					$row = mysqli_fetch_assoc($select);
					$status = 'Active Now'; // User status

					$update = mysqli_query($conn, "UPDATE user_form SET status = '$status' WHERE user_id = '{$row['user_id']}' ");

					if($update){
						$_SESSION['user_id'] = $row['user_id'];
						header('location: home.php');
					}

				}else{
					$alert[] = "Incorrect password or email";
				}		
		} else {
			$alert[] = "$email is not a valid email";
		}
	}
?>
<!-- 0039564684 - GTB Bank (nkiru kanu) -->
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/style.css" />
		<title>welcome back</title>
	</head>
	<body>
		<div class="form-container">
			<form action="" method="post" enctype="multipart/form-data">
				<h3>welcome back</h3>
				<?php 
					if(isset($alert)){
						foreach ($alert as $alert){
							echo '<div class="alert">'.$alert.'</div>';
						}
					}
				?>
				<input
					type="text"
					name="email"
					placeholder="enter email"
					class="box"
					required
				/>
    
		    <div class="password-container">
	        <input
            type="password"
            name="password"
            placeholder="enter password"
            class="box password-input"
            required
	        />
	        <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
		    </div>

				<input type="submit" name="submit" class="btn" value="start chatting" />
				<p>Don't have an account? <a href="index.php"> Register now</a></p>
			</form>
		</div>
		<script src="js/func.js"></script>
	</body>
</html>

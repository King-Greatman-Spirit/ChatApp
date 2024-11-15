<?php 
	include 'php/config.php';  // Include the database connection
	$image_rename = 'default-avatar.png'; // user default image
	if(isset($_POST['submit'])){ // if user click the admin btn
		$ran_id = rand(time(), 1000000000); // creating random number

		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, md5($_POST['password']));
		$cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
		//declaring input

		if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // checking if email is valid
			$image = $_FILES['image']['name']; // user image name
			$image_size = $_FILES['image']['size']; // user image size
			$image_tmp_name = $_FILES['image']['tmp_name']; 
			$image_rename = $image;
			$image_folder = 'uploaded_img/' .$image_rename; // image folder
			$status = 'Active Now'; // User status

			$select = mysqli_query($conn, "SELECT * FROM user_form WHERE email = '$email'
															AND password = '$password' "); // Checking if user already exist
			if(mysqli_num_rows($select) > 0){
				$alert[] = "user already exist!";
			} else {
				if ($password != $cpassword){
					$alert[] = "Password not matched!";
				} elseif ($image_size > 2000000){
					$alert[] = "Image size is too large!";
				} else {
					$insert = mysqli_query($conn, "INSERT INTO `user_form`(`user_id`, `name`, `email`, `password`, `img`, `status`) VALUES ('$ran_id','$name','$email','$password','$image_rename','$status')");

					// Inserting user data to the database
					if($insert){ // if insert
						move_uploaded_file($image_tmp_name, $image_folder); // moving image file
						header('location: login.php');
					} else {
						$alert[] = "Connection failed. Please retry!";
					}
				}
			}

		} else {
			$alert[] = "$email is not a valid email";
		}
	}
?>	

<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/style.css" />
		<title>create account</title>
	</head>
	<body>
		<div class="form-container">
			<form action="" method="post" enctype="multipart/form-data">
				<h3>create account</h3>
				<?php 
					if(isset($alert)){
						foreach ($alert as $alert){
							echo '<div class="alert">'.$alert.'</div>';
						}
					}
				?>
				<!-- <div class="alert">error please try again!</div> -->
				<input
					type="text"
					name="name"
					placeholder="enter username"
					class="box"
					required
				/>
				<input
					type="email"
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

		    <div class="password-container">
		        <input
		            type="password"
		            name="cpassword"
		            placeholder="confirm password"
		            class="box password-input"
		            required
		        />
		        <i class="fas fa-eye toggle-password" onclick="togglePassword('cpassword')"></i>
		    </div>

				<input type="file" name="image" accept="image/*" class="box" />

				<input type="submit" name="submit" class="btn" value="start chatting" />
				<p>Already have an account? <a href="login.php"> Login now</a></p>
			</form>
		</div>


		<script src="js/func.js"></script>
	</body>
</html>

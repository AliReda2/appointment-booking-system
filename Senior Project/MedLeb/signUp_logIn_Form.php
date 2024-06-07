<!doctype html>
<html lang="en">

<head>
	<title>Sign in/Sign up</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="signUp_logIn_Form.css">
</head>
<?php
require("config.php");
?>

<body>
	<div class="section">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
						<input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
						<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<form class="section text-center" action="logIn.php" method="post">
											<h4 class="mb-4 pb-3">Log In</h4>
											<div class="form-group">
												<input type="email" class="form-style" placeholder="Email" spellcheck=false autocomplete="off" required name="email">
												<i class="input-icon uil uil-at"></i>
											</div>
											<div class="form-group mt-2">
												<input type="password" class="form-style" placeholder="Password" autocomplete="off" required name="password">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
											<input type="submit" class="btn mt-4" value="Login" name="logIn">
											<!-- <p class="mb-0 mt-4 text-center"><a href="#" class="link">Forgot your
													password?</a></p> -->
										</form>
									</div>
								</div>
								<div class="card-back">
									<div class="center-wrap">
										<form class="section text-center" method="post" action="regester.php">
											<h4 class="mb-3 pb-3">Sign Up</h4>
											<div class="form-group">
												<input type="text" class="form-style" placeholder="Full Name" autocomplete="off" required name="username">
												<i class="input-icon uil uil-user"></i>
											</div>
											<div class="form-group mt-2">
												<input type="email" class="form-style" placeholder="Email" spellcheck=false autocomplete="off" required name="email">
												<i class="input-icon uil uil-at"></i>
											</div>
											<div class="form-group mt-2">
												<input type="date" class="form-style" spellcheck=false autocomplete="off" required name="dob">
												<i class="input-icon uil uil-at"></i>
											</div>
											<div class="form-group mt-2">
												<input type="tel" class="form-style" placeholder="12-345-678" pattern="[0-9]{2}[0-9]{3}[0-9]{3}" name="phone" required> 
												<i class="input-icon uil uil-at"></i>
											</div>
											<div class="form-group mt-2">
												<input type="password" class="form-style" placeholder="Password" autocomplete="off" required name="password">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
											<div class="form-group mt-2">
												<input type="password" class="form-style" placeholder="Confirm Password" autocomplete="off" required name="confirmPassword">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
											<input class="btn mt-4" type="submit" value="Regester" name="regester">
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
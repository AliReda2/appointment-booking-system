<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
if (session_destroy()) {
	// Redirect to the login/signup form
	header("Location: signUp_logIn_Form.php");
	exit(); // Ensure the script stops executing after the redirect
} else {
	// Handle the case where the session couldn't be destroyed (optional)
	echo "Error: Unable to destroy the session.";
}

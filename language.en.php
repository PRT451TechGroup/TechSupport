<?php
Language::addString(array
(
	"techsupport" => "Tech Support",
	"user" => "User",
	"login" => "Login",
	"register" => "Register",
	"username" => "Username",
	"password" => "Password",
	"confirm_password" => "Confirm Password",
	"back" => "Back",
	"redirect" => "Redirect",
	"redirecting_to" => "Redirecting to",
	"password_mismatch" => "Passwords do not match",
	"username_blank" => "Username was empty",
	"password_blank" => "Password was empty"
));
Language::addCallback("unknown_page", function($data)
{
	return "Unknown page " . $data["path"];
});
?>

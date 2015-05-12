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
	"password_blank" => "Password was empty",
	"repair" => "Repair",
	"badlogin" => "Username or password was incorrect",
	"_continue" => "Continue",
	"logout" => "Logout",
	"logout_success" => "Logged out successfully",
	"repair_review" => "Review Jobs",
	"repair_create" => "Create Job",
	"save" => "Save",
	"owner" => "Owner",
	"location" => "Location",
	"building" => "Building",
	"floor" => "Floor",
	"room" => "Room",
	"duedate" => "Due Date and Time",
	"priority" => "Priority",
	"priority_on" => "On",
	"priority_off" => "Off",
	"equipment" => "Equipment",
	"nonameset" => "No Name Set",
	"newequip" => "New Equipment"
));
Language::addCallback("unknown_page", function($data)
{
	return "Unknown page " . $data["path"];
});
Language::addCallback("goodlogin", function($data)
{
	return "Successfully logged in as " . $data["username"];
});
?>

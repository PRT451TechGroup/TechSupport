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
	"repair_edit" => "Edit Job",
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
	"newequip" => "New Equipment",
	"addequipment" => "Add Equipment",
	"equipname" => "Equipment Name",
	"assetno" => "Asset Number",
	"equipdesc" => "Problem Description",
	"editequip" => "Edit Equipment",
	"delete" => "Delete",
	"completion_label" => "Completion",
	"job_priority" => "Priority",
	"job_normal" => "Normal",
	"job_none" => "None",
	"loan" => "Loan",
	"request" => "Staff Requests",
	"year" => "Year",
	"month" => "Month",
	"day" => "Day",
	"hour" => "Hour",
	"minute" => "Minutes",
	"date_due" => "Date",
	"time_due" => "Time",
	"jobname" => "Job Name",
	"complainer" => "Complainer",
	"precinct" => "Precinct",
	"loan_review" => "Review Loans",
	"loan_create" => "Create Loan",
	"loan_calendar" => "Loan Calendar",
	"loan_edit" => "Edit Loan",
	"loanername" => "Loaner Name",
	"staffname" => "Staff Name",
	"loandate" => "Loan Date",
	"returndate" => "Return Date",
	"creditor" => "Loaner",
	"debtor" => "Borrower",
	"loan_priority" => "Priority",
	"loan_normal" => "Normal",
	"loan_none" => "None",
	"today" => "Today",
	"tomorrow" => "Tomorrow",
	"loan_overdue" => "Overdue",
	"loan_view" => "View Loan"
));
Language::addString(array(
	"validate_equipmentname0" => "Equipment name cannot be empty",
	"validate_equipmentname1" => "Equipment name must consist of alphanumeric characters and may not end or start with spaces",
	"validate_assetno" => "Asset number must consist of alphanumeric characters and may not end or start with spaces"
));
Language::addCallback("unknown_page", function($data)
{
	return "Unknown page " . $data["path"];
});
Language::addCallback("goodlogin", function($data)
{
	return "Successfully logged in as " . $data["username"];
});
Language::addCallback("completion", function($data)
{
	$a = array("Not Done", "Partially Done", "Half Done", "Almost Done", "Done");
	return $a[$data["completion"]];
});
Language::addCallback("duecat", function($data)
{
	$a = array("Overdue", "Less than a day", "Less than a week", "Less than a month", "At least a month");
	return $a[$data["duecat"]];
});
Language::addCallback("monthat", function($data)
{
	$a = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	return $a[$data["month"]];
});
Language::addCallback("dayat", function($data)
{
	$a = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
	return $a[$data["day"]];
});
?>

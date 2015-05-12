<?php
/**
 * A data source
 *
 * @author AkariAkaori
 */
interface IDataSource
{
	public function datasource_init();
	public function datasource_create();


	/**
	 * Verifies login details
	 * 
	 * @param array $data [username => The username, password => The password]
	 * @return bool TRUE if the login details were correct, FALSE otherwise
	 */
	public function user_login($data);
	
	/**
	 * Registers a new account
	 * 
	 * @param array $data [username => The username, password => The password]
	 * @return mixed The new userid if the registration was successful, FALSE otherwise
	 */
	public function user_register($data);

	/**
	 * Retrieves a username
	 * 
	 * @param array $data [userid => The user's id]
	 * @return mixed The username is it exists, FALSE otherwise
	 */
	public function user_name($data);

	/**
	 * Retrieves a list of user ids and matching names
	 * 
	 * @return array An array in the form of [userid => username, ...]
	 */
	public function user_names();

	/**
	 * Creates a new repair job
	 * 
	 * @param array $data [userid => The user's id], [userid => The user's id, location => The location, duedate => Date and time due, completion => The completion level, priority => The priority value]
	 * @return mixed The new repairid if the addition was successful, FALSE otherwise
	 */
	public function repair_new($data);

	/**
	 * Retrieves a single repair job
	 * 
	 * @param array $data [repairid => The repair id]
	 * @return mixed An array with the keys [repairid, userid, location, duedate, completion, priority, equipmentcount] if it exists, FALSE otherwise 
	 */
	public function repair_get($data);

	/**
	 * Retrieves a list of distinct completion values with their counts and priority counts
	 *
	 */
	public function repair_completion();
	public function repair_list($data);
	public function repair_modify($data);
	public function repair_delete($data);

/*
	public function request_new($data);
	public function request_list();
	public function request_modify($data);
	public function request_delete($data);

	public function loan_new($data);
	public function loan_list();
	public function loan_modify($data);
	public function loan_delete($data);*/
}
?>

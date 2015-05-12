<?php
/**
	
*/
interface IDataSource
{
	public function datasource_init();
	public function datasource_create();

	/**

		Returns
	*/
	public function user_login($data);
	public function user_register($data);
	public function user_name($data);
	public function user_names();

	public function repair_new($data);
	public function repair_get($data);
	// Lists each progress level
	public function repair_progress($data);
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

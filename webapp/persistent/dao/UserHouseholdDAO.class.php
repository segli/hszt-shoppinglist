<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
interface UserHouseholdDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserHousehold 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param userHousehold primary key
 	 */
	public function delete($user_household_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserHousehold userHousehold
 	 */
	public function insert($userHousehold);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserHousehold userHousehold
 	 */
	public function update($userHousehold);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByHouseholdId($value);

	public function queryByIsOwner($value);


	public function deleteByUserId($value);

	public function deleteByHouseholdId($value);

	public function deleteByIsOwner($value);


}
?>
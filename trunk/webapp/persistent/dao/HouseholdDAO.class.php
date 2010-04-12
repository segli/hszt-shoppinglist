<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2010-04-12 20:35
 */
interface HouseholdDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Household 
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
 	 * @param household primary key
 	 */
	public function delete($household_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Household household
 	 */
	public function insert($household);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Household household
 	 */
	public function update($household);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);


	public function deleteByName($value);


}
?>
<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2010-04-12 20:35
 */
interface BudgetDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Budget 
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
 	 * @param budget primary key
 	 */
	public function delete($budget_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Budget budget
 	 */
	public function insert($budget);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Budget budget
 	 */
	public function update($budget);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByTimeStart($value);

	public function queryByTimeEnd($value);

	public function queryByBudgetCurrent($value);

	public function queryByBudgetQuota($value);

	public function queryByHouseholdId($value);


	public function deleteByTimeStart($value);

	public function deleteByTimeEnd($value);

	public function deleteByBudgetCurrent($value);

	public function deleteByBudgetQuota($value);

	public function deleteByHouseholdId($value);


}
?>
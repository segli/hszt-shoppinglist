<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2010-04-12 19:57
 */
interface ListDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return List 
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
 	 * @param list primary key
 	 */
	public function delete($list_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param List list
 	 */
	public function insert($list);
	
	/**
 	 * Update record in table
 	 *
 	 * @param List list
 	 */
	public function update($list);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByStatus($value);

	public function queryByHouseholdId($value);


	public function deleteByName($value);

	public function deleteByStatus($value);

	public function deleteByHouseholdId($value);


}
?>
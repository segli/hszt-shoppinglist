<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2010-04-13 22:30
 */
interface ShoppinglistDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Shoppinglist 
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
 	 * @param shoppinglist primary key
 	 */
	public function delete($shoppinglist_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Shoppinglist shoppinglist
 	 */
	public function insert($shoppinglist);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Shoppinglist shoppinglist
 	 */
	public function update($shoppinglist);	

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
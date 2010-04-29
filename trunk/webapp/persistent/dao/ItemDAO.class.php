<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2010-04-29 01:01
 */
interface ItemDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Item 
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
 	 * @param item primary key
 	 */
	public function delete($item_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Item item
 	 */
	public function insert($item);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Item item
 	 */
	public function update($item);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByDescription($value);

	public function queryByPrice($value);

	public function queryByStatus($value);

	public function queryByShoppinglistId($value);


	public function deleteByName($value);

	public function deleteByDescription($value);

	public function deleteByPrice($value);

	public function deleteByStatus($value);

	public function deleteByShoppinglistId($value);


}
?>
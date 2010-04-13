<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2010-04-13 22:30
 */
interface BillDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Bill 
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
 	 * @param bill primary key
 	 */
	public function delete($bill_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Bill bill
 	 */
	public function insert($bill);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Bill bill
 	 */
	public function update($bill);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByDate($value);

	public function queryByCost($value);

	public function queryByShoppinglistId($value);

	public function queryByUserId($value);


	public function deleteByDate($value);

	public function deleteByCost($value);

	public function deleteByShoppinglistId($value);

	public function deleteByUserId($value);


}
?>
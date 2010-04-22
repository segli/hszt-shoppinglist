<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
interface InvitationDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Invitation 
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
 	 * @param invitation primary key
 	 */
	public function delete($inventation_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Invitation invitation
 	 */
	public function insert($invitation);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Invitation invitation
 	 */
	public function update($invitation);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByHouseholdId($value);

	public function queryByPending($value);

	public function queryByDateCreated($value);


	public function deleteByUserId($value);

	public function deleteByHouseholdId($value);

	public function deleteByPending($value);

	public function deleteByDateCreated($value);


}
?>
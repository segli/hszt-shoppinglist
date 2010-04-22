<?php
/**
 * Class that operate on table 'shoppinglist'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
class ShoppinglistMySqlDAO implements ShoppinglistDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ShoppinglistMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM shoppinglist WHERE shoppinglist_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM shoppinglist';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM shoppinglist ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param shoppinglist primary key
 	 */
	public function delete($shoppinglist_id){
		$sql = 'DELETE FROM shoppinglist WHERE shoppinglist_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($shoppinglist_id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ShoppinglistMySql shoppinglist
 	 */
	public function insert($shoppinglist){
		$sql = 'INSERT INTO shoppinglist (name, status, date_created, date_closed, household_id, user_id) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($shoppinglist->name);
		$sqlQuery->setNumber($shoppinglist->status);
		$sqlQuery->set($shoppinglist->dateCreated);
		$sqlQuery->set($shoppinglist->dateClosed);
		$sqlQuery->set($shoppinglist->householdId);
		$sqlQuery->set($shoppinglist->userId);

		$id = $this->executeInsert($sqlQuery);	
		$shoppinglist->shoppinglistId = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ShoppinglistMySql shoppinglist
 	 */
	public function update($shoppinglist){
		$sql = 'UPDATE shoppinglist SET name = ?, status = ?, date_created = ?, date_closed = ?, household_id = ?, user_id = ? WHERE shoppinglist_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($shoppinglist->name);
		$sqlQuery->setNumber($shoppinglist->status);
		$sqlQuery->set($shoppinglist->dateCreated);
		$sqlQuery->set($shoppinglist->dateClosed);
		$sqlQuery->set($shoppinglist->householdId);
		$sqlQuery->set($shoppinglist->userId);

		$sqlQuery->set($shoppinglist->shoppinglistId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM shoppinglist';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM shoppinglist WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM shoppinglist WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDateCreated($value){
		$sql = 'SELECT * FROM shoppinglist WHERE date_created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDateClosed($value){
		$sql = 'SELECT * FROM shoppinglist WHERE date_closed = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByHouseholdId($value){
		$sql = 'SELECT * FROM shoppinglist WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM shoppinglist WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM shoppinglist WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM shoppinglist WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDateCreated($value){
		$sql = 'DELETE FROM shoppinglist WHERE date_created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDateClosed($value){
		$sql = 'DELETE FROM shoppinglist WHERE date_closed = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByHouseholdId($value){
		$sql = 'DELETE FROM shoppinglist WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUserId($value){
		$sql = 'DELETE FROM shoppinglist WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ShoppinglistMySql 
	 */
	protected function readRow($row){
		$shoppinglist = new Shoppinglist();
		
		$shoppinglist->shoppinglistId = $row['shoppinglist_id'];
		$shoppinglist->name = $row['name'];
		$shoppinglist->status = $row['status'];
		$shoppinglist->dateCreated = $row['date_created'];
		$shoppinglist->dateClosed = $row['date_closed'];
		$shoppinglist->householdId = $row['household_id'];
		$shoppinglist->userId = $row['user_id'];

		return $shoppinglist;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return ShoppinglistMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>
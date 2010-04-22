<?php
/**
 * Class that operate on table 'bill'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
class BillMySqlDAO implements BillDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return BillMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM bill WHERE bill_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM bill';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM bill ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param bill primary key
 	 */
	public function delete($bill_id){
		$sql = 'DELETE FROM bill WHERE bill_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($bill_id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param BillMySql bill
 	 */
	public function insert($bill){
		$sql = 'INSERT INTO bill (date_created, cost, shoppinglist_id, user_id) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($bill->dateCreated);
		$sqlQuery->set($bill->cost);
		$sqlQuery->set($bill->shoppinglistId);
		$sqlQuery->set($bill->userId);

		$id = $this->executeInsert($sqlQuery);	
		$bill->billId = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param BillMySql bill
 	 */
	public function update($bill){
		$sql = 'UPDATE bill SET date_created = ?, cost = ?, shoppinglist_id = ?, user_id = ? WHERE bill_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($bill->dateCreated);
		$sqlQuery->set($bill->cost);
		$sqlQuery->set($bill->shoppinglistId);
		$sqlQuery->set($bill->userId);

		$sqlQuery->set($bill->billId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM bill';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByDateCreated($value){
		$sql = 'SELECT * FROM bill WHERE date_created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCost($value){
		$sql = 'SELECT * FROM bill WHERE cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByShoppinglistId($value){
		$sql = 'SELECT * FROM bill WHERE shoppinglist_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM bill WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByDateCreated($value){
		$sql = 'DELETE FROM bill WHERE date_created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCost($value){
		$sql = 'DELETE FROM bill WHERE cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByShoppinglistId($value){
		$sql = 'DELETE FROM bill WHERE shoppinglist_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUserId($value){
		$sql = 'DELETE FROM bill WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return BillMySql 
	 */
	protected function readRow($row){
		$bill = new Bill();
		
		$bill->billId = $row['bill_id'];
		$bill->dateCreated = $row['date_created'];
		$bill->cost = $row['cost'];
		$bill->shoppinglistId = $row['shoppinglist_id'];
		$bill->userId = $row['user_id'];

		return $bill;
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
	 * @return BillMySql 
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
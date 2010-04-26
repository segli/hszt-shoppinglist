<?php
/**
 * Class that operate on table 'household'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-26 22:49
 */
class HouseholdMySqlDAO implements HouseholdDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return HouseholdMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM household WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM household';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM household ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param household primary key
 	 */
	public function delete($household_id){
		$sql = 'DELETE FROM household WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($household_id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param HouseholdMySql household
 	 */
	public function insert($household){
		$sql = 'INSERT INTO household (name) VALUES (?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($household->name);

		$id = $this->executeInsert($sqlQuery);	
		$household->householdId = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param HouseholdMySql household
 	 */
	public function update($household){
		$sql = 'UPDATE household SET name = ? WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($household->name);

		$sqlQuery->set($household->householdId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM household';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM household WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM household WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return HouseholdMySql 
	 */
	protected function readRow($row){
		$household = new Household();
		
		$household->householdId = $row['household_id'];
		$household->name = $row['name'];

		return $household;
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
	 * @return HouseholdMySql 
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
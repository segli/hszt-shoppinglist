<?php
/**
 * Class that operate on table 'budget'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-12 19:57
 */
class BudgetMySqlDAO implements BudgetDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return BudgetMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM budget WHERE budget_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM budget';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM budget ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param budget primary key
 	 */
	public function delete($budget_id){
		$sql = 'DELETE FROM budget WHERE budget_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($budget_id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param BudgetMySql budget
 	 */
	public function insert($budget){
		$sql = 'INSERT INTO budget (time_start, time_end, budget_current, budget_quota, household_id) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($budget->timeStart);
		$sqlQuery->set($budget->timeEnd);
		$sqlQuery->set($budget->budgetCurrent);
		$sqlQuery->set($budget->budgetQuota);
		$sqlQuery->set($budget->householdId);

		$id = $this->executeInsert($sqlQuery);	
		$budget->budgetId = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param BudgetMySql budget
 	 */
	public function update($budget){
		$sql = 'UPDATE budget SET time_start = ?, time_end = ?, budget_current = ?, budget_quota = ?, household_id = ? WHERE budget_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($budget->timeStart);
		$sqlQuery->set($budget->timeEnd);
		$sqlQuery->set($budget->budgetCurrent);
		$sqlQuery->set($budget->budgetQuota);
		$sqlQuery->set($budget->householdId);

		$sqlQuery->set($budget->budgetId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM budget';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByTimeStart($value){
		$sql = 'SELECT * FROM budget WHERE time_start = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTimeEnd($value){
		$sql = 'SELECT * FROM budget WHERE time_end = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBudgetCurrent($value){
		$sql = 'SELECT * FROM budget WHERE budget_current = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBudgetQuota($value){
		$sql = 'SELECT * FROM budget WHERE budget_quota = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByHouseholdId($value){
		$sql = 'SELECT * FROM budget WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByTimeStart($value){
		$sql = 'DELETE FROM budget WHERE time_start = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTimeEnd($value){
		$sql = 'DELETE FROM budget WHERE time_end = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBudgetCurrent($value){
		$sql = 'DELETE FROM budget WHERE budget_current = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBudgetQuota($value){
		$sql = 'DELETE FROM budget WHERE budget_quota = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByHouseholdId($value){
		$sql = 'DELETE FROM budget WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return BudgetMySql 
	 */
	protected function readRow($row){
		$budget = new Budget();
		
		$budget->budgetId = $row['budget_id'];
		$budget->timeStart = $row['time_start'];
		$budget->timeEnd = $row['time_end'];
		$budget->budgetCurrent = $row['budget_current'];
		$budget->budgetQuota = $row['budget_quota'];
		$budget->householdId = $row['household_id'];

		return $budget;
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
	 * @return BudgetMySql 
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
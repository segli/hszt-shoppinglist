<?php
/**
 * Class that operate on table 'shoppinglist'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-13 22:30
 */
class ShoppinglistMySqlExtDAO extends ShoppinglistMySqlDAO{

    public function queryAllByUserId($value){

		$sql = 'SELECT s.* FROM user_household u, household h, shoppinglist s';
		$sql .= ' WHERE u.user_id = ?';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND h.household_id = s.household_id';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	
}
?>
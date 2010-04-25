<?php
/**
 * Class that operate on table 'item'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
class ItemMySqlExtDAO extends ItemMySqlDAO{

    public function queryAllByUserIdAndShoppinglistId($uid, $sid){

		$sql = 'SELECT i.* FROM user_household u, household h, shoppinglist s, item i';
        $sql .= ' WHERE i.shoppinglist_id = s.shoppinglist_id';
        $sql .= ' AND s.household_id = h.household_id';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND u.user_id = ?';
        $sql .= ' AND s.shoppinglist_id = ?';

		$sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($uid);
        $sqlQuery->set($sid);
		return $this->getList($sqlQuery);
	}

    public function queryAllByUserId($uid){

		$sql = 'SELECT i.* FROM user_household u, household h, shoppinglist s, item i';
		$sql .= ' WHERE u.user_id = ?';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND h.household_id = s.household_id';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($uid);
		return $this->getList($sqlQuery);
	}
	
}
?>
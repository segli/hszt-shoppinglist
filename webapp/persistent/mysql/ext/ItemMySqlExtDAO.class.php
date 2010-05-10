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
        $sql .= ' AND s.shoppinglist_id = i.shoppinglist_id';
        $sql .= ' AND u.user_id = ?';
        $sql .= ' AND s.shoppinglist_id = ?';
        $sql .= ' AND (s.status != 1 OR s.user_id = ?)';

		$sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($uid);
        $sqlQuery->set($sid);
        $sqlQuery->set($uid);
		return $this->getList($sqlQuery);
	}

    public function queryAllByUserIdAndShoppinglistIdNotClosed($uid, $sid){

		$sql = 'SELECT i.* FROM user_household u, household h, shoppinglist s, item i';
        $sql .= ' WHERE i.shoppinglist_id = s.shoppinglist_id';
        $sql .= ' AND s.household_id = h.household_id';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND s.shoppinglist_id = i.shoppinglist_id';
        $sql .= ' AND u.user_id = ?';
        $sql .= ' AND s.shoppinglist_id = ?';
        $sql .= ' AND (s.status != 1 OR s.user_id = ?)';
        $sql .= ' AND i.status != 2'; // TODO: Habe ich von s.status zu i.status geändert

		$sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($uid);
        $sqlQuery->set($sid);
        $sqlQuery->set($uid);
		return $this->getList($sqlQuery);
	}

    public function queryAllByUserId($uid){

		$sql = 'SELECT i.* FROM user_household u, household h, shoppinglist s, item i';
		$sql .= ' WHERE u.user_id = ?';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND h.household_id = s.household_id';
        $sql .= ' AND s.shoppinglist_id = i.shoppinglist_id';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($uid);
		return $this->getList($sqlQuery);
	}

    public function queryAllByUserIdNotClosed($uid){

		$sql = 'SELECT i.* FROM user_household u, household h, shoppinglist s, item i';
		$sql .= ' WHERE u.user_id = ?';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND h.household_id = s.household_id';
        $sql .= ' AND s.shoppinglist_id = i.shoppinglist_id';
        $sql .= ' AND s.status != 1';
        $sql .= ' AND i.status != 2';  // TODO: Habe ich von s.status zu i.status geändert

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($uid);
		return $this->getList($sqlQuery);
    }

    public function queryAllByShoppinglistIdAndItemName($shoppinglist_id, $item_name) {

        $sql = 'SELECT i.* FROM item i';
        $sql .= ' WHERE i.shoppinglist_id = ?';
        $sql .= ' AND i.name = ?';

		$sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($shoppinglist_id);
		$sqlQuery->set($item_name);
		return $this->getList($sqlQuery);
    }

    /**
     * Finds all Items with state 1 and changes to 2
     * @param  $uid
     * @param  $sid
     */
    public function updateStateToClosedByUserIdAndShoppinglistId($uid, $sid){

		$sql = 'Update user_household u, household h, shoppinglist s, item i';
        $sql .= ' SET i.status = 2';
        $sql .= ' WHERE i.shoppinglist_id = s.shoppinglist_id';
        $sql .= ' AND s.household_id = h.household_id';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND s.shoppinglist_id = i.shoppinglist_id';
        $sql .= ' AND u.user_id = ?';
        $sql .= ' AND s.shoppinglist_id = ?';
        $sql .= ' AND (s.status != 1 OR s.user_id = ?)';
        $sql .= ' AND i.status = 1';

		$sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($uid);
        $sqlQuery->set($sid);
        $sqlQuery->set($uid);
		return $this->executeUpdate($sqlQuery);

        
    }

}
?>
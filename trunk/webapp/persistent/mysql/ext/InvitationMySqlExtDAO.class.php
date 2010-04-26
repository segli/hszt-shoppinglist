<?php
/**
 * Class that operate on table 'invitation'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
class InvitationMySqlExtDAO extends InvitationMySqlDAO{

    public function queryAllByUserId($value){

		$sql = 'SELECT i.*, h.* FROM invitation i, household h';
		$sql .= ' WHERE i.user_id = ?';
        $sql .= ' AND i.household_id = h.household_id';
        $sql .= ' AND pending = 1';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}
	
}
?>
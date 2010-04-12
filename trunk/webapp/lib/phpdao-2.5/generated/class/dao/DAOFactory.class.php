<?php

/**
 * DAOFactory
 * @author: http://phpdao.com
 * @date: ${date}
 */
class DAOFactory{
	
	/**
	 * @return BillDAO
	 */
	public static function getBillDAO(){
		return new BillMySqlExtDAO();
	}

	/**
	 * @return BudgetDAO
	 */
	public static function getBudgetDAO(){
		return new BudgetMySqlExtDAO();
	}

	/**
	 * @return HouseholdDAO
	 */
	public static function getHouseholdDAO(){
		return new HouseholdMySqlExtDAO();
	}

	/**
	 * @return ItemDAO
	 */
	public static function getItemDAO(){
		return new ItemMySqlExtDAO();
	}

	/**
	 * @return ListDAO
	 */
	public static function getListDAO(){
		return new ListMySqlExtDAO();
	}

	/**
	 * @return UserDAO
	 */
	public static function getUserDAO(){
		return new UserMySqlExtDAO();
	}

	/**
	 * @return UserHouseholdDAO
	 */
	public static function getUserHouseholdDAO(){
		return new UserHouseholdMySqlExtDAO();
	}


}
?>
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
	 * @return InvitationDAO
	 */
	public static function getInvitationDAO(){
		return new InvitationMySqlExtDAO();
	}

	/**
	 * @return ItemDAO
	 */
	public static function getItemDAO(){
		return new ItemMySqlExtDAO();
	}

	/**
	 * @return ShoppinglistDAO
	 */
	public static function getShoppinglistDAO(){
		return new ShoppinglistMySqlExtDAO();
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
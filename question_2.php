<?php
namespace SoftwareEngineerTest;

// Question 2 & 3 & 4

/**
 * Class Customer
 */
abstract class Customer {
	protected $id;
	protected $balance = 0;

	public function __construct($id) {
		$this->id = $id;
	}

	public function get_balance() {
		return $this->balance;
	}
}


// Write your code below
/**
 *  Class Bronze_Customer
 *  
 *  @author Csongor Halmai
 */
class Bronze_Customer extends Customer {
	public function deposit( $amount ) {
		$this -> balance += $amount;
	}
}

/**
 *  Class Silver_Customer
 *  
 *  @author Csongor Halmai
 */
class Silver_Customer extends Customer {
	public function deposit( $amount ) {
		$this -> balance += $amount * 1.05;
	}
}

/**
 *  Class Gold_Customer
 *  
 *  @author Csongor Halmai
 */
class Gold_Customer extends Customer {
	public function deposit( $amount ) {
		$this -> balance += $amount * 1.1;
	}
}

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

/**
 *  Factory function that returns a Bronze_Customer, Silver_Customer or Gold_Customer object
 *  according to the first character of the $id parameter, or throws an exception if the
 *  given argument is invalid.
 *
 *  @param   string  identifier that describes the new cutomer to create. 
 *  @return  object  a Bronze_Customer, Silver_Customer or Gold_Customer object
 */
function get_instance( $id ) {
	$pattern = "/^([BSG])[0-9]{1,9}$/";
	if ( preg_match( $pattern, $id, $matches ) ) {
		switch ( $matches[ 1 ] ) {
			case "B":
				$ret = new Bronze_Customer( $id );
				break;
			case "S":
				$ret = new Silver_Customer( $id );
				break;
			case "G":
				$ret = new Gold_Customer( $id );
				break;
		}
	} else {
		throw new \InvalidArgumentException();
	}
	return $ret;
}


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
 *  Abstract Class Typed_Customer
 *  
 *  This class covers the possibility to receive exrta deposit if the deposit() method is invoked
 *  and provides the generate_username() method for each subclasses.
 * 
 *  @author Csongor Halmai
 */
abstract class Typed_Customer extends Customer {
	private static $last_username_index = 0;  // incremented before each new username generation
	protected $prefix = "";                   // stores the B, S, G prefix of the customer
	protected $extra = 1;                     // factor for deposit (1.0 = no extra deposit)
	private static $used_usernames = array(); // stores the already used usernames
	
	/*
	 * Multiplies the deposit with a factor.
	 * 
	 * @param   $amount    double  the value of the deposit
	 * @param   $extra     double  the factor to multiple the deposit with
	 */
	public function deposit( $amount ) {
		$this -> balance += $amount * $this -> extra;
	}
	
	
	/**
	 *  Generates a unique username starting with the class prefix.
	 *
	 *  It can revoke several username generator functions. Please, uncomment the 
	 *  one that you prefer.
	 *
	 *  @return string  the generated username
	 */
	public function generate_username() {
		//return $this -> generate_username_incremented_decimal();
		//return $this -> generate_username_incremented_base36();
		//return $this -> generate_username_uniqid();
		return $this -> generate_username_random();
	}
	
	/**
	 *  It creates usernames by concatenating the prefix and an incremental decimal value.
	 *  Results: S1, S2, G3, B4, ..., G9, B10, S11, ...
	 *
	 *  Advantages: 
	 *     simple, quick, doesn't use much memory
	 *  Disadvantages:
	 *     user name is not random, tells the user how many user names were created before them.
	 *
	 *  @return string    the generated username
	 */
	private function generate_username_incremented_decimal() {
		self::$last_username_index++;
		if ( self::$last_username_index <= 0 ) {
			throw new Exception( "Username-space is full" );
		}
		$tail = self::$last_username_index;
		$ret = $this -> prefix. $tail;
		return $ret;
	}

	/**
	 *  It creates usernames by concatenating the prefix and an incremental 
	 *  value represented in base 36.
	 *  Results: S1, S2, G3, B4, ..., G9, Ba, Sb, ..., Sz, B10, S11, ...
	 *
	 *  Advantages: 
	 *     simple, quick, doesn't use much memory, shorter names than in case of generate_username_incremented_decimal()
	 *  Disadvantages:
	 *     user name is not random, tells the user how many user names were created before them.
	 *
	 *  @return string  the generated username
	 */
	private function generate_username_incremented_base36() {
		self::$last_username_index++;
		if ( self::$last_username_index <= 0 ) {
			throw new Exception( "Username-space is full" );
		}
		$tail = base_convert( self::$last_username_index, 10, 36 );
		$ret = $this -> prefix. $tail;
		return $ret;
	}

	/**
	 *  It creates usernames by concatenating the prefix and the result of the uniqid() function by eliminating the dot from it.
	 *  Results: S569b949c67d70216698490, B569b949c68d10910181490, ...
	 *
	 *  Advantages: 
	 *     simple, quick, doesn't use much memory, shorter names than in case of generate_username_incremented_decimal()
	 *  Disadvantages:
	 *     strongly relies on the uniqueness of uniquid()
	 *
	 *  @return string  the generated username
	 */
	private function generate_username_uniqid() {
		$ret = str_replace( ".", "" , uniqid( $this -> prefix, TRUE ) );
		return $ret;
	}

	/**
	 *  It creates usernames by concatenating the prefix and a random string.
	 *  The result's length changes between 2 and 30 characters.
	 * 
	 *  Results: Sa, G1fc3ewd4fg6h8jk64r, B325475836uq, ...
	 *
	 *  This function remembers the already generated names and protects from generating the same one again.
	 *
	 *  Advantages: 
	 *     creares really random user names.
	 *  Disadvantages:
	 *     conplicated, slow, uses much memory
	 *
	 *  @return string  the generated username
	 */
	private function generate_username_random() {
		$total_length = 30;
		do {
			$ret = $this -> prefix;
			$length = mt_rand( 1, $total_length - strlen( $this -> prefix ) );
			$characters = "abcdefghijklmnopqrstuvwxyz0123456789";
			for ( $i = 0; $i < $length; $i++ ) {
				$ret .= $characters[ mt_rand( 0, strlen( $characters ) - 1 ) ];
			}
		} while ( isset( self::$used_usernames[ $ret ] ) );
		self::$used_usernames[ $ret ] = 1;
		return $ret;
	}
}


/**
 *  Class Bronze_Customer
 *  
 *  @author Csongor Halmai
 */
class Bronze_Customer extends Typed_Customer {
	function __construct() {
		$this -> prefix = "B";
		$this -> extra = 1;
	}
}

/**
 *  Class Silver_Customer
 *  
 *  @author Csongor Halmai
 */
class Silver_Customer extends Typed_Customer {
	function __construct() {
		$this -> prefix = "S";
		$this -> extra = 1.05;
	}
}

/**
 *  Class Gold_Customer
 *  
 *  @author Csongor Halmai
 */
class Gold_Customer extends Typed_Customer {
	function __construct() {
		$this -> prefix = "G";
		$this -> extra = 1.1;
	}
}

<?php
namespace SoftwareEngineerTest;

// Question 1a

$DB_HOST = 'localhost';
$DB_NAME = 'test';
$DB_USER = 'test';
$DB_PASS = 'test';

// write your sql to get customer_data here
$sql = "
SELECT customer.*, occupation_name
	FROM customer 
	LEFT JOIN customer_occupation USING (customer_occupation_id)
";

?>

<h2>Customer List</h2>

<table>
	<tr>
		<th>Customer ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Occupation</th>
	</tr>

	<!-- Write your code here -->
	<?php
		/** Connects to the database using the global credentials.
		 *
		 *  @return PDO object
		 */
		function connectDb() {
			global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;
			$conn_str = sprintf( "mysql:host=%s;dbname=%s", $DB_HOST, $DB_NAME );
			$dbh = new \PDO( $conn_str, $DB_USER, $DB_PASS );
			$dbh -> setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			return $dbh;
		}
		
		/** Reads customer records from the database.
		 *
		 *  @param   PDO obejct  database handler PDO object
		 *  @param   string      the basic SQL command, without filtering
		 *  @return  array       list of customers
		 */
		function fetchCustomers( $dbh, $sql ) {
			if ( isset( $_GET[ "occupation_name" ] ) ) {
				$pattern = "/^[a-zA-Z0-9]+$/";
				if ( !preg_match( $pattern, $_GET[ "occupation_name" ] ) ) {
					throw new \Exception( "The occupation_name parameter must contain one or more alphanumerical characters." );
				}
				$sql .= "WHERE occupation_name = ?";
				$params = array( $_GET[ "occupation_name" ] );
			} else {
				$params = array();
			}
			
			$sth = $dbh -> prepare($sql);
			$sth -> execute( $params );
			$results = $sth -> fetchAll();
			return $results;
		}
		
		/** returns the table rows as html string.
		 *
		 *  @param   array   the list of the customers
		 *  @return  string  the html representation of the table rows.
		 */
		function getTableBody( $results ) {
			$ret = "";
			foreach ( $results as $row ) {
				$ret .= sprintf( "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><tr>",
					$row[ "customer_id" ],
					$row[ "first_name" ],
					$row[ "last_name" ],
					( $row[ "occupation_name" ] === NULL ) ? "un-employed" : $row[ "occupation_name" ]  // in PHP7 it can be shorter
				);
			}
			return $ret;
		}
		
		try {
			$dbh = connectDb();
			$results = fetchCustomers( $dbh, $sql );
			$tbody = getTableBody( $results );
			print $tbody;
		} catch (\Exception $e) {
			print( "<pre>" );
			print "Fatal error: ". $e -> getMessage();
			die();
		}
	?>

</table>

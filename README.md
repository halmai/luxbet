# Luxbet
PHP Developer Test Tasks

#Question 1:#
The predefined structure didn't allow me to follow a nicer coding practice. Normally I separate the presentation parts and the database manipulation from the business logic. I follow the MVC pattern even in small projects. 

Here I had to put everything in one which results not the nicest code. I created some functions to separate the tasks according to the MVC paradigm. 

I used PDO because it is more flexible if the database changes in the future. Moreover, PDO with the prepared queries solves the database specific escaping problem as well. 

In the specification it was not emphasised what kind of input the program has to accept. I limited the filter to be a 1...100 character long alphanumerical string allowing lower and upper case letters too but disallowing anything else. This is enough against malicious attacks. I implemented this with a regexp matching.

The `getTableBody()` function implements the View and it returns the whole content of the table as a HTML string. In case of many rows this can be memory consuming. It was not specified how big the dataset can be so I assumed that this is not an issue. 

The error handling is implemented by a simple try-catch shell. 

#Question 2:#
I was not allowed to touch the abstract class because I had to write my modifications under the `// Write your code below` line therefore I added the `deposit()` method to each of the three classes. 

In case of a more sophisticated logic, it would be better to re-factor this operation into the `Customer` abstract class or create a new abstract class between the `Customer` and the three new classes. 


#Question 3:#
The `get_instance()` factory function checks the first character by a regular expression matching. This is a concise way for checking the following things:
- the first character is B, S or G
- the remaining characters are all digits
- there exists at least one digit after the letter
- the total length is not greater than 10
If the parameter is not matching then an exception is thrown, otherwise the appropriate object is instantiated and returned.

If the matching is done then the first letter must be B, S or G so there is no need for default branch within the switch statement. The last `case "G":` could be replaced by a `default:` but the explicit `case` makes the code more readable. 


#Question 4:#
Here I created a middle-layer abstract class named `Typed_Customer` between the `Customer` and the three specific classes. 

This class already contains the deposit() function which takes the type of the customer into account. When a deposit is done then the new balance is computed according to a factor that is initialised in the constructors. 

The constructor initialises the prefix as well which is used when a user name is generated. 

I created four implementations for the `generate_username()` function, actually, it can revoke any of them. The choice has to be done by commenting out the unneeded lines from the `generate_username()` function. 

The four implementations are:
 - `generate_username_incremented_decimal()`
 - `generate_username_incremented_base36()`
 - `generate_username_uniqid()`
 - `generate_username_random()`

The advantages and disadvantages of the individual implementations are detailed in the PHPDoc blocks of them. Unfortunately there was no information in the specification which one of them is preferred and I had no contact to ask. Therefore, I left all of them in the code. Please, chose one according to your preferences. I could add even more, for example a database-oriented one but there wasn't any information to make it even more complicated. Please, contact me if you need another implementation. 

My email address is: <csongor@halmai.hu>

Thanks, 

Csongor

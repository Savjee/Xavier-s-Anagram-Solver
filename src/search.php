<?/*
	Xavier's Anagram Solver
	Copyright (c) 2011 Xavier Decuyper

	Permission is hereby granted, free of charge, to any person
	obtaining a copy of this software and associated documentation
	files (the "Software"), to deal in the Software without
	restriction, including without limitation the rights to use,
	copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the
	Software is furnished to do so, subject to the following
	conditions:

	The above copyright notice and this permission notice shall be
	included in all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
	OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
	HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
	FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
	OTHER DEALINGS IN THE SOFTWARE.
*/
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//Connect to database
$db_host = "localhost:8889";
$db_user = "root";
$db_pwd = "root";
$db_database = "anagram";

if (!mysql_connect($db_host, $db_user, $db_pwd)) die("I'm sorry, there seems to be a problem with our database. Try again later.");
if (!mysql_select_db($db_database)) die("I'm sorry, there seems to be a problem with our database. Try again later.");


//Get the parameters
$query = mysql_real_escape_string($_GET["q"]);
$lang = mysql_real_escape_string($_GET["lang"]);

$query = strtolower($query);

//Alphabeticly order the search term
$alfa = array();
for ($count = 0; $count <= strlen($query) -1; $count++){
	$char = $query[$count];
	array_push($alfa, $char);
}

sort($alfa);

//Putting the word back toughether
$query = implode("", $alfa);


$sql = mysql_query("SELECT * FROM {$lang} WHERE alfa='".$query."'");

if(mysql_num_rows($sql)==0){
  	die("I'm sorry, I couldn't solve the anagram.");
}

while($row = mysql_fetch_assoc($sql)){
    echo $row['Word'],"<br>";
}
?>
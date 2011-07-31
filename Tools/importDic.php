<?/*	
	This file allows you to import a TXT dictionary file into a database suited for the solver.
	Executing this file takes some time and lot's of memory.
	This script could be more efficient, but since you'll only need it once or twice, it's no big deal.
	
	-
	
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
ini_set("memory_limit","64M");

$db_host = 'localhost:8889';
$db_user = 'root';
$db_pwd = 'root';

$db_database = 'anagram';
$db_table = 'english';

//Connect do DB
if (!mysql_connect($db_host, $db_user, $db_pwd)) die("Can't connect to database");
if (!mysql_select_db($db_database)) die("Can't select database");

$myFile = "dicEng.txt";
$fh = fopen($myFile, 'r');
$data = fread($fh,filesize($myFile));
fclose($fh);

$wordsArray = explode(",", $data);

for ($counter = 0; $counter <= count($wordsArray) -1; $counter++) {
	$string = $wordsArray[$counter];
	$alfa = array();
	for ($counter2 = 0; $counter2 <= strlen($wordsArray[$counter]) -1; $counter2++){
		$char = $string[$counter2];
		array_push($alfa, $char);
	}
	
	//sort the array
	sort($alfa);
	$alfaSQL = implode("", $alfa);
	$sql = mysql_query("INSERT INTO `anagram`.`english` (`Word`,`alfa`) VALUES ('".$wordsArray[$counter]."', '".$alfaSQL."');");
	
}

?>
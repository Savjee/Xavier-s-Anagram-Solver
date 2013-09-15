<?php

class Solver {

    private $db, $q, $lang;

    function __construct(PDO $db){
        $this->db = $db;
    }

    public function solve($query, $lang){
        $this->setQuery($query);
        $this->setLanguage($lang);

        // Re-order letters
        $this->orderLetters();

        // Get solutions from the database
        $solutions = $this->getSolutionsFromDb();

        // Reformat the array to a simple HTML structure
        foreach($solutions as $solution){
            echo $solution . '<br>';
        }
    }


    private function setQuery($q){
        $q = htmlspecialchars_decode($q);

        // Check if query is long enough
        if( strlen($q) < 3){
            throw new Exception('Query not long enough');
        }

        $this->q = strtolower($q);
    }

    private function setLanguage($lang){
        $valid_languages = array('english', 'dutch');
        $lang = strtolower($lang);

        if( !in_array($lang, $valid_languages) ){
            throw new Exception('Specified language was invalid');
        }

        $this->lang = $lang;
    }

    private function orderLetters(){
        $alfa = array();

        for($i = 0; $i <= strlen($this->q) -1; $i++){
            $char = $this->q[$i];
            array_push($alfa, $char);
        }

        // Sort the array!
        sort($alfa);

        // Putting it back toughether
        $this->q = implode('', $alfa);
    }

    private function getSolutionsFromDb(){

        // This should be safe since $lang was checked by setLanguage()
        $qry = $this->db->prepare('SELECT * FROM '. $this->lang .' WHERE alfa = ? LIMIT 10');
        $qry->execute(array($this->q));

        if($qry->rowCount() == 0){
            die('I\'m sorry. I could\'t solve the anagram.');
        }

        $out = array();

        while($solution = $qry->fetchObject()){
            array_push($out, $solution->Word);
        }

        return $out;
    }

}
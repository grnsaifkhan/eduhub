<?php


class Tests
{
    private $conn;
    private $table = 'testinfo';


    //properties
    public $id;
    public $testname;
    public $testdate;
    public $subjectid;
    public $teacherid;

    //contructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    //create user
    public function create(){
        $query = 'INSERT INTO '
            .$this->table. '
                SET 
                    testname = :testname,
                    testdate = :testdate,
                    subjectid = :subjectid,
                    teacherid = :teacherid';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->testname = htmlspecialchars(strip_tags($this->testname));
        $this->testdate = htmlspecialchars(strip_tags($this->testdate));
        $this->subjectid = htmlspecialchars(strip_tags($this->subjectid));
        $this->teacherid = htmlspecialchars(strip_tags($this->teacherid));

        //bind data
        $stmt->bindParam(':testname', $this->testname);
        $stmt->bindParam(':testdate', $this->testdate);
        $stmt->bindParam(':subjectid', $this->subjectid);
        $stmt->bindParam(':teacherid', $this->teacherid);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //GET test
    public function readTestForOneSubject(){

        $query = 'SELECT 
            id,
            testname,
            testdate,
            subjectid,
            teacherid
           FROM
            ' .$this->table. '
            WHERE subjectid = ?';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind Teacher ID
        $stmt->bindParam(1,$this->subjectid);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    //GET tests
    public function readTestWithTestId(){

        $query = 'SELECT 
            id,
            testname,
            testdate,
            subjectid,
            teacherid
           FROM
            ' .$this->table. '
            WHERE id = ?';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind Teacher ID
        $stmt->bindParam(1,$this->id);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function updateTest(){
        $query = 'UPDATE '
            .$this->table. '
                SET 
                    testname = :testname,
                    testdate = :testdate
                      
                WHERE
                
                     id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->testname = htmlspecialchars(strip_tags($this->testname));
        $this->testdate = htmlspecialchars(strip_tags($this->testdate));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(':testname', $this->testname);
        $stmt->bindParam(':testdate', $this->testdate);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //Delete Class
    public function delete(){
        //Create query
        $query = 'DELETE FROM '.$this->table.' WHERE id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean id
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind id
        $stmt->bindParam(':id', $this->id);


        //Execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }






}
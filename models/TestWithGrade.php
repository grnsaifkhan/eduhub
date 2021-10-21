<?php


class TestWithGrade
{
    private $conn;
    private $table = 'testwithgrade';


    //properties
    public $id;
    public $grade;
    public $testid;
    public $studentusername;

    //contructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    public function addSingleStudentGrade(){
        $query = 'INSERT INTO '
            .$this->table. '
                SET 
                    testid = :testid,
                    studentusername = :studentusername,
                    grade = :grade';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->testid = htmlspecialchars(strip_tags($this->testid));
        $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));
        $this->grade = htmlspecialchars(strip_tags($this->grade));

        //bind data
        $stmt->bindParam(':testid', $this->testid);
        $stmt->bindParam(':studentusername', $this->studentusername);
        $stmt->bindParam(':grade', $this->grade);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function getAllPupilSingleGradeTest(){
        $query = 'SELECT 
            std.firstname as firstname,
            std.lastname as lastname,
            std.username as studentusername,
            ts.testname as testname,
            tsg.testid as testid,
            tsg.grade as grade
            FROM testwithgrade tsg INNER JOIN testinfo ts
            ON ts.id = tsg.testid
            INNER JOIN userinfo std
            ON std.username = tsg.studentusername
            
            WHERE ts.id = ?
            ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->id);

        $stmt->execute();

        return $stmt;
    }

    public function updatePupilSingleGradeTest(){
        $query = 'UPDATE '
            .$this->table. '
                SET 
                    grade = :grade
                      
                WHERE
                
                     testid = :testid 
                     AND studentusername = :studentusername';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->grade = htmlspecialchars(strip_tags($this->grade));
        $this->testid = htmlspecialchars(strip_tags($this->testid));
        $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));

        //bind data
        $stmt->bindParam(':grade', $this->grade);
        $stmt->bindParam(':testid', $this->testid);
        $stmt->bindParam(':studentusername', $this->studentusername);

        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function deleteTestWithAllPupilAndGrade(){
        //delete all grade where testid = ?
        $query = 'DELETE FROM '.$this->table.' WHERE testid = :testid';
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean id
        $this->testid = htmlspecialchars(strip_tags($this->testid));
        //Bind id
        $stmt->bindParam(':testid', $this->testid);
        //execute statement
        $stmt->execute();

        //delete test where id =?
        $deleteTestQuery = 'DELETE FROM testinfo WHERE id = :testid';
        $deleteTestStmt = $this->conn->prepare($deleteTestQuery);
        $this->testid = htmlspecialchars(strip_tags($this->testid));
        $deleteTestStmt->bindParam(':testid', $this->testid);
        //execute statement
        $deleteTestStmt->execute();

        //Execute query
        if($deleteTestStmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function importAllStudentsGrade($file){

//        $filename = fopen('ui/'.$file, 'a');
////
        $f_pointer = fopen($file['tmp_name'], "r");//file pointer

        while(! feof($f_pointer)){
            $array = fgetcsv($f_pointer);
            if ($array){
                $arrayUsername = $array[0];
                if (!is_null($arrayUsername)){
                    $query = 'INSERT INTO '
                        .$this->table. '
                SET 
                    testid = :testid,
                    studentusername = :studentusername,
                    grade = :grade';

                    //prepare statement
                    $stmt = $this->conn->prepare($query);

                    //Clean data
                    $this->testid = htmlspecialchars(strip_tags($this->testid));
                    $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));
                    $this->grade = htmlspecialchars(strip_tags($this->grade));

                    //bind data
                    $stmt->bindParam(':testid', $this->testid);
                    $stmt->bindParam(':studentusername', $array[0]);
                    $stmt->bindParam(':grade', $array[1]);

                    //Execute query
                    $stmt->execute();
                }

            }

        }

        return true;
    }

    //this function is not complete
    public function getAllPupilWithAverageGrade($subjectid){
        $query = 'SELECT 
            std.firstname as firstname,
            std.lastname as lastname,
            std.username as username,
            tsg.grade as grade,
            sub.id as subjectid,
            FROM testwithgrade tsg INNER JOIN testinfo ts
            ON ts.id = tsg.testid
            INNER JOIN userinfo std
            ON std.username = tsg.studentusername
            
            WHERE ts.id = ?
            ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->id);

        $stmt->execute();

        return $stmt;
    }

    //getAverageTestGrade

    public function getAverageTestGradeofAllStudent($subjectid){
        $query = 'SELECT 
            tsg.studentusername as studentusername,
            ROUND(AVG (tsg.grade),2) as averagegrade
            FROM testwithgrade tsg INNER JOIN testinfo ts
            ON tsg.testid = ts.id
            INNER JOIN subjectinfo sub
            ON sub.id = ts.subjectid
            
            WHERE sub.id = :subjectid
            GROUP BY tsg.studentusername
            ';

        $stmt = $this->conn->prepare($query);

        //$stmt->bindParam(':studentusername',$studentUsername);
        $stmt->bindParam(':subjectid',$subjectid);

        $stmt->execute();

        return $stmt;
    }
}
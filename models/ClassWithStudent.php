<?php


class ClassWithStudent
{
    private $conn;
    private $table = 'classwithstudent';


    //properties
    public $id;
    public $classid;
    public $studentusername;

    //contructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    //create Classes

    //create user
    public function insertStudentWithClass(){


        /*$classquery = 'SELECT * from classinfo where classname='.$this->classname;
        $classgetstmt = $this->conn->prepare($classquery);*/



        $database = new Database();
        $db = $database->connect();

        $classWithStudent = new ClassWithStudent($db);

        $result = $classWithStudent->getStudent('classwithstudent',$this->studentusername);
        //Get row count
        $num = $result->rowCount();

        if ($num>0){
            //update student id with new class id
            $query = 'UPDATE '
                .$this->table. '
                SET 
                    classid = :classid
                      
                WHERE
                
                     studentusername = :studentusername';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->classid = htmlspecialchars(strip_tags($this->classid));
            $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));

            //bind data
            $stmt->bindParam(':classid', $this->classid);
            $stmt->bindParam(':studentusername', $this->studentusername);

            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }else{

            $query = 'INSERT INTO '
                .$this->table. '
                SET 
                    classid = :classid,
                    studentusername = :studentusername';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->classid = htmlspecialchars(strip_tags($this->classid));
            $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));

            //bind data
            $stmt->bindParam(':classid', $this->classid);
            $stmt->bindParam(':studentusername', $this->studentusername);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }


    }

    public function update(){
        $query = 'UPDATE '
            .$this->table. '
                SET 
                    classid = :classid
                      
                WHERE
                
                     studentusername = :studentusername';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->classid = htmlspecialchars(strip_tags($this->classid));
        $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));

        //bind data
        $stmt->bindParam(':classid', $this->classid);
        $stmt->bindParam(':studentusername', $this->studentusername);

        if($stmt->execute()){
            return 'data updated';
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return 'data not updated';
    }

    public function removePupil(){
        $database = new Database();
        $db = $database->connect();

        $classWithGrade = new ClassWithStudent($db);

        $result = $classWithGrade->getStudent('testwithgrade',$this->studentusername);
        //Get row count
        $num = $result->rowCount();

        if ($num>0){
            //select necessary column for archived subject

            $query = "INSERT INTO archivedsubject(studentusername,subjectname,testname,grade) SELECT 
            std.username as studentusername,
            sub.subjectname as subjectname,
            ts.testname as testname,
            tsg.grade as grade
            FROM testwithgrade tsg INNER JOIN testinfo ts
            ON ts.id = tsg.testid
            INNER JOIN userinfo std
            ON std.username = tsg.studentusername
            INNER JOIN subjectinfo sub
            ON sub.id = ts.subjectid
            
            WHERE tsg.studentusername = ?";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1,$this->studentusername);

            $stmt->execute();

            //delete testwithgrade query
            $deletequerytsg = 'DELETE FROM testwithgrade WHERE studentusername = :studentusername';
            //prepare statement
            $stmtForDeletionTsg = $this->conn->prepare($deletequerytsg);
            //Clean id
            $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));
            //Bind id
            $stmtForDeletionTsg->bindParam(':studentusername', $this->studentusername);
            $stmtForDeletionTsg->execute();

            //delete classwithstudent query

            $deletequeryclasswstudent = 'DELETE FROM classwithstudent WHERE studentusername = :studentusername';
            //prepare statement
            $stmtForDeletionCws = $this->conn->prepare($deletequeryclasswstudent);
            //Clean id
            $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));
            //Bind id
            $stmtForDeletionCws->bindParam(':studentusername', $this->studentusername);

            if($stmtForDeletionCws->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmtForDeletionCws->error);

            return false;


        }else{
            //delete classwithstudent query

            $deletequeryclasswstudent = 'DELETE FROM classwithstudent WHERE studentusername = :studentusername';
            //prepare statement
            $stmtForDeletionCws = $this->conn->prepare($deletequeryclasswstudent);
            //Clean id
            $this->studentusername = htmlspecialchars(strip_tags($this->studentusername));
            //Bind id
            $stmtForDeletionCws->bindParam(':studentusername', $this->studentusername);

            if($stmtForDeletionCws->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmtForDeletionCws->error);

            return false;
        }
    }

    public function getStudentWithClass(){
        $query = 'SELECT 
            std.username as username,
            cls.id as classid,
            cls.classname as classname
            FROM classwithstudent cws INNER JOIN classinfo cls
            ON cls.id = cws.classid
            INNER JOIN userinfo std
            ON std.username = cws.studentusername 
            WHERE cws.classid = ?
            ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->classid);

        $stmt->execute();

        return $stmt;
    }

    public function getStudentWithSameClassUsingTestId($testid){
        $query = 'SELECT studentusername, classid FROM classwithstudent 
                where classid=(SELECT classid FROM subjectinfo WHERE id=(SELECT subjectid FROM testinfo WHERE id = :testid))
            ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':testid',$testid);

        $stmt->execute();

        return $stmt;
    }

    public function getStudent($tablename,$studentusername){
        $query = "select id from ".$tablename." where studentusername = '".$studentusername."'";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

}
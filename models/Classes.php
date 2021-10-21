<?php


class Classes
{
    private $conn;
    private $table = 'classinfo';


    //properties
    public $id;
    public $classname;

    //contructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    //create Classes

    //create user
    public function create(){


        /*$classquery = 'SELECT * from classinfo where classname='.$this->classname;
        $classgetstmt = $this->conn->prepare($classquery);*/



        $database = new Database();
        $db = $database->connect();

        $classes = new Classes($db);

        $result = $classes->getClass($this->classname);
        //Get row count
        $num = $result->rowCount();

        if ($num>0){
            return false;
        }


            $query = 'INSERT INTO '
                .$this->table. '
                SET 
                    classname = :classname';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->classname = htmlspecialchars(strip_tags($this->classname));

            //bind data
            $stmt->bindParam(':classname', $this->classname);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;

    }

    //GET all classes
    public function read(){
        //create query
        $query = 'SELECT 
            id,
            classname
           FROM
            ' .$this->table;

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function update(){

        $result = $this->getClassnameWith($this->classname);
        //Get row count
        $num = $result->rowCount();
        if ($num>0){
            return false;
        }else{
            $query = 'UPDATE '
                .$this->table. '
                SET 
                    classname = :classname  
                WHERE
                
                     id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->classname = htmlspecialchars(strip_tags($this->classname));

            //bind data
            $stmt->bindParam(':classname', $this->classname);
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

    //Delete Class
    public function removeClass($classId){
        //count no. of subject
        $database = new Database();
        $db = $database->connect();

        $subjects = new Classes($db);
        $result = $subjects->getSubject('subjectinfo',$classId);
        $num = $result->rowCount();

        if ($num>0){
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
            INNER JOIN classinfo cls
            ON cls.id = sub.classid
            
            WHERE cls.id = :classid";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':classid',$classId);
            $stmt->execute();

            //more to write.....

            //delete testwithgrade
            //$tsgquery = 'DELETE FROM testwithgrade WHERE testid=(SELECT id FROM testinfo WHERE subjectid=(SELECT id FROM subjectinfo WHERE classid=(SELECT id FROM classinfo WHERE id = :id)))';
            $tsgquery = 'DELETE testwithgrade FROM  testwithgrade INNER JOIN testinfo ON testwithgrade.testid = testinfo.id INNER JOIN subjectinfo ON subjectinfo.id = testinfo.subjectid INNER JOIN classinfo ON classinfo.id=subjectinfo.classid WHERE classinfo.id = :id';
            //prepare statement
            $tsgstmt = $this->conn->prepare($tsgquery);
            //Clean id
            $classId = htmlspecialchars(strip_tags($classId));
            //Bind id
            $tsgstmt->bindParam(':id', $classId);
            $tsgstmt->execute();

            //delete testinfo
            $tsquery = 'DELETE testinfo FROM  testinfo INNER JOIN subjectinfo ON subjectinfo.id = testinfo.subjectid INNER JOIN classinfo ON classinfo.id=subjectinfo.classid WHERE classinfo.id = :id';
            //$tsquery = 'DELETE FROM testinfo WHERE subjectid = (SELECT id FROM subjectinfo WHERE classid=(SELECT id FROM classinfo WHERE id=:id))';
            //prepare statement
            $tsstmt = $this->conn->prepare($tsquery);
            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $tsstmt->bindParam(':id', $classId);
            $tsstmt->execute();

            //delete subjectinfo
            $subquery = 'DELETE subjectinfo FROM subjectinfo INNER JOIN classinfo ON classinfo.id=subjectinfo.classid WHERE classinfo.id = :id';
            //$subquery = 'DELETE FROM subjectinfo WHERE classid = (SELECT id FROM classinfo WHERE id=:id)';
            //prepare statement
            $tsstmt = $this->conn->prepare($subquery);
            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $tsstmt->bindParam(':id', $classId);
            $tsstmt->execute();

            //delete classwithsubject
            $cwsquery = 'DELETE FROM classwithstudent WHERE classid = :id';
            //$cwsquery = 'DELETE FROM classwithstudent WHERE classid = (SELECT id FROM classinfo WHERE id=:id)';
            //prepare statement
            $cwsstmt = $this->conn->prepare($cwsquery);
            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $cwsstmt->bindParam(':id', $classId);
            $cwsstmt->execute();

            //delete classinfo
            $clsquery = 'DELETE FROM classinfo 
                      WHERE id = :id';
            //prepare statement
            $clsstmt = $this->conn->prepare($clsquery);
            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $clsstmt->bindParam(':id', $classId);

            if($clsstmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;

        }elseif($num==0){

            //delete classwithsubject
            $csquery = 'DELETE FROM classwithstudent 
                    WHERE classid = :id';
            //prepare statement
            $csstmt = $this->conn->prepare($csquery);
            //Clean id
            //$this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $csstmt->bindParam(':id', $classId);
            $csstmt->execute();

            //delete classinfo
            $clquery = 'DELETE FROM classinfo 
                      WHERE id = :id';
            //prepare statement
            $clstmt = $this->conn->prepare($clquery);
            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $clstmt->bindParam(':id', $classId);

            if($clstmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $clstmt->error);

            return false;
        }else{
            return false;
        }
    }


    public function getClass($name){
        $query = "select * from classinfo where classname = '".$name."'";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function getSubject($tablename,$classid){
        $query = "select id from ".$tablename." where classid = '".$classid."'";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function getClassName($classid){
        $query = "select classname from classinfo where id = '".$classid."'";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }


    public function getClassnameWith($classname){
        $query = "select classname from classinfo where classname = '".$classname."'";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }


}
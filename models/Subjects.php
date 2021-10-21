<?php


class Subjects
{
    private $conn;
    private $table = 'subjectinfo';


    //properties
    public $id;
    public $subjectname;
    public $teacherid;
    public $classid;

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

        $subjects = new Subjects($db);

        $result = $subjects->getSubject($this->subjectname);
        //Get row count
        $num = $result->rowCount();

        if ($num>0){
            return false;
        }


        $query = 'INSERT INTO '
            .$this->table. '
                SET 
                    subjectname = :subjectname,
                    teacherid = :teacherid,
                    classid = :classid';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->subjectname = htmlspecialchars(strip_tags($this->subjectname));
        $this->teacherid = htmlspecialchars(strip_tags($this->teacherid));
        $this->classid = htmlspecialchars(strip_tags($this->classid));

        //bind data
        $stmt->bindParam(':subjectname', $this->subjectname);
        $stmt->bindParam(':teacherid', $this->teacherid);
        $stmt->bindParam(':classid', $this->classid);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    //GET all Subjects
    public function read(){
        //create query
        $query = 'SELECT 
            id,
            subjectname,
            teacherid,
            classid
           FROM
            ' .$this->table. '
            ORDER BY
                id DESC';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function update(){

        $result = $this->getSubject($this->subjectname);
        //Get row count
        $num = $result->rowCount();

        if ($num>0){
            return false;
        }else{
            $query = 'UPDATE '
                .$this->table. '
                SET 
                    subjectname = :subjectname,
                    teacherid = :teacherid,
                    classid = :classid
                      
                WHERE
                
                     id = :id';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->subjectname = htmlspecialchars(strip_tags($this->subjectname));
            $this->teacherid = htmlspecialchars(strip_tags($this->teacherid));
            $this->classid = htmlspecialchars(strip_tags($this->classid));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':subjectname', $this->subjectname);
            $stmt->bindParam(':teacherid', $this->teacherid);
            $stmt->bindParam(':classid', $this->classid);
            $stmt->bindParam(':id', $this->id);

            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

    public function archiveOrRemoveSubject(){
        $database = new Database();
        $db = $database->connect();

        $subjects = new Subjects($db);

        $result = $subjects->getTest('testinfo',$this->id);
        //Get row count
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
            
            WHERE sub.id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1,$this->id);
            $stmt->execute();


            //delete testwithgrade
            //$dltTsgQuery = 'DELETE FROM testwithgrade WHERE testid=(SELECT id FROM testinfo WHERE subjectid=(SELECT id FROM subjectinfo WHERE id=:subjectid))';

            $dltTsgQuery = 'DELETE testwithgrade FROM  testwithgrade INNER JOIN testinfo ON testwithgrade.testid = testinfo.id INNER JOIN subjectinfo ON subjectinfo.id = testinfo.subjectid WHERE subjectinfo.id = :subjectid';
            //prepare statement
            $tsgstmt = $this->conn->prepare($dltTsgQuery);
            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $tsgstmt->bindParam(':subjectid', $this->id);
            $tsgstmt->execute();

            //delete testinfo
            $dltTestinfoquery = 'DELETE FROM testinfo 
                    WHERE subjectid = :subjectid';
            //prepare statement
            $tsstmt = $this->conn->prepare($dltTestinfoquery);
            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $tsstmt->bindParam(':subjectid', $this->id);
            $tsstmt->execute();

            //delete subject
            $dltSubjectquery = 'DELETE FROM subjectinfo 
                    WHERE id = :id';
            //prepare statement
            $substmt = $this->conn->prepare($dltSubjectquery);
            //Clean id
            $this->id = htmlspecialchars(strip_tags($this->id));
            //Bind id
            $substmt->bindParam(':id', $this->id);

            if ($substmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;


        }elseif($num==0){
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
        }else{
            return false;
        }
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

    public function getSubjectWithTeacherAndClass(){
        $query = 'SELECT 
            sub.id as subjectid,
            sub.subjectname as subjectname,
            cls.id as classid,
            cls.classname as classname,
            tch.id as teacherid,
            tch.username as teacherusername
            FROM subjectinfo sub INNER JOIN classinfo cls
            ON cls.id = sub.classid
            INNER JOIN userinfo tch
            ON tch.id = sub.teacherid
            ';

        $stmt = $this->conn->prepare($query);

        //$stmt->bindParam(1,$this->classid);

        $stmt->execute();

        return $stmt;
    }

    public function getSubjectWithTeacherAndClassForOneTeacher($teacherId){
        $query = 'SELECT 
            sub.id as subjectid,
            sub.subjectname as subjectname,
            cls.id as classid,
            cls.classname as classname,
            tch.id as teacherid,
            tch.username as teacherusername
            FROM subjectinfo sub INNER JOIN classinfo cls
            ON cls.id = sub.classid
            INNER JOIN userinfo tch
            ON tch.id = sub.teacherid
            WHERE sub.teacherid = :teacherid';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam("teacherid",$teacherId);

        $stmt->execute();

        return $stmt;
    }

    public function getSubjectName($id){
        $query = "select subjectname from subjectinfo where id = '".$id."'";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }


    public function getSubject($name){
        $query = "select * from subjectinfo where subjectname = '".$name."'";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

//getTest('testwithgrade',$this->studentid)
    public function getTest($tablename, $subjectid){
        $query = "select id from ".$tablename." where subjectid = '".$subjectid."'";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }




}
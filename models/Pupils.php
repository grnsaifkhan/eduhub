<?php


class Pupils
{
    private $conn;
    private $table = 'testwithgrade';


    //properties
    public $id;
    public $grade;
    public $testid;
    public $studentusername;
    public $subjectid;

    //contructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    public function readAllSubject(){
        $query = 'SELECT 
            ts.testname as testname,
            sub.subjectname as subjectname,
            cls.classname as classname,
            tsg.grade as grade
            FROM testinfo ts INNER JOIN testwithgrade tsg
            ON ts.id = tsg.testid
            INNER JOIN subjectinfo sub
            ON sub.id = ts.subjectid
            INNER JOIN classinfo cls
            ON cls.id = sub.classid
            
            WHERE tsg.studentusername = ?
            ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->studentusername);

        $stmt->execute();

        return $stmt;
    }

    public function readSingleSubject(){
        $query = 'SELECT 
            ts.testname as testname,
            sub.subjectname as subjectname,
            cls.classname as classname,
            tsg.grade as grade
            FROM testinfo ts INNER JOIN testwithgrade tsg
            ON ts.id = tsg.testid
            INNER JOIN subjectinfo sub
            ON sub.id = ts.subjectid
            INNER JOIN classinfo cls
            ON cls.id = sub.classid
            
            WHERE tsg.studentusername = ? AND ts.subjectid = ?
            ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->studentusername);
        $stmt->bindParam(2,$this->subjectid);

        $stmt->execute();

        return $stmt;
    }

    public function getAllSubjectAlongWithAvgTestGrade($studentusername){
        $query = 'SELECT
            sub.id as subjectid,
            sub.subjectname as subjectname,
            ROUND(AVG (tsg.grade),2) as averagegrade
            FROM testwithgrade tsg INNER JOIN testinfo ts
            ON ts.id = tsg.testid
            INNER JOIN subjectinfo sub
            ON sub.id = ts.subjectid
            INNER JOIN classwithstudent cws
            ON cws.classid = sub.classid
            
            WHERE tsg.studentusername = :studentusername
            GROUP BY ts.subjectid
            ';

        $stmt = $this->conn->prepare($query);

        //$stmt->bindParam(':studentusername',$studentUsername);
        $stmt->bindParam(':studentusername',$studentusername);

        $stmt->execute();

        return $stmt;
    }

    public function getAllArchivedSubjectAlongWithAvgTestGrade($studentusername){
        $query = 'SELECT
            avs.subjectname as subjectname,
            ROUND(AVG (avs.grade),2) as averagegrade,
            avs.testname as testname
            FROM archivedsubject avs 
            WHERE avs.studentusername = :studentusername 
            GROUP BY avs.subjectname
            ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':studentusername',$studentusername);

        $stmt->execute();

        return $stmt;
    }

    public function readSingleArchivedSubject($subjectname,$studentusername){
        $query = 'SELECT
            avs.subjectname as subjectname,
            avs.grade as grade,
            avs.testname as testname
            FROM archivedsubject avs 
            WHERE avs.studentusername = :studentusername AND subjectname = :subjectname
            ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':subjectname',$subjectname);
        $stmt->bindParam(':studentusername',$studentusername);

        $stmt->execute();

        return $stmt;
    }


}
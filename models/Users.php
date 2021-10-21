<?php


class Users
{
    private $conn;
    private $table = 'userinfo';

    //properties
    public $id;
    public $usertype;
    public $firstname;
    public $lastname;
    public $username;
    public $password;

    //contructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    //create user
    public function create(){
        $result = $this->getUserdataWhere($this->username);
        $userNum = $result->rowCount();

        if ($userNum > 0){
            return false;
        }else{
            $query = 'INSERT INTO '
                .$this->table. '
                SET 
                    usertype = :usertype,
                    firstname = :firstname,
                    lastname = :lastname,
                    username = :username,
                    password = :password';

            //prepare statement
            $stmt = $this->conn->prepare($query);
            $password = md5($this->password);

            //Clean data
            $this->usertype = htmlspecialchars(strip_tags($this->usertype));
            $this->firstname = htmlspecialchars(strip_tags($this->firstname));
            $this->lastname = htmlspecialchars(strip_tags($this->lastname));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($password));

            //bind data
            $stmt->bindParam(':usertype', $this->usertype);
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $password);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

    //GET all users
    public function read($userid){
        //get query
        $query = 'SELECT 
            id,
            usertype,
            firstname,
            lastname,
            username
           FROM
            ' .$this->table. '
            WHERE id != :userid';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':userid',$userid);
        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function readSingleId(){
        //create query
        $query = 'SELECT 
            id,
            usertype,
            firstname,
            lastname,
            username
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

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }


    //Update User
    public function update(){
        $query = 'UPDATE '
            .$this->table. '
                SET 
                    firstname = :firstname,
                    lastname = :lastname
                    
                WHERE
                    id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }


    //Delete user
    public function delete(){

        $result = $this->searchTeachersAvailability($this->id);
        $teacherNum = $result->rowCount();

        if ($teacherNum>0){
            return false;
        }else{
            $resultStd = $this->checkStudentship($this->id);
            //$stdNum = $resultStd->rowCount();
            foreach($resultStd as $data){
                $studenttype = $data['usertype'];
            }

            if ($studenttype == 'student'){
                //$query = 'DELETE FROM testwithgrade WHERE id = :id';
                $queryTsg = 'DELETE FROM testwithgrade WHERE studentusername = (SELECT username FROM userinfo WHERE id= :studentid)';
                $stmt = $this->conn->prepare($queryTsg);
                //Clean id
                $this->id = htmlspecialchars(strip_tags($this->id));

                //Bind id
                $stmt->bindParam(':studentid', $this->id);
                $stmt->execute();

                $query = "DELETE FROM userinfo WHERE id = '".$this->id."'";
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
    }

    public function readSinglePupilWithUsername(){
        //create query
        $query = 'SELECT 
            id,
            usertype,
            firstname,
            lastname,
            username
           FROM
            ' .$this->table. '
            WHERE username = ?';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind Teacher ID
        $stmt->bindParam(1,$this->username);

        //Execute query
        $stmt->execute();

        return $stmt;

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }


    public function getAllTeacher(){
        //get query
        $query = 'SELECT 
            id,
            usertype,
            firstname,
            lastname,
            username
           FROM
            ' .$this->table. '
            WHERE usertype = "teacher"';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function getAllStudent(){
        //get query
        $query = 'SELECT 
            id,
            usertype,
            firstname,
            lastname,
            username
           FROM
            ' .$this->table. ' 
            WHERE usertype = "student"';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function login(){
        $query = 'SELECT id,usertype, username, firstname, lastname FROM userinfo WHERE username = :username AND password = :password';

        $stmt = $this->conn->prepare($query);
        $password = md5($this->password);
        $stmt->bindParam(":username",$this->username);
        $stmt->bindParam(":password",$password);

        $stmt->execute();

        return $stmt;
    }

    public function searchTeachersAvailability($teacherid){
        $query = "select * from subjectinfo where teacherid = '".$teacherid."'";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->id);

        $stmt->execute();

        return $stmt;
    }

    public function checkStudentship($userid){
        $query = "select usertype from userinfo where id = '".$userid."'";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->id);

        $stmt->execute();

        return $stmt;

    }

    public function getUserdataWhere($username){
        $query = "select * from userinfo where username = '".$username."'";

        $stmt = $this->conn->prepare($query);

        //$stmt->bindParam(1,$this->id);

        $stmt->execute();

        return $stmt;
    }





}
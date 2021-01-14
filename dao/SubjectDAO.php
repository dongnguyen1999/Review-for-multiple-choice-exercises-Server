<?php
include_once ("../model/SubjectModel.php");

class SubjectDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM subject WHERE subjectId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new SubjectModel($res->fetch_assoc());
        } else return null;
    }

    public static function findAll(){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM subject";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new SubjectModel($row));
        }
        return $data;
    }

}
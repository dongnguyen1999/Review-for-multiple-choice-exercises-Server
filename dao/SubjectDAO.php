<?php
include_once ("../model/SubjectModel.php");
include_once ("../dao/MajorDAO.php");

class SubjectDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM SUBJECT WHERE subjectId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new SubjectModel($res->fetch_assoc());
        } else return null;
    }

    public static function findByIds($ids){
        global $conn;
        $data = array();
        
        foreach ($ids as $id) {
            array_push($data, SubjectDAO::findById($id));
        } 

        return $data;
    }

    public static function findByMajorId($majorId){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM SUBJECT WHERE majorId = '$majorId'";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new SubjectModel($row));
        }
        return $data;
    }

    public static function findByFacultyId($facultyId){
        global $conn;

        $data = array();

        $majors = MajorDAO::findByFacultyId($facultyId);

        foreach ($majors as $major) {
            $data = array_merge($data, SubjectDAO::findByMajorId($major->majorId));
        }

        return $data;
    }

    public static function findAll(){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM SUBJECT";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new SubjectModel($row));
        }
        return $data;
    }

}
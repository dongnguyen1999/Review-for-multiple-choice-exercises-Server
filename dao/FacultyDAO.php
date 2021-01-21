<?php
include_once ("../model/FacultyModel.php");
include_once ("../dao/MajorDAO.php");
include_once ("../dao/SubjectDAO.php");

class FacultyDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM FACULTY WHERE facultyId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new FacultyModel($res->fetch_assoc());
        } else return null;
    }

    public static function findBySubjectId($id){
        global $conn;

        $subject = SubjectDAO::findById($id);
        $major = MajorDAO::findById($subject->majorId);
        return FacultyDAO::findById($major->facultyId);
    }

    public static function findAll(){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM FACULTY";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new FacultyModel($row));
        }
        return $data;
    }

}
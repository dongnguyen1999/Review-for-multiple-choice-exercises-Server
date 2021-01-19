<?php
include_once ("../model/MajorModel.php");

class MajorDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM MAJOR WHERE majorId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new MajorModel($res->fetch_assoc());
        } else return null;
    }

    public static function findAll(){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM MAJOR";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new MajorModel($row));
        }
        return $data;
    }

    public static function findByFacultyId($facultyId) {
        global $conn;
        $data = array();
        $sql = "SELECT * FROM MAJOR WHERE facultyId = '$facultyId'";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new MajorModel($row));
        }
        return $data;
    }

}
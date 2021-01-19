<?php
include_once("../dao/dbconnect.php");
include_once("../dao/FacultyDAO.php");
include_once("../model/ResponseData.php");
//url: http://hostname/api/faculty.php
//GET
//{
//    'type': 'list',
//
//    //Optional
//    'facultyId': '1' // Get one faculty info with its id
//}

//Get list of all subjects or get one subject detail
if(isset($_GET['type']) && $_GET['type'] == "list") {
    $data = array();

    if (isset($_GET['facultyId'])) {
        $facultyId = $_GET['facultyId'];
        $data = FacultyDAO::findById($facultyId);
    } else {
        $data = FacultyDAO::findAll();
    }

    echo ResponseData::ResponseSuccess('Truy vấn khoa thành công', $data);
}


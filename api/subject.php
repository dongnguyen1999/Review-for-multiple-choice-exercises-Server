<?php
include_once("../dao/dbconnect.php");
include_once("../dao/SubjectDAO.php");
include_once("../model/ResponseData.php");
//url: http://hostname/api/subject.php
//GET
// {
//    'type': 'list',

//    //Optional
//    'subjectId': '1' // Get one subject info with its id
//    'majorId': '1' // List all subject in a major
//    'facultyId': '1' // List all subjec in a faculty
// }

//Get list of all subjects or get one subject detail
if(isset($_GET['type']) && $_GET['type'] == "list") {
    $data = array();

    if (isset($_GET['subjectId'])) {
        $subjectId = $_GET['subjectId'];
        $data = SubjectDAO::findById($subjectId);
    } else if (isset($_GET['majorId'])) {
        $majorId = $_GET['majorId'];
        $data = SubjectDAO::findByMajorId($majorId);
    } else if (isset($_GET['facultyId'])) {
        $facultyId = $_GET['facultyId'];
        $data = SubjectDAO::findByFacultyId($facultyId);
    }
    else {
        $data = SubjectDAO::findAll();
    }

    echo ResponseData::ResponseSuccess('Truy vấn môn học thành công', $data);
}


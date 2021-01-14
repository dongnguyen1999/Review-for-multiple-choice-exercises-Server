<?php
include_once("../dao/dbconnect.php");
include_once("../dao/SubjectDAO.php");
include_once("../model/ResponseData.php");
//url: http://hostname/api/subject.php
//GET
//{
//    'type': 'list',
//
//    //Optional
//    'subjectId': '1' // Get one subject info with its id
//}

//Get list of all subjects or get one subject detail
if(isset($_GET['type']) && $_GET['type'] == "list") {
    $data = array();

    if (isset($_GET['subjectId'])) {
        $subjectId = $_GET['subjectId'];
        $data = SubjectDAO::findById($subjectId);
    } else {
        $data = SubjectDAO::findAll();
    }

    echo ResponseData::ResponseSuccess('Truy vấn môn học thành công', $data);
}


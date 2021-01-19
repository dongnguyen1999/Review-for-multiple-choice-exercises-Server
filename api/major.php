<?php
include_once("../dao/dbconnect.php");
include_once("../dao/MajorDAO.php");
include_once("../model/ResponseData.php");
//url: http://hostname/api/major.php
//GET
// {
//    'type': 'list',

//    //Optional
//    'majorId': '1', // Get one major info with its id
//    'facultyId': '1', // List all major in a faculty
// }

//Get list of all subjects or get one subject detail
if(isset($_GET['type']) && $_GET['type'] == "list") {
    $data = array();
    if (isset($_GET['majorId'])) {
      $majorId = $_GET['majorId'];
      $data = MajorDAO::findById($majorId);
    } else if (isset($_GET['facultyId'])) {
        $facultyId = $_GET['facultyId'];
        $data = MajorDAO::findByFacultyId($facultyId);
    } else {
        $data = MajorDAO::findAll();
    }

    echo ResponseData::ResponseSuccess('Truy vấn ngành học thành công', $data);
}


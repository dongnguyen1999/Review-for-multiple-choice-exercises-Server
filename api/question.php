<?php
include_once("../dao/dbconnect.php");
include_once("../dao/QuestionDAO.php");
include_once("../model/ResponseData.php");

//url: http://hostname/api/question.php
//GET
//{
//    "type": "list",
//
//    //Optional
//    //Give just one of below
//    'questionId': '1', //get info one question by its id
//    "subjectId":"1", // list all question of a subject
//    "examId": "2", // list all question of an exam
//}

if(isset($_GET['type']) && $_GET['type'] == "list") {
    $data = array();
    if (isset($_GET['questionId'])) { // request with question id
        $questionId = trim($_GET['questionId']);
        $data = QuestionDAO::findById($questionId);
    } else if (isset($_GET['subjectId'])) { // request with subject id
        //select question by subject id
        $subjectId = trim($_GET['subjectId']);
        $data = QuestionDAO::findAllBySubjectId($subjectId);
    } else if (isset($_GET['examId'])) { // request with exam id
        //select question by exam id
        $examId = trim($_GET['examId']);
        $data = QuestionDAO::findAllByExamId($examId);
    } else { // select all question in database
        $data = QuestionDAO::findAll();
    }

    echo ResponseData::ResponseSuccess('Truy vấn câu hỏi thành công', $data);
}
 
 ?>



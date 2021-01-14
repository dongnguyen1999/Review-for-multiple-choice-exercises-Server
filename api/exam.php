<?php
include_once("../dao/dbconnect.php");
include_once("../dao/ExamDAO.php");
include_once("../model/ResponseData.php");
include_once("../model/TaskModel.php");

session_start();

//url: http://hostname/api/exam.php
//GET
//{
//    "type": "list",
//
//    //Optional
//    //Give just one of below
//    'userId': '1', // Get exam detail by owner user
//    'examId': '1', //Get one exam detail by its id
//    //Else all exam
//}

// List all exam detail: by id, by userid, all
if(isset($_GET['type']) && $_GET['type'] == "list") {
    $data = array();

    if (isset($_GET['examId'])) {
        //select one exam by its id
        $examId = $_GET['examId'];
        $data = ExamDAO::findById($examId);
    } else if (isset($_GET['userId'])) {
        // list all exam of user by userid
        $userId = $_GET['userId'];
        $data = ExamDAO::findAllByUserId($userId);
    } else {
        // list all exam
        $data = ExamDAO::findAll();
    }

    echo ResponseData::ResponseSuccess('Truy vấn bài kiểm tra thành công', $data);

}

//url: http://hostname/api/exam.php
//POST
//{
//    "type": "openNew",
//    'subjectId': '1', //subject of the new exam
//
//    //Optional
//    'duration': '45', // Duration of the new exam, duration is nullable
//}

// Create a new exam with fixed number of question of a subject;
if(isset($_POST['type']) && $_POST['type'] == "openNew") {
    try {
        if (isset($_SESSION['email'])) {
            //Select userId by email
            $email = $_SESSION['email'];
            $user = UserDAO::findByEmail($email);

            //Map request data from $_POST
            $exam = new ExamModel($_POST);
            $exam->userId = $user->userId; //add userId - this exam's owner
            $exam = ExamDAO::openNew($exam); //open exam with request data
            if ($exam != null) {
                echo ResponseData::ResponseSuccess('Tạo bài kiểm tra mới thành công', $exam);
            } else {
                echo ResponseData::ResponseFail("Lỗi tạo bài kiểm tra, vui lòng thử lại");
            }

        } else {
            ResponseData::ResponseFail("API yêu cầu người dùng đăng nhập");
        }
    } catch(Exception $e) {
        echo ResponseData::ResponseFail("Tạo bài kiểm tra thất bại: $e");
    }
}

//url: http://hostname/api/exam.php
//POST
//{
//    "type": "answerQuestion",
//    'examId': '1', // id of the exam will be changed
//    'questionId': '1', // id of question in exam will be answered
//    'answerTask': '1', // the user answer in [1,2,3,4]
//}

// Answer a question in an exam with 1,2,3,4 as answer

if(isset($_POST['type']) && $_POST['type'] == "answerQuestion") {
    try {
        $task = new TaskModel($_POST);
        $task = ExamDAO::updateTask($task);
        if ($task != null){
            echo ResponseData::ResponseSuccess('Cập nhật câu trả lời thành công', $task);
        } else {
            echo ResponseData::ResponseFail("Câu hỏi đang trả lời không nằm trong bài kiểm tra");
        }
    } catch(Exception $e) {
        echo ResponseData::ResponseFail("Xảy ra lỗi trong quá trình cập nhật câu trả lời: $e");
    }
}

//url: http://hostname/api/exam.php
//POST
//{
//    "type": "submit",
//    'examId': '1', // id of the exam will be submitted
//}

// Submit the exam and compute score

if(isset($_POST['type']) && $_POST['type'] == "submit") {
    try {
        $examId = $_POST['examId'];

        $exam = ExamDAO::submit($examId);

        if ($exam != null) {
            echo ResponseData::ResponseSuccess('Nộp bài chấm điểm thành công', $exam);
        } else {
            echo ResponseData::ResponseFail("Có lỗi xảy ra trong quá trình nộp bài, vui lòng thử lại");
        }
    } catch(Exception $e) {
        echo ResponseData::ResponseFail("Xảy ra lỗi trong quá trình nộp bài: $e");
    }
}



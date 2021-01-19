<?php
include_once("../model/TaskModel.php");
include_once ("../model/QuestionModel.php");

class QuestionDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM QUESTION WHERE questionId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new QuestionModel($res->fetch_assoc());
        } else return null;
    }

    public static function findAll(){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM QUESTION";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new QuestionModel($row));
        }
        return $data;
    }

    public static function findAllBySubjectId($subjectId) {
        global $conn;
        $data = array();
        $sql = "SELECT * FROM QUESTION WHERE subjectId = '$subjectId'";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new QuestionModel($row));
        }
        return $data;
    }

    public static function findAllByExamId($examId) {
        global $conn;
        $data = array();
        $sql = "SELECT * FROM TASK WHERE examId = '$examId'";
        $res = $conn->query($sql);
        while ($row = $res->fetch_assoc()) { // for each row in task table selected where examid
            $task = new TaskModel($row);
            $questionId = $task->questionId;
            // select question detail info and push to $data
            $question = QuestionDAO::findById($questionId);
            $question->answerTask = $task->answerTask;
            array_push($data, $question);
        }
        return $data;
    }
}
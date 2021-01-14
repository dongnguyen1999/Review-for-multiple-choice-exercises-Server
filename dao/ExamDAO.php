<?php
include_once ("../model/ExamModel.php");
include_once ("../dao/UserDAO.php");
include_once ("../dao/QuestionDAO.php");

class ExamDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM exam WHERE examId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new ExamModel($res->fetch_assoc());
        } else return null;
    }

    public static function findAllByUserId($userId) {
        global $conn;
        $data = array();
        $sql = "SELECT * FROM exam WHERE userId = '$userId'";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new ExamModel($row));
        }
        return $data;
    }

    public static function findAll(){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM exam";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new ExamModel($row));
        }
        return $data;
    }

    // Insert new row to exam table
    public static function save($model) {
        global $conn;

        $sql = "INSERT INTO exam (USERID, CREATEDATE, DURATION) VALUES (%userId, current_timestamp(), %duration)";

        $sql = str_replace('%userId', "'$model->userId'", $sql);
        $sql = str_replace('%duration', $model->duration!=null? "'$model->duration'": "null", $sql);

        if ($conn->query($sql) === true) {
            $last_id = $conn->insert_id;
            return ExamDAO::findById($last_id);
        } else return null;
    }

    // Insert new row to exam table, random number of questions of subject (by subjectId), insert random questions to task table with answerTask = null
    public static function openNew($exam) {
        global $conn;
        $subjectId = $exam->subjectId;
        //Insert new exam
        $exam = ExamDAO::save($exam);

        if ($exam != null) {// insert new exam success
            $examId = $exam->examId;// last inserted exam id
            $nbQuestion = ExamModel::$NB_QUESTION;

            //Select list of question id randomly filter by subjectid
            $sql = "SELECT questionid FROM question WHERE subjectId='$subjectId' order by rand() limit $nbQuestion";
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {// for each questionid
                $questionId = $row['questionid'];
                // insert new row (examid, questionid, answertask = null ) to task: a question with user answer = null
                $sql = "INSERT INTO task (EXAMID, QUESTIONID) VALUES ('$examId', '$questionId')";
                $conn->query($sql);
            }
            $exam->subjectId = $subjectId;
            return $exam;
        }
        return null;
    }

    //Update existing task with new answerTask
    public static function updateTask($task) {
        global $conn;
        $answerTask = $task->answerTask;
        $examId = $task->examId;
        $questionId = $task->questionId;
        $sql = "UPDATE task SET answerTask = '$answerTask' WHERE examId = '$examId' AND questionId = '$questionId'";

        if ($conn->query($sql) === true) {// update task success
            $sql = "SELECT * FROM task WHERE examId = '$examId' AND questionId = '$questionId'";
            $res = $conn->query($sql);
            return new TaskModel($res->fetch_assoc());
        }
        return null;
    }

    //Compute score and update score in exam table
    public static function submit($examId) {
        global $conn;
        $questions = QuestionDAO::findAllByExamId($examId);
        $trueQuestionCount = 0;
        $unitScore = ExamModel::$MAX_SCORE / ExamModel::$NB_QUESTION; //score per true question

        foreach ($questions as $question) {
            if ($question->answer == $question->answerTask) {
                $trueQuestionCount++;
            }
        }

        $score = $unitScore * $trueQuestionCount;

        $sql = "UPDATE exam SET score = '$score' WHERE examId = '$examId'";

        if ($conn->query($sql) == true) {
            return ExamDAO::findById($examId);
        } else return null;
    }
}
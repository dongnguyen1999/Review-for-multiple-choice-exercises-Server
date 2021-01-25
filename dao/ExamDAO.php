<?php
include_once ("../model/ExamModel.php");
include_once ("../dao/UserDAO.php");
include_once ("../dao/QuestionDAO.php");
include_once ("../dao/FacultyDAO.php");
include_once ("../dao/SubjectDAO.php");

class ExamDAO
{
    public static function findById($id){
        global $conn;
        $sql = "SELECT * FROM EXAM WHERE examId = '$id'";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            return new ExamModel($res->fetch_assoc());
        } else return null;
    }

    public static function findAllByUserId($userId) {
        global $conn;
        $data = array();
        $sql = "SELECT * FROM EXAM WHERE userId = '$userId' ORDER BY createDate DESC";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $exam = new ExamModel($row);
            $faculty = FacultyDAO::findBySubjectId($exam->subjectId);
            $subject = SubjectDAO::findById($exam->subjectId);
            $exam->facultyName = $faculty->facultyName;
            $exam->subjectName = $subject->subjectName;
            array_push($data, $exam);
        }
        return $data;
    }

    public static function findAllByUserIdAndSubjectId($userId, $subjectId) {
        global $conn;
        $data = array();
        $sql = "SELECT * FROM EXAM WHERE userId = '$userId' AND subjectId = '$subjectId'";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new ExamModel($row));
        }
        return $data;
    }

    public static function findAll(){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM EXAM";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new ExamModel($row));
        }
        return $data;
    }

    public static function findAllBySubjectId($subjectId){
        global $conn;
        $data = array();
        $sql = "SELECT * FROM EXAM WHERE subjectId = '$subjectId'";
        $res = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, new ExamModel($row));
        }
        return $data;
    }

    // Insert new row to EXAM table
    public static function save($model) {
        global $conn;

        $sql = "INSERT INTO EXAM (userId, subjectId, createDate, closeDate, duration, nbQuestion) VALUES (%userId, %subjectId, current_timestamp(), current_timestamp() + INTERVAL %nbMinute MINUTE, %duration, %nbQuestion)";

        $sql = str_replace('%userId', "'$model->userId'", $sql);
        $sql = str_replace('%subjectId', "'$model->subjectId'", $sql);
        $sql = str_replace('%nbMinute', "$model->duration", $sql);
        $sql = str_replace('%duration', "'$model->duration'", $sql);
        $sql = str_replace('%nbQuestion', "'$model->nbQuestion'", $sql);

        if ($conn->query($sql) === true) {
            $last_id = $conn->insert_id;
            return ExamDAO::findById($last_id);
        } else return null;
    }

    // Insert new row to EXAM table, random number of questions of subject (by subjectId), insert random questions to task table with answerTask = null
    public static function openNew($exam) {
        global $conn;
        //Insert new exam
        $exam = ExamDAO::save($exam);

        if ($exam != null) {// insert new exam success
            $examId = $exam->examId;// last inserted exam id
            $nbQuestion = $exam->nbQuestion;
            $subjectId = $exam->subjectId;

            //Select list of question id randomly filter by subjectid
            $sql = "SELECT questionId FROM QUESTION WHERE subjectId='$subjectId' order by rand() limit $nbQuestion";
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {// for each questionid
                $questionId = $row['questionId'];
                // insert new row (examid, questionid, answertask = null ) to task: a question with user answer = null
                $sql = "INSERT INTO TASK (examId, questionId) VALUES ('$examId', '$questionId')";
                $conn->query($sql);
            }
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
        $sql = "UPDATE TASK SET answerTask = '$answerTask' WHERE examId = '$examId' AND questionId = '$questionId'";

        if ($conn->query($sql) === true) {// update task success
            $sql = "SELECT * FROM TASK WHERE examId = '$examId' AND questionId = '$questionId'";
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

        foreach ($questions as $question) {
            if ($question->answer == $question->answerTask) {
                $trueQuestionCount++;
            }
        }

        $sql = "UPDATE EXAM SET score = '$trueQuestionCount' WHERE examId = '$examId'";

        if ($conn->query($sql) == true) {
            return ExamDAO::findById($examId);
        } else return null;
    }

    public static function deleteById($examId) {
        global $conn;
        $sql = "DELETE FROM TASK WHERE examId = '$examId'";
        if ($conn->query($sql) == true) {
            $sql = "DELETE FROM EXAM WHERE examId = '$examId'";
            return ($conn->query($sql) == true);
        }
        return false;
    }


}
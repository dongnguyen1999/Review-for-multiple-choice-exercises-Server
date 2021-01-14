<?php


class ExamModel
{
    public $examId;
    public $userId;
    public $createDate;
    public $duration;
    public $score;
    public $subjectId;

    public static $MAX_SCORE;
    public static $NB_QUESTION;

    public function __construct($data) {
        $this->examId = isset($data['examId'])? $data['examId']: null;
        $this->userId = isset($data['userId'])? $data['userId']: null;
        $this->createDate = isset($data['createDate'])? $data['createDate']: time();
        $this->duration = isset($data['duration'])? $data['duration']: null;
        $this->score = isset($data['score'])? $data['score']: null;
        $this->subjectId = isset($data['subjectId'])? $data['subjectId']: null;
    }
}
ExamModel::$MAX_SCORE = 10;
ExamModel::$NB_QUESTION = 20;
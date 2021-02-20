<?php


class ExamModel
{
    public $examId;
    public $userId;
    public $subjectId;
    public $createDate;
    public $closeDate;
    public $duration;
    public $score;
    public $nbQuestion;
    public $isImportant;

    public function __construct($data) {
        $this->examId = isset($data['examId'])? $data['examId']: null;
        $this->userId = isset($data['userId'])? $data['userId']: null;
        $this->subjectId = isset($data['subjectId'])? $data['subjectId']: null;
        $this->createDate = isset($data['createDate'])? $data['createDate']: time();
        $this->closeDate = isset($data['closeDate'])? $data['closeDate']: time();
        $this->duration = isset($data['duration'])? $data['duration']: 1;
        $this->score = isset($data['score'])? $data['score']: null;
        $this->nbQuestion = isset($data['nbQuestion'])? $data['nbQuestion']: 20;
        $this->isImportant = isset($data['isImportant'])? $data['isImportant']: 0;
    }
}
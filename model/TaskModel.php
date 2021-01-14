<?php


class TaskModel
{
    public $examId;
    public $questionId;
    public $answerTask;

    public function __construct($data) {
        $this->examId = $data['examId'];
        $this->questionId = $data['questionId'];
        $this->answerTask = isset($data['answerTask'])? $data['answerTask']: null;
    }
}
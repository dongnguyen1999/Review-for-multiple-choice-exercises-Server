<?php


class QuestionModel
{
    public $questionId;
    public $questionName;
    public $subjectId;
    public $answer1;
    public $answer2;
    public $answer3;
    public $answer4;
    public $answer;

    public function __construct($data) {
        $this->questionId = $data['questionId'];
        $this->subjectId = $data['subjectId'];
        $this->questionName = $data['questionName'];
        $this->answer1 = $data['answer1'];
        $this->answer2 = $data['answer2'];
        $this->answer3 = $data['answer3'];
        $this->answer4 = $data['answer4'];
        $this->answer = $data['answer'];
    }

}
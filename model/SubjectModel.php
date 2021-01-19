<?php


class SubjectModel
{
    public $subjectId;
    public $subjectName;
    public $majorId;

    public function __construct($data) {
        $this->subjectId = $data['subjectId'];
        $this->subjectName = $data['subjectName'];
        $this->majorId = $data['majorId'];
    }

}
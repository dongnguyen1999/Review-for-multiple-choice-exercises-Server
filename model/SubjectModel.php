<?php


class SubjectModel
{
    public $subjectId;
    public $subjectName;

    public function __construct($data) {
        $this->subjectId = $data['subjectId'];
        $this->subjectName = $data['subjectName'];
    }

}
<?php


class MajorModel
{
    public $majorId;
    public $majorName;
    public $facultyId;

    public function __construct($data) {
        $this->majorId = $data['majorId'];
        $this->majorName = $data['majorName'];
        $this->facultyId = $data['facultyId'];
    }

}
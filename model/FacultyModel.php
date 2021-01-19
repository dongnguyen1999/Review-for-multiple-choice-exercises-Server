<?php


class FacultyModel
{
    public $facultyId;
    public $facultyName;

    public function __construct($data) {
        $this->facultyId = $data['facultyId'];
        $this->facultyName = $data['facultyName'];
    }

}
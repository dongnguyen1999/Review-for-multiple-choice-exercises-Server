<?php
 include_once("dbconnect.php");

 include_once("ResponseData.php");

//url: http://hostname/api/question.php
//GET
//{
//"subjectID":"mamon"
//}

 if(isset($_GET['type']) && $_GET['type'] == "ListQuestionSubject") {

         $subjectID = trim($_GET['subjectID']);
         $resultArr = array();
         $data = array();
        $sql = "SELECT * FROM question WHERE SUBJECTSID = '$subjectID'";
        $res = mysqli_query($conn,$sql);

        while ($row = mysqli_fetch_assoc($res)) {
            array_push($data, $row);
            
        }

       echo ResponseData::ResponseSuccess('List danh sách câu hỏi theo môn', $data);
  
 }

 if(isset($_GET['type']) && $_GET['type'] == "ListQuetstionByExam") {

    $resultArr = array();
    $data = array();
   $sql = "SELECT * FROM task inner join  exam  on exam.examID=task.examID inner join question  on question.questionID=task.questionID ";
   $res = mysqli_query($conn,$sql);

   while ($row = mysqli_fetch_assoc($res)) {
       array_push($data, $row);
       
   }

  echo ResponseData::ResponseSuccess('List danh sách câu hỏi theo môn', $data);

}
 
 ?>



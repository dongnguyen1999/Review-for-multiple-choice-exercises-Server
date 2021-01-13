<?php
 include_once("dbconnect.php");

 include_once("ResponseData.php");
 
 //url: http://hostname/api/subject.php
//GET
//{
//"subjectID":"mamon"
//}
 if(isset($_GET['type']) && $_GET['type'] == "Listsubject") {


$resultArr = array();
$data = array();
$sql = "SELECT * FROM subject";
$res = mysqli_query($conn,$sql);

while ($row = mysqli_fetch_assoc($res)) {
   array_push($data, $row);
   
}

echo ResponseData::ResponseSuccess('List danh sách môn', $data);

}
?>
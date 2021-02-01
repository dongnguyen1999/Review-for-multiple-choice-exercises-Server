<?php
include_once("../model/ResponseData.php");

// url: http://hostname/api/chatbit.php
// POST - formdata
// {
//     userId: "1", //sender id
//     message: "Chào bạng", //User message
// }

// Send a user message and get response text from chatbot

try {

    $userId = $_POST['userId'];
    $message = $_POST['message'];

    $data = array('sender' => $userId, 'message' => $message);

    // API URL
    $url = 'http://localhost:5005/webhooks/rest/webhook';

    // Create a new cURL resource
    $ch = curl_init($url);

    $payload = json_encode($data);

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    // Return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the POST request
    $result = json_decode(curl_exec($ch));

    // Close cURL resource
    curl_close($ch);

    if (count($result) != 0) {
        $result = json_decode(json_encode($result[0]), true);
        $response = array();
        $response['recipientId'] = $result['recipient_id'];
        $response['response'] = $result['text'];
        echo ResponseData::ResponseSuccess("Phản hồi từ chatbot", $response);
    } else {
        echo ResponseData::ResponseFail("Thông điệp yêu cầu không rõ ràng");
    }


} catch(Exception $e) {
    echo ResponseData::ResponseFail("Chatbot hiện không hoạt động: $e");
}



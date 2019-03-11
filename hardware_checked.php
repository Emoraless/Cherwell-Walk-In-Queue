<?php

require "..\Includes\Connection.php";
require "..\Includes\QuickTicketApi.php";

$conn = new Connection('db');
$quick = new quickTicketAPI($conn);

$token = $quick->requestToken();

$headers = array(
  "Authorization: Bearer $token",
  "Content-Type: application/json"
);
//Sets array of headers
$fields = array(
  'busObId' 	=> 'ID',
  'includeAllFields' 	=> FALSE,
  //'pageSize' => 10000,
  'fields' 	=> array(
    "ID"
  ),
  'filters' => array(
    array(
      'fieldId' => 'ID',
      'operator' => 'eq',
      'value' => ''
    ),
    array(
      'fieldId' => 'ID',
      'operator' => 'eq',
      'value' => 'Hardware Check-in'
      )
    )
  );

$fieldsJSON = json_encode($fields);

$ch = curl_init('URL');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsJSON);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

//Gets the response
$cherwellApiResponse = json_decode($result, TRUE);

//print_r($cherwellApiResponse);

//if request not empty, interpret
$totalRows = $cherwellApiResponse['totalRows'];

$hardware = 0;
for($i = 0; $i < $totalRows; $i++)
{
  $status = $cherwellApiResponse['businessObjects'][$i]['fields'][0]['value'];
  if($status != "Resolved")
  {
      $hardware += 1;
  }
}

echo json_encode($hardware);
?>

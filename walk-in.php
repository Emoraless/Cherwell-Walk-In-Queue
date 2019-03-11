<?php
header('refresh:15; url=walk-in.php');

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
    "ID",               //Incident number
    "ID",               //Status
    "ID",               //Date created
    "ID",               //Location
    "ID",               //Full name
    "ID"                //Short description
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
      'value' => 'Walk-In Support'
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

$info = array();
$incidents = array();
$final = array();
$count = 0;
for($i = 0; $i < $totalRows; $i++)
{
  $status = $cherwellApiResponse['businessObjects'][$i]['fields'][1]['value'];
  $location = $cherwellApiResponse['businessObjects'][$i]['fields'][3]['value'];
  if($status != "Resolved" && $location == "Engineering Lab")
  {
    $incidents[] = $cherwellApiResponse['businessObjects'][$i]['fields'][0]['value'];
      $info['incident'][$count]['value'] = $cherwellApiResponse['businessObjects'][$i]['fields'][0]['value'];
      $info['incident'][$count]['fields'][0]['value'] = $cherwellApiResponse['businessObjects'][$i]['fields'][1]['value'];
      $info['incident'][$count]['fields'][1]['value'] = $cherwellApiResponse['businessObjects'][$i]['fields'][2]['value'];
      $info['incident'][$count]['fields'][2]['value'] = $cherwellApiResponse['businessObjects'][$i]['fields'][3]['value'];
      $info['incident'][$count]['fields'][3]['value'] = $cherwellApiResponse['businessObjects'][$i]['fields'][4]['value'];
      $info['incident'][$count]['fields'][4]['value'] = $cherwellApiResponse['businessObjects'][$i]['fields'][5]['value'];
      $info['incident'][$count]['fields'][5]['value'] = $cherwellApiResponse['businessObjects'][$i]['busObRecId'];
      $count++;
  }
}

sort($incidents, SORT_NATURAL | SORT_FLAG_CASE);
for($a = 0; $a < $count; $a++) {
  for($aa = 0; $aa < $count; $aa++) {
    if ($incidents[$a]==$info['incident'][$aa]['value']) {
      $final[] = $incidents[$a];
      $final[] = $info['incident'][$aa]['fields'][0]['value'];
      $final[] = $info['incident'][$aa]['fields'][1]['value'];
      $final[] = $info['incident'][$aa]['fields'][2]['value'];
      $final[] = $info['incident'][$aa]['fields'][3]['value'];
      $final[] = $info['incident'][$aa]['fields'][4]['value'];
      $final[] = $info['incident'][$aa]['fields'][5]['value'];
    }
  }
}
echo json_encode($final);
?>

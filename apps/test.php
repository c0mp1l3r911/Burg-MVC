<?php
$data = array(
	"id" => "uniqu1e123", 
	"name" => "chuck amoabile", 
	"manu" => "Dell", 
	"manu_id_s" => "Delly", 
	"cat" => array('string1', 'string2'), 
	"features" => array('some features'), 
	"includes" => "USB cable", 
	"weight" => 401.6, 
	"price" => 2199.0, 
	"price_c" => "2199,USD", 
	"popularity" => 5, 
	"inStock" => true, 
	"store" => "43.17614,-90.57345");


// $data = json_encode($data);
// $data = json_decode($data);

$data_string = json_encode(array($data));

$ch = curl_init('http://localhost:8983/solr/update?commit=true');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);

curl_close($ch);
var_export($result);

/*
<doc>
    <str name="id">3007WFP</str>
    <str name="name">Dell Widescreen UltraSharp 3007WFP</str>
    <str name="manu">Dell, Inc.</str>
    <str name="manu_id_s">dell</str>
    <arr name="cat">
      <str>electronics</str>
      <str>monitor</str>
    </arr>
    <arr name="features">
      <str>30" TFT active matrix LCD, 2560 x 1600, .25mm dot pitch, 700:1 contrast</str>
    </arr>
    <str name="includes">USB cable</str>
    <float name="weight">401.6</float>
    <float name="price">2199.0</float>
    <str name="price_c">2199,USD</str>
    <int name="popularity">6</int>
    <bool name="inStock">true</bool>
    <str name="store">43.17614,-90.57341</str>
    <long name="_version_">1452573619666288640</long></doc>
 */
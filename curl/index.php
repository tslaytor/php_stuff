<?php

// file_get_contents() is sometimes blocked on some urls by security policies
// you also can't use file_get_contents() if you want to add additional headers
// or post some additional information
// that's where cURL comes in

$url = 'https://jsonplaceholder.typicode.com/users';
// Sample example to get data.
// $resource = curl_init($url);
// Get response status code
// curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
// $result = curl_exec($resource);

// $info = curl_getinfo($resource, CURLINFO_HTTP_CODE);
// curl_close($resource);

// echo '<pre>';
// var_dump($info);
// echo '</pre>';
// echo $result;
// set_opt_array

// Post request
$user = [
    'name' => 'John Smith',
    'username' => 'jonny',
    'email' => 'john@example.com'
];

// HERE WE ARE MAKING A POST
$resource = curl_init($url);
curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
curl_setopt($resource, CURLOPT_POST, true);
curl_setopt($resource, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // HTTPHEADER MUST BE IN ARRAY
curl_setopt($resource, CURLOPT_POSTFIELDS, json_encode($user));

// ANOTHER WAY TO DO IT IS WITH curl_setopt_array();
// curl_setopt_array($resource, [
//     // CURLOPT_URL => $url,
//     // CURLOPT_RETURNTRANSFER => true,
//     // CURLOPT_POST => true,
//     // CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
//     // CURLOPT_POSTFIELDS => json_encode($user)
// ]);
$result = curl_exec($resource);
curl_close($resource);
echo $result;
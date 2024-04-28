<?php

// function connect_to_database()
// {
//     $conn_details = [
//         "host" => "localhost",
//         "user" => "u916687219_swiftpips",
//         "password" => "u916687219_Swiftpips",
//         "database" => "u916687219_swiftpips",
//         "port" => "3308"
//     ];

//     $connection = new mysqli(
//         $conn_details["host"],
//         $conn_details["user"],
//         $conn_details["password"],
//         $conn_details["database"],
//         $conn_details["port"]
//     );

//     return $connection;
// }


function connect_to_database()
{
    $conn_details = [
        "host" => "localhost",
        "user" => "root",
        "password" => "",
        "database" => "s-code",
        "port" => "3308"
    ];

    $connection = new mysqli(
        $conn_details["host"],
        $conn_details["user"],
        $conn_details["password"],
        $conn_details["database"],
        $conn_details["port"]
    );

    return $connection;
}

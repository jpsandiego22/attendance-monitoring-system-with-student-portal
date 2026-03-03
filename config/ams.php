<?php

// BUSINESS LOGIC

return [

// 0 = Administrator
// 1 = Faculty
// 2 = Student
'loginAccess' => [
        'admin' => 0,
        'faculty' => 1,
        'student' => 2,
        ],
'pageAccess' => [
        'admin' => 0,
        'faculty' => 1,
        'student' => 2,
        'admin-faculty' => [0,1],
        'all' => [0,1,2]
        ],
'dataAccess' => [
        'admin' => [0,1,2],
        'faculty' => [1,2],
        'student' => [2],
        ]
];
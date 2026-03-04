<?php

// BUSINESS LOGIC

return [

// 0 = Administrator
// 1 = Management
// 2 = User
'loginAccess' => [
        'admin' => 0,
        'management' => 1,
        'user' => 2,
        ],
'pageAccess' => [
        'admin' => 0,
        'management' => 1,
        'user' => 2,
        'admin-management' => [0,1],
        'all' => [0,1,2]
        ],
'dataAccess' => [[0,1,2], [2],[2]]
];
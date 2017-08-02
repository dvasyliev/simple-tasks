<?php

return array(
    "admin" => array(
        "path" => "account",
        "controller" => "account",
        "action" => "index",
    ),

    "tasks" => array(
        "path" => "task",
        "controller" => "task",
        "action" => "index",
    ),
    "tasks/add" => array(
        "path" => "task",
        "controller" => "task",
        "action" => "add",
    ),
    "tasks/update" => array(
        "path" => "task",
        "controller" => "task",
        "action" => "update",
    ),
    "tasks/delete" => array(
        "path" => "task",
        "controller" => "task",
        "action" => "delete",
    ),

    "page404" => array(
        "path" => "error",
        "controller" => "page404",
        "action" => "index",
    )
);
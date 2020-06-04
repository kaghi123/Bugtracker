<?php

function printUserTable($fname, $lname, $email, $type, $project_name, $createdate){
    echo "<tr>
            <td>$fname $lname</td>
            <td>$email</td>
            <td>$type</td>
            <td>$project_name</td>
            <td>$createdate</td>
            </tr>";
}

function printBugsTable($title, $project, $status, $comments, $type, $priority, $screenshot, $start_date, $deadline, $developer){
    echo "<tr>
            <td>$title</td>
            <td>$project</td>
            <td>$status</td>
            <td>$comments</td>
            <td>$type</td>
            <td>$priority</td>
            <td><a target='_blank' href='images/$screenshot' ><img src='images/$screenshot' width='150' height='70'><a/></td>
            <td>$start_date</td>
            <td>$deadline</td>
            <td>$developer</td>
            </tr>";
}

function printProjectsTable($name, $project_manager, $description, $status, $developer_num, $bug_num){
    echo "<tr>
            <td>$name</td>
            <td>$project_manager</td>
            <td>$description</td>
            <td>$status</td>
            <td>$developer_num</td>
            <td>$bug_num</td>
            </tr>";
}

function printMyProjectsTable($name, $project_manager, $description, $status, $developer_num, $bug_num){
    echo "<tr>
            <td>$name</td>
            <td>$project_manager</td>
            <td>$description</td>
            <td>$status</td>
            <td>$developer_num</td>
            <td>$bug_num</td>
            <td><a href='projectedit.php'>Edit</a><hr><a href='projectdelete.php'>Delete</a></td>
            </tr>";
}

function printMyBugsTable($title, $project, $status, $comments, $type, $priority, $screenshot, $start_date, $deadline, $developer){
    echo "<tr>
            <td>$title</td>
            <td>$project</td>
            <td>$status</td>
            <td>$comments</td>
            <td>$type</td>
            <td>$priority</td>
            <td><a target='_blank' href='images/$screenshot' ><img src='images/$screenshot' width='150' height='70'><a/></td>
            <td>$start_date</td>
            <td>$deadline</td>
            <td>$developer</td>
            <td><a href='projectedit.php'>Edit</a><hr><a href='projectdelete.php'>Delete</a></td>
            </tr>";
}
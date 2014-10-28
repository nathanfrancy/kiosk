<?php

function publicGetDepartmentsProfessors($departmentid) {
    $professors = array();

    $link = connect_db();
    $sql = "SELECT *, `professor`.`id` AS `professorid` FROM `professor` WHERE `department_id` = 50 AND `status` = 'enabled' ORDER BY `professor`.`lastname`";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('i', $departmentid);
    $stmt->execute();
    $result = $stmt->get_result();
    $theProfessor = null;

    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $id = $row['id'];
        $theProfessor = getProfessor($id);
        $theProfessor['officehours'] = getOfficeHours($id);
        array_push($professors, $theProfessor);
    }

    mysqli_stmt_close($stmt);
    return $professors;
}

function publicGetProfessorsWithLastName($letter) {
    $professors = array();
    
    $param = "{$letter}%";

    $link = connect_db();
    $sql = 'SELECT *, `professor`.`id` AS `professorid` FROM `professor` WHERE `lastname` LIKE ? AND `status` = "enabled" ORDER BY `professor`.`lastname`';
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('s', $param);
    $stmt->execute();
    $result = $stmt->get_result();
    $theProfessor = null;

    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $id = $row['id'];
        $theProfessor = getProfessor($id);
        $theProfessor['officehours'] = getOfficeHours($id);
        array_push($professors, $theProfessor);
    }

    mysqli_stmt_close($stmt);
    return $professors;
}

function publicGetPosts() {
    $posts = array();

    $link = connect_db();
    $sql = "SELECT * FROM `post` ORDER BY `date_created` desc";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $expired_posts = array();

    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $post = null;
        $current_id = $row['id'];

        // Get the current time and expiration date
        $expiration = intval($row['date_expiration']);
        $current_time = time();

        // Compare current time and expiration time
        // Add to post list if not expired
        if ($current_time < $expiration) {
            $post['id'] = $row['id'];
            $post['title'] = htmlentities($row['title']);
            $post['body'] = htmlentities($row['body']);
            $post['date_created'] = $row['date_created'];
            $post['date_modified'] = $row['date_modified'];
            $post['date_expiration'] = $row['date_expiration'];
            $user_created = getUser($row['user_id']);
            $post['user_created'] = $user_created;
            $post['user_created']->password = "";

            $user_modified = getUser($row['user_modified']);
            $post['user_modified'] = $user_modified;
            $post['user_modified']->password = "";
            array_push($posts, $post);
        }
        // Add post to $expired_posts array for deletion
        else {
            array_push($expired_posts, $current_id);
        }
    }
    mysqli_stmt_close($stmt);

    return $posts;
}



?>

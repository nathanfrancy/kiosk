<?php

function publicGetDepartmentsProfessors($departmentid) {
    $professors = array();

    $link = connect_db();
    $sql = "SELECT *, `professor`.`id` AS `professorid` FROM `professor` WHERE `department_id` = ? AND `status` = 'enabled' ORDER BY `professor`.`lastname`";
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

function publicGetDepartmentsCourses($departmentid) {
    $courses = array();

    $link = connect_db();
    $sql = "SELECT *, `course`.`id` AS `courseid` FROM `course` WHERE `department_id` = ? ORDER BY `course`.`number`";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('i', $departmentid);
    $stmt->execute();
    $result = $stmt->get_result();
    $theProfessor = null;

    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $id = $row['id'];
        $theCourse = getCourse($id);
        array_push($courses, $theCourse);
    }

    mysqli_stmt_close($stmt);
    return $courses;
}

function publicGetProfessorsThatTeachACourse($courseid) {
    $items = array();

    $link = connect_db();
    $sql = "SELECT * FROM `course`, `professor_courses`, `professor` WHERE `course`.`id` = ? AND `course`.`id` = `professor_courses`.`course_id` AND `professor_courses`.`professor_id` = `professor`.`id` AND `professor`.`status` = 'enabled'";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('i', $courseid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $item = null;
        $item['professor']['name'] = "{$row['firstname']}, {$row['lastname']}";
        $item['professor']['office'] = "{$row['officebuilding']} {$row['officeroom']}";
        $item['professor']['phone'] = $row['phonenumber'];
        $item['professor']['email'] = $row['email'];
        $item['professor']['pictureurl'] = $row['pictureurl'];
        $item['course']['number'] = $row['number'];
        $item['course']['name'] = $row['name'];
        $item['course']['days'] = $row['days'];
        $item['course']['time'] = $row['time'];
        array_push($items, $item);
    }

    mysqli_stmt_close($stmt);
    return $items;
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
    $sql = "SELECT * FROM `post` ORDER BY `date_modified` desc";
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

<?php

function getPosts() {
    $posts = array();

    $link = connect_db();
    $sql = "SELECT * FROM `post` ORDER BY `date_modified` desc";
    $stmt = $link->stmt_init();
    $stmt->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_array(MYSQLI_BOTH)) {
        $post = null;
        $post['id'] = $row['id'];
        $post['title'] = $row['title'];
        $post['body'] = $row['body'];
        $post['date_created'] = $row['date_created'];
        $post['date_modified'] = $row['date_modified'];
        
        $user_created = getUser($row['user_id']);
        $post['user_created'] = $user_created;
        
        $user_modified = getUser($row['user_modified']);
        $post['user_modified'] = $user_modified;
        
        array_push($posts, $post);
    }
    mysqli_stmt_close($stmt);
    
    return $posts;
}

function getPost($id) {
	$thePost = null;
	
	// Connect and initialize sql and prepared statement template
	$link = connect_db();
	$sql = "SELECT * FROM `post` WHERE `id` = ? LIMIT 1";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();

	// bind the result to $theProfessor for json encoding
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$thePost = null;
        $thePost['id'] = $row['id'];
        $thePost['title'] = $row['title'];
        $thePost['body'] = $row['body'];
        $thePost['date_created'] = $row['date_created'];
        $thePost['date_modified'] = $row['date_modified'];
        
        // Include the user that created it
        $user_created = getUser($row['user_id']);
        $thePost['user_created'] = $user_created;
        
        // Include the user that last modified it
        $user_modified = getUser($row['user_modified']);
        $thePost['user_modified'] = $user_modified;
        
        // Don't include the passwords, duh
        $thePost['user_created']->password = "";
        $thePost['user_modified']->password = "";
    }

	mysqli_stmt_close($stmt);
	
	return $thePost;
}

function addPost($title, $body, $userid) {
    $current_time = time();
    $link = connect_db();
	$sql = "INSERT INTO `ucmo_kiosk`.`post` (`title`, `body`, `date_created`, `date_modified`, `user_id`, `user_modified`) VALUES (?, ?, ?, ?, ?, ?);";
	$stmt = $link->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('ssssii', 
                      $link->real_escape_string($title), 
                      $link->real_escape_string($body),
                      $link->real_escape_string($current_time),
                      $link->real_escape_string($current_time),
                      $link->real_escape_string($userid),
                      $link->real_escape_string($userid)
                     );
	$stmt->execute();
	$id = $link->insert_id;
	mysqli_stmt_close($stmt);
	$link->close();
	
	$post = getPost($id);
	
	return $post;
}

?>
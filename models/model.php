<?php

class User {
	public $id;
	public $username;
	public $nicename;
	public $email;
	public $type;
    public $status;
	public $theme;
}

class Department {
    public $id;
    public $name;
	public $prefix;
}

class Professor {
    public $id;
    public $department_id;
    public $firstname;
    public $lastname;
    public $title;
    public $officebuilding;
    public $officeroom;
    public $phonenumber;
    public $email;
    public $pictureurl;
	public $status;
}

class OfficeHours {
	public $id;
	public $days;
	public $times;
	public $professor_id;
}

class Course {
	public $id;
	public $number;
	public $name;
	public $department_id;
}

class Post {
    public $id;
    public $title;
    public $body;
    public $date_created;
    public $date_modified;
    public $user_id;
    public $user_modified;
}

?>
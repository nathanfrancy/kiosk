<?php

class User {
	public $id;
	public $username;
	public $nicename;
	public $email;
	public $type;
    public $status;
}

class Department {
    public $id;
    public $name;
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
}

?>
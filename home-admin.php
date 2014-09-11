<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/administrator.css">
        <script src="js/jquery.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Administrator Dashboard</title>
    </head>

    <body>
    
        <div class="container-fluid">
            <h3>Administrator Dashboard</h3>
            <nav class="nav-admin">
                <button type="button" class="btn btn-default pull-right"><span class="glyphicon glyphicon-user"></span> <?php echo $user->username; ?></button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default navigation active" openview="department">Department Manager</button>
                  <button type="button" class="btn btn-default navigation" openview="user">User Manager</button>
                </div>
            </nav>
            
            <div class="container-body">
                <div class="view" id="view-department">
                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-default btn-block"><span class="glyphicon glyphicon-plus-sign"></span> Add Department</button>
                        </div>
                        <div class="col-sm-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">All Departments</h3>
                                </div>
                                <div class="panel-body">
                                <?php 
                                    $departments = getAllDepartments();
                                    $departmentList = "<div class='list-group' id='list-department'>";
                                    $counter = 0;
                                    foreach($departments as $department) {
                                        $departmentList .= "<a class='list-group-item' href='#'><span class='label label-primary'>". $department->id ."</span> ". $department->name ."</a>";
                                        $counter++;
                                    }
                                    $departmentList .= "</div>" . $counter . " Results";
                                    echo $departmentList;
                                ?>
                              </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="view" id="view-user">
                    user
                </div>
                
            </div>
            
        </div>
        
    </body>
    
    
    <script type="text/javascript" src="js/administrator.js"></script>
    
</html>



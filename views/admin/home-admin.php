<?php
require("header.php");
?>
			<div class="btn-group pull-right" style="margin-top: 10px;">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<span class="glyphicon glyphicon-user"></span> &nbsp;
					<?php echo $user->username; ?> &nbsp;<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="logout.php">Logout</a>
					</li>
				</ul>
			</div>
			<h2>Administrator Dashboard</h2>
			<nav class="nav-admin">
				<div class="btn-group">
					<button type="button" class="btn btn-primary navigation active" openview="department">Department Manager</button>
					<button type="button" class="btn btn-primary navigation" openview="user">User Manager</button>
				</div>
			</nav>
		</div>
		
        <div class="container-fluid"> 
            <div class="container-body">
                <div class="view" id="view-department">
                    <div class="row">
                        <div class="col-sm-10">
                            <h3 style="margin-top: 0px; margin-bottom: 20px;">Department Manager</h3>
                                <?php 
                                    $departments = getAllDepartments();
                                    $departmentList = "<div class='list-group' id='list-department'>";
                                    $counter = 0;
                                    foreach($departments as $department) {
                                        $departmentList .= "<a class='list-group-item list-department-item' href='#' departmentid='" . $department->id . "'><h4 class='list-group-item-heading'><span class='label label-primary pull-right'>". $department->id ."</span> ". $department->name ."</h4></a>";
                                        $counter++;
                                    }
                                    $departmentList .= "</div>";
                                    echo $departmentList;
                                ?>
                        </div>
						<div class="col-sm-2">
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addDepartmentModal"><span class="glyphicon glyphicon-plus-sign"></span> Add Department</button><br />
                        </div>
                    </div>
                    
                </div>
                
                <div class="view" id="view-user">
                    <div class="row">
                        
                        <div class="col-sm-10">
							<h3 style="margin-top: 0px;">User Manager</h3>
									<div class="btn-group" id="list-user-filter" style="margin-bottom: 20px;">
										<button type="button" class="btn btn-default btn-sm active" filtertype="all">All Users</button>
										<button type="button" class="btn btn-default btn-sm" filtertype="admin">Administrator</button>
										<button type="button" class="btn btn-default btn-sm" filtertype="editor">Editor</button>
										<button type="button" class="btn btn-default btn-sm" filtertype="poster">News Poster</button>
									</div>
									
                                <?php 
                                    $users = getAllUsers();
                                    $userList = "<div class='list-group' id='list-user'>";

                                    foreach($users as $user) {
										$usertype = $user->type;
										$niceusertype = "";
										if ($usertype === "admin") { $niceusertype = "Administrator"; }
										if ($usertype === "editor") { $niceusertype = "Editor"; }
										if ($usertype === "poster") { $niceusertype = "News Poster"; }
										if ($usertype === "editorposter") { $niceusertype = "Editor/News Poster"; }
										
                                        $userList .= "<a class='list-group-item list-user-item' href='#' usertype='" . $usertype . "' userid='" . $user->id . "' style=''><h4 class='list-group-item-heading'><span class='label label-primary pull-right'>". $user->id ."</span>". $user->nicename ."&nbsp;<small>" . $user->username . "</small></h4><p class='list-group-item-text'>" . $niceusertype . "</p></a>";
                                    }
                                    $userList .= "</div>";
                                    echo $userList;
                                ?>
									
                        </div>
						<div class="col-sm-2">
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addUserModal"><span class="glyphicon glyphicon-plus-sign"></span> Add User</button><br />
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        

        <!-- Add Department Modal -->
        <div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                <h4 class="modal-title" id="myModalLabel">Add Department</h4>
              </div>
              <div class="modal-body">
                <form role="form">
                  <div class="form-group">
                    <label for="adddepartment-name">Department Name</label>
                    <input type="text" class="form-control" id="adddepartment-name" placeholder="Enter name of department">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addDepartmentButton">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Edit Department Modal -->
        <div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                <h4 class="modal-title" id="myModalLabel">Edit Department</h4>
              </div>
              <div class="modal-body">
                <form role="form">
                  <div class="form-group">
                    <label for="adddepartment-name">ID Number</label>
                    <input type="text" class="form-control" id="editdepartment-id" readonly>
                  </div>
                  <div class="form-group">
                    <label for="adddepartment-name">Department Name</label>
                    <input type="text" class="form-control" id="editdepartment-name" placeholder="Enter name of department">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="deleteDepartmentButton">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editDepartmentButton">Save changes</button>
              </div>
            </div>
          </div>
        </div>
		
		
		
		<!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                <h4 class="modal-title" id="myModalLabel">Add User</h4>
              </div>
              <div class="modal-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="adduser-username">Name</label>
                                <input type="text" class="form-control" id="adduser-nicename" placeholder="Enter full name of the user">
                              </div>
                              <div class="form-group">
                                <label for="adduser-username">Username</label>
                                <input type="text" class="form-control" id="adduser-username" placeholder="Enter username">
                              </div>
                              <div class="form-group">
                                <label for="adduser-password">Password</label>
                                <input type="password" class="form-control" id="adduser-password" placeholder="Enter password">
                              </div>
                              <div class="form-group">
                                <label for="adduser-email">Email</label>
                                <input type="text" class="form-control" id="adduser-email" placeholder="Enter user's email">
                              </div>
                        </div>
                        <div class="col-sm-6">
                                <div class="panel panel-primary">
                                  <div class="panel-heading">
                                    <h3 class="panel-title">Access Level</h3>
                                  </div>
                                  <div class="panel-body">
                                    <div class="form-group">
                                        <label for="adduser-type">Type</label>
                                        <select class="form-control" id="adduser-type">
                                            <option value="editor">Editor</option>
                                            <option value="poster">Poster</option>
                                            <option value="editorposter">Editor and Poster</option>
                                            <option value="admin">Administrator</option>
                                        </select>
                                    </div>
                                    <div class="btn-group" id="adduser-status">
                                      <button type="button" class="btn btn-default active" id="adduser-status-enabled">Enabled</button>
                                      <button type="button" class="btn btn-default" id="adduser-status-disabled">Disabled</button>
                                    </div>
                                  </div>
                                </div>
                            <div class="alert alert-info" role="alert"><strong>Looking for department access controls?</strong> Establish the user account first, then edit the user account to give an editor permissions to specific departments.</div>
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" id="addUserButton">Save changes</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        
        
        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                <h4 class="modal-title" id="myModalLabel">Edit User</h4>
              </div>
              <div class="modal-body">
                <form role="form">
                  <div class="row">
                    <div class="col-sm-6">
                          <div class="form-group">
                            <label for="edituser-id">ID Number</label>
                            <input type="text" class="form-control" id="edituser-id" readonly>
                          </div>
                          <div class="form-group">
                            <label for="edituser-nicename">Name</label>
                            <input type="text" class="form-control" id="edituser-nicename" placeholder="Enter full name">
                          </div>
                          <div class="form-group">
                            <label for="edituser-username">Username</label>
                            <input type="text" class="form-control" id="edituser-username" placeholder="Enter username">
                          </div>
                          <div class="form-group">
                            <label for="edituser-email">Email</label>
                            <input type="text" class="form-control" id="edituser-email" placeholder="Enter email">
                          </div>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title">Password Reset</h3>
                          </div>
                          <div class="panel-body">
                                <div class="form-group">
                                    <label for="edituser-nicename">Password</label>
                                    <input type="password" class="form-control" id="edituser-password1" placeholder="Enter password">
                                </div>
                                <div class="form-group">
                                    <label for="edituser-nicename">Re-enter Password</label>
                                    <input type="password" class="form-control" id="edituser-password2" placeholder="Re-enter password">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" id="edituser-passwordresetbutton">Reset Password</button>
                                </div>
                          </div>
                        </div>
                    </div>  
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                          <div class="panel-heading">
                            <h3 class="panel-title">Access Level</h3>
                          </div>
                          <div class="panel-body">
                            <div class="form-group">
                                <label for="edituser-type">Type</label>
                                <select class="form-control" id="edituser-type">
                                    <option value="editor">Editor</option>
                                    <option value="poster">Poster</option>
                                    <option value="editorposter">Editor and Poster</option>
                                    <option value="admin">Administrator</option>
                                </select>
                            </div>
                            <div class="btn-group" id="edituser-status">
                              <button type="button" class="btn btn-default" id="edituser-status-enabled">Enabled</button>
                              <button type="button" class="btn btn-default" id="edituser-status-disabled">Disabled</button>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-primary" id="edituser-departmentaccess">
                          <div class="panel-heading">
                            <h3 class="panel-title">Department Access</h3>
                          </div>
                          <div class="panel-body">
                            <div class="form-group">
                                <?php
                                    foreach ($departments as $department) {
                                        echo '<div class="checkbox"><label><input class="addaccess-department" type="checkbox" value="'. $department->id .'" name="department[]">'. $department->name .'</label></div>';
                                    }
                                ?>
                            </div>
                          </div>
                        </div>
                        
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id="deleteUserButton">Delete User</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                
                <button type="button" class="btn btn-primary pull-left" id="editUserButton">Save changes</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
<?php
require("footer.php");
?>
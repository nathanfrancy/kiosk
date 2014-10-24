<?php
require("header.php");
?>
			<center>
				<h2>Administrator Dashboard</h2>
				<nav class="nav-admin">
					<div class="btn-group">
						<a type="button" class="btn btn-default navigation" href="home.php?page=department">Department Manager</a>
						<a type="button" class="btn btn-default navigation active" href="home.php?page=user">User Manager</a>
					</div>
					<div class="btn-group" style="margin-left: 25px;">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span> &nbsp;
							<?php echo $user->username; ?> &nbsp;<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a id="changeThemeButton" data-target="#changeThemeModal" href="#">Change Theme</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</div>
				</nav>
			</center>
		</div>
		
        <div class="container-fluid"> 
            <div class="container-body">
                
                <div class="view" id="view-user">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
							<h3 style="margin-top: 0px;">User Manager</h3>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal"><span class="glyphicon glyphicon-plus-sign"></span> Add</button><br /><br />
									<div class="btn-group" id="list-user-filter" style="margin-bottom: 20px;">
										<button type="button" class="btn btn-default btn-sm active" filtertype="all">All Users</button>
										<button type="button" class="btn btn-default btn-sm" filtertype="admin">Administrator</button>
										<button type="button" class="btn btn-default btn-sm" filtertype="editor">Editor</button>
										<button type="button" class="btn btn-default btn-sm" filtertype="poster">News Poster</button>
									</div>
									
                                <?php 
                                    $users = getAllUsers();
                                    $userList = "<div class='list-group' id='list-user'>";

                                    foreach($users as $userobj) {
										$usertype = $userobj->type;
										$niceusertype = "";
										if ($usertype === "admin") { $niceusertype = "Administrator"; }
										if ($usertype === "editor") { $niceusertype = "Editor"; }
										if ($usertype === "poster") { $niceusertype = "News Poster"; }
										if ($usertype === "editorposter") { $niceusertype = "Editor/News Poster"; }
										
                                        $userList .= "<a class='list-group-item list-user-item' href='#' usertype='" . $usertype . "' userid='" . $userobj->id . "' style=''><h4 class='list-group-item-heading'><span class='label label-primary pull-right'>". $userobj->id ."</span>". $userobj->nicename ."&nbsp;<small>" . $userobj->username . "</small></h4><p class='list-group-item-text'>" . $niceusertype . "</p></a>";
                                    }
                                    $userList .= "</div>";
                                    echo $userList;
                                ?>
									
                        </div>
						
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
                                    $departments = getAllDepartments();
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
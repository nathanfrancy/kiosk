<?php
require("header.php");
?>
			<div class="btn-group pull-right" style="margin-top: 10px;">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<span class="glyphicon glyphicon-user"></span> &nbsp;
					<?php echo $user->username; ?> &nbsp;<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a id="changeThemeButton" data-target="#changeThemeModal" href="#">Change Theme</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
			<h2>Administrator Dashboard</h2>
			<nav class="nav-admin">
				<div class="btn-group">
					<a type="button" class="btn btn-primary navigation active" href="home.php?page=department">Department Manager</a>
					<a type="button" class="btn btn-primary navigation" href="home.php?page=user">User Manager</a>
				</div>
			</nav>
		</div>
		
        <div class="container-fluid"> 
            <div class="container-body">
                <div class="view" id="view-department">
                    <div class="row">
						<div class="col-sm-2">
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addDepartmentModal"><span class="glyphicon glyphicon-plus-sign"></span> Add</button><br /><br />
                        </div>
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
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="adddepartment-name">Department Name</label>
								<input type="text" class="form-control" id="adddepartment-name" placeholder="Enter name of department">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="adddepartment-prefix">Prefix (not required)</label>
								<input type="text" class="form-control" id="adddepartment-prefix" placeholder="Enter the prefix">
							</div>
						</div>
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
					
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="adddepartment-name">Department Name</label>
							<input type="text" class="form-control" id="editdepartment-name" placeholder="Enter name of department">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="adddepartment-prefix">Prefix (not required)</label>
							<input type="text" class="form-control" id="editdepartment-prefix" placeholder="Enter prefix of department">
						</div>
					</div>
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
		
<?php
require("footer.php");
?>
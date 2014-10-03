<?php
require("header.php");
?>

<div class="container-body">			
    
    <div class="container-fluid"> 
        <div class="container-body">
            <div class="view" id="view-department">
                <div class="row">
                    <div class="col-sm-4" id="container-department">
						
						<div class="panel panel-default">
						  <div class="panel-heading">
							<h3 class="panel-title">Departments</h3>
						  </div>
						  <div class="panel-body">
							
                        <div class="list-group">
                        <?php
                            $departments = getAccessedDepartments($user->id);
                            
                            foreach ($departments as $department) {
                            ?>
								  <a href="#" class="list-group-item panel-department" departmentid="<?php echo $department['id']; ?>">
									<h4 class="list-group-item-heading"><?php echo $department['name']; ?></h4>
								  </a>
                            <?php
                            }
                        ?>
							</div>
						  </div>
						</div>
                    </div>
					<div class="col-sm-4" id="container-professor">
						<div class="panel panel-default">
						  <div class="panel-heading">
							<h3 class="panel-title">Professors</h3>
						  </div>
						  <div class="panel-body">
							  <div class="row">
								  <div class="col-sm-12">
								  	<button class="btn btn-default" id="addProfessorButton">
										  <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp; Add
									</button><br />
								  	<div id="filldepartmentprofessors"><p>Click on a department to begin.</p></div>
								  </div>
							  </div>
							  
						</div>
						</div>
					</div>
					
					<div class="col-sm-4" id="container-course">
						<div class="panel panel-default">
						  <div class="panel-heading">
							<h3 class="panel-title">Courses</h3>
						  </div>
						  <div class="panel-body">
							  <div class="row">
								  <div class="col-sm-12">
								  	<button class="btn btn-default" id="addProfessorButton">
										  <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp; Add
									</button><br />
								  	<div id="filldepartmentcourses"><p>Click on a department to begin.</p></div>
								  </div>
							  </div>
							  
						</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
    
</div>


		<div class="modal fade" id="addEditProfessorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                <h4 class="modal-title" id="myModalLabel">Edit Professor</h4>
              </div>
              <div class="modal-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-8">
							<div class="form-group" id="addeditprofessor-id-container">
								<label for="addeditprofessor-id">ID</label>
								<input type="text" class="form-control" id="addeditprofessor-id" placeholder="ID" readonly>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="addeditprofessor-firstname">First Name</label>
										<input type="text" class="form-control" id="addeditprofessor-firstname" placeholder="First">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="addeditprofessor-lastname">Last Name</label>
										<input type="text" class="form-control" id="addeditprofessor-lastname" placeholder="Last">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="addeditprofessor-officebuilding">Office Building</label>
										<input type="text" class="form-control" id="addeditprofessor-officebuilding" placeholder="Building">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="addeditprofessor-officeroom">Office Room</label>
										<input type="text" class="form-control" id="addeditprofessor-officeroom" placeholder="Room">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="addeditprofessor-phonenumber">Phone Number</label>
										<input type="text" class="form-control" id="addeditprofessor-phonenumber" placeholder="Phone Number">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="addeditprofessor-email">Email</label>
										<input type="text" class="form-control" id="addeditprofessor-email" placeholder="Email">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-10">
									<div class="form-group">
										<label for="addeditprofessor-pictureurl">Image URL</label>
										<input type="text" class="form-control" id="addeditprofessor-pictureurl" placeholder="Picture URL">
									</div>
								</div>
								<div class="col-sm-2">
									<div id="imagebox-professor">
										<img src="assets/img/no-image-available.png" class="img-thumbnail">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="addeditprofessor-">Department</label>
								<select id="addeditprofessor-departmentid" class="form-control">
									<?php
										// Use the departments from above, only show those departments the user has access to manage
										foreach ($departments as $department) {
											echo '<option value="'. $department['id'] .'">' . $department['name'] . '</option>';	
										}
									?>
								</select>
							</div>
                        	
                        </div>
                        <div class="col-sm-4">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title">Status</h3>
									</div>
									<div class="panel-body">
										<div class="btn-group" id="adduser-status">
										  <button type="button" class="btn btn-default" id="adddepartment-status-enabled">Enabled</button>
										  <button type="button" class="btn btn-default" id="adddepartment-status-disabled">Disabled</button>
										</div>
									</div>
								</div>
                               	<div class="panel panel-primary panel-classschedule">
                                  <div class="panel-heading">
                                    <h3 class="panel-title">Class Schedule</h3>
                                  </div>
                                  <div class="panel-body">
                                  	
                                  </div>
                                </div>
								<div class="panel panel-primary panel-officehours">
                                  <div class="panel-heading">
                                    <h3 class="panel-title">Office Hours</h3>
                                  </div>
                                  <div class="panel-body">
                                  	<div id="professor-officehours">
										<ul class="list-group" id="professor-officehours-list"></ul>
										
										<div id="addofficehours-container">
											<div class="row">
												<div class="col-sm-6">
													<input type="text" class="form-control" id="addedofficehours-days" placeholder="Days">
												</div>
												<div class="col-sm-6">
													<input type="text" class="form-control" id="addedofficehours-times" placeholder="Times">
												</div>
											</div>
											<br />
											<div class="form-group">
												<button type="button" class="btn btn-primary btn-block" id="addofficehours-button">Add Office Hours</button>
											</div>
										</div>
										<br />
										
									</div>
                                  </div>
                                </div>
                            <!--<div class="alert alert-info" role="alert"><strong></strong></div>-->
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" id="addProfessorButtonSubmit">Save changes</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

<?php
require("footer.php");
?>
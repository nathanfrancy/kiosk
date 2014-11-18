<?php
require("header.php");
?>
		
        <div class="container-fluid"> 
            <div class="container-body">
                <div class="view" id="view-department">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <h3 style="margin-top: 0px; margin-bottom: 20px;">Manage Departments</h3>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDepartmentModal"><span class="glyphicon glyphicon-plus-sign"></span> Add</button><br /><br>
                                <?php 
                                    $departments = getAllDepartments();
                                ?>
                            <div id="list-department-container"></div>
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
								<label for="adddepartment-name"><span class="required">*</span> Department Name</label>
								<input type="text" class="form-control" id="adddepartment-name" placeholder="Enter name of department">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="adddepartment-prefix">Prefix</label>
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
							<label for="adddepartment-name"><span class="required">*</span> Department Name</label>
							<input type="text" class="form-control" id="editdepartment-name" placeholder="Enter name of department">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="adddepartment-prefix">Prefix</label>
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

<script>
$(".nav-admin .btn-group a:nth-child(1)").addClass("active");
</script>
		
<?php
require("footer.php");
?>

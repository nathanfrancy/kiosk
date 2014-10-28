<?php
require("header.php");
?>

<div class="container-body">			
    
    <div id="userid-key" userid="<?php echo $user->id; ?>"></div>
    
    <div class="row">
        
        <div class="col-sm-6 col-sm-offset-3">
            
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Posts</h3>
              </div>
              <div class="panel-body">
                <button class="btn btn-primary" id="addPostOpenModal" data-toggle="modal" data-target="#addEditPostModal">Add Post</button>
                  <br>
                <ul class="list-group" id="list-all-posts"></ul>
              </div>
            </div>
        </div>
        
    </div>
    
</div>


        <div class="modal fade" id="addEditPostModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                <h4 class="modal-title" id="addEditCourseTitle">Add Post</h4>
              </div>
              <div class="modal-body">
				 <div class="row" id="addeditpost-readonly-first">
					<div class="col-sm-2">
				        <div class="form-group" id="addeditpost-id-container">
							<label for="addeditpost-id">ID</label>
							<input type="text" class="form-control" id="addeditpost-id" placeholder="ID" readonly>
					   </div>
					</div>
                    <div class="col-sm-5">
				        <div class="form-group" id="addeditpost-id-container">
							<label for="addeditpost-id">User Created</label>
							<input type="text" class="form-control" id="addeditpost-userid" placeholder="Created User" readonly>
					   </div>
					</div> 
                    <div class="col-sm-5">
				        <div class="form-group" id="addeditpost-id-container">
							<label for="addeditpost-id">Date Created</label>
							<input type="text" class="form-control" id="addeditpost-createddate" placeholder="Created Date" readonly>
					   </div>
					</div> 
				</div>
				  
              	<div class="form-group">
                    <label for="addeditpost-title">Title</label>
					<input class="form-control" id="addeditpost-title">
				</div>
				<div class="form-group">
                    <label for="addeditcourse-departmentid">Body</label>
					<textarea id="addeditpost-body" class="form-control" rows="6"></textarea>
				</div>
				<div class="form-group">
                    <label for="addeditpost-expirationdate">Expiration Date</label>
					<input type='text' class="form-control" id='addeditpost-expirationdate' data-date-format="MM/DD/YYYY"/>
				</div>
                <div class="form-group" id="addeditpost-readonly-second">
                    <label>Last modified: <span id="addeditpost-lastmodified"></span></label>
				</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" id="savePostButtonSubmit">Save Post</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger pull-right" id="deletePostSubmit">Delete</button>
              </div>
            </div>
          </div>
        </div>

<?php
require("footer.php");
?>

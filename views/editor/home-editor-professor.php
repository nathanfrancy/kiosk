<?php
require("header.php");
?>

<div class="container-body">			
    
    <div class="container-fluid"> 
        <div class="container-body">
            <div class="view" id="view-department">
                <div class="row">
                    <div class="col-sm-10">
                        <h3 style="margin-top: 0px; margin-bottom: 20px;">Professor Manager</h3>
                        
                        
                        <?php
                            $departments = getAccessedDepartments($user->id);
                            
                            foreach ($departments as $department) {
                            ?>
                                <div class="panel panel-default panel-department" departmentid="<?php echo $department['id']; ?>">
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><span class="glyphicon glyphicon-refresh pull-right"></span> <?php echo $department['name']; ?></h3>
                                  </div>
                                  <div class="panel-body"></div>
                                </div>
                            <?php
                            }

                        ?>
                        
                    </div>
                    <div class="col-sm-2">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php
require("footer.php");
?>
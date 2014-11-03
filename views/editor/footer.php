<?php
if (($extend !== 1) || (basename($_SERVER['PHP_SELF']) !== "home.php")) {
	echo '<meta http-equiv="refresh" content="0; url=../../index.php">';
}
?>

</div>

		<div class="modal fade" id="changeThemeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                  </button>
                <h4 class="modal-title" id="myModalLabel">Change Theme</h4>
              </div>
              <div class="modal-body">
				  <input type="hidden" id="changeTheme-userid" value="<?php echo $user->id; ?>">
				  <select class="form-control" id="changeThemeInput">
				  	<?php
						foreach ($boots as $boot) {
							if ($boot === $user->theme) {
								echo "<option value='". $boot ."' selected>". ucfirst(strtolower($boot)) . "</option>";
							}
							else {
								echo "<option value='". $boot ."'>". ucfirst(strtolower($boot)) . "</option>";
							}
						}
					?>
				  </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" id="saveTheme">Save theme</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

	</body>

	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/moment.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="assets/js/editor.js"></script>
    <script type="text/javascript" src="assets/js/sitewide.js"></script>
	
</html>
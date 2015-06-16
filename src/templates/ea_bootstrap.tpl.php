<script type="text/javascript">
	var ea_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<script type="text/template" id="ea-bootstrap-main">
<div class="ea-bootstrap" style="max-width: <%= settings.width %>">
	<form class="form-horizontal">
		<div class="step form-group">
			<div class="block"></div>
			<label class="ea-label col-sm-4 control-label">
				<?php echo EALogic::get_option_value("trans.location")?>
			</label>
			<div class="col-sm-8">
				<select name="location" data-c="location" class="filter form-control">
					<?php $this->get_options("locations")?>
				</select>
			</div>
		</div>
		<div class="step form-group">
			<div class="block"></div>
			<label class="ea-label col-sm-4 control-label">
				<?php echo EALogic::get_option_value("trans.service")?>
			</label>
			<div class="col-sm-8">
				<select name="service" data-c="service" class="filter form-control" data-currency>
					<?php $this->get_options("services")?>
				</select>
			</div>
		</div>
		<div class="step form-group">
			<div class="block"></div>
			<label class="ea-label col-sm-4 control-label">
				<?php echo EALogic::get_option_value("trans.worker")?>
			</label>
			<div class="col-sm-8">
				<select name="worker" data-c="worker" class="filter form-control">
					<?php $this->get_options("staff")?>
				</select>
			</div>
		</div>
		<div class="step calendar" class="filter">
			<div class="block"></div>
			<div class="date"></div>
		</div>
		<div class="step" class="filter">
			<div class="block"></div>
			<div class="time"></div>
		</div>
		<div class="step final">
			<div class="block"></div>
			<h3>Personal information</h3>
			<small>Fields with * are required</small>
			<div class="form-group">
				<label class="col-sm-4 control-label">Email * : </label>
				<div class="col-sm-8">
					<input type="text" name="email" class="form-control" data-rule-required="true" data-rule-email="true" data-msg-email="Please enter a valid email address">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">Name * : </label>
				<div class="col-sm-8">
					<input type="text" name="name" class="form-control" data-rule-required="true" data-rule-minlength="3">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">Phone * : </label>
				<div class="col-sm-8">
					<input type="text" name="phone" class="form-control" data-rule-required="true" data-rule-minlength="3">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">Comment : </label>
				<div class="col-sm-8">
					<textarea name="description" class="form-control"></textarea>
				</div>
			</div>
			<h3>Booking overview</h3>
			<div id="booking-overview"></div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<button class="ea-btn ea-submit btn btn-primary">Submit</button>
					<button class="ea-btn ea-cancel btn btn-default">Cancel</button>
				</div>
			</div>
		</div>
	</form>
</div>
</script>
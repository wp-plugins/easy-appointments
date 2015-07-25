<script type="text/javascript">
	var ea_ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
</script>
<script type="text/template" id="ea-bootstrap-main">
<div class="ea-bootstrap" style="max-width: <%= settings.width %>;">
	<form class="form-horizontal">
		<% if (settings.layout_cols === '2') { %>
		<div class="col-md-6" style="padding-top: 25px;">
		<% } %>
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
		<% if (settings.layout_cols === '2') { %>
		</div>
		<div class="step final col-md-6">
		<% } else { %>
		<div class="step final">
		<% } %>
			<div class="block"></div>
			<h3><%= settings['trans.personal-informations'] %></h3>
			<small><%= settings['trans.fields'] %></small>
			<div class="form-group">
				<label class="col-sm-4 control-label"><%= settings['trans.email'] %> * : </label>
				<div class="col-sm-8">
					<input type="text" name="email" class="form-control" data-rule-required="true" data-rule-email="true" data-msg-required="<%= settings['trans.field-required'] %>" data-msg-email="<%= settings['trans.error-mail'] %>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><%= settings['trans.name'] %> * : </label>
				<div class="col-sm-8">
					<input type="text" name="name" class="form-control" data-rule-required="true" data-rule-minlength="3" data-msg-required="<%= settings['trans.field-required'] %>" data-msg-minlength="<%= settings['trans.error-name'] %>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><%= settings['trans.phone'] %> * : </label>
				<div class="col-sm-8">
					<input type="text" name="phone" class="form-control" data-rule-required="true" data-rule-minlength="3" data-msg-required="<%= settings['trans.field-required'] %>" data-msg-minlength="<%= settings['trans.error-phone'] %>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><%= settings['trans.comment'] %> : </label>
				<div class="col-sm-8">
					<textarea name="description" class="form-control" style="height: auto;"></textarea>
				</div>
			</div>
			<h3><%= settings['trans.booking-overview'] %></h3>
			<div id="booking-overview"></div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<button class="ea-btn ea-submit btn btn-primary"><%= settings['trans.submit'] %></button>
					<button class="ea-btn ea-cancel btn btn-default"><%= settings['trans.cancel'] %></button>
				</div>
			</div>
		</div>
	</form>
</div>
</script>
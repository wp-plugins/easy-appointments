<script type="text/template" id="ea-settings-main">
<?php 
	get_current_screen()->render_screen_meta();
?>
	<div class="wrap">
		<ul id="tab-header">
			<li>
				<a href="#locations/">
					<i class="fa fa-map-marker"></i>
					<?php _e('Locations', 'easy-appointments');?>
				</a>
			</li>
			<li>
				<a href="#services/">
					<i class="fa fa-cube"></i>
					<?php _e('Services', 'easy-appointments');?>
				</a>
			</li>
			<li>
				<a href="#staff/">
					<i class="fa fa-user"></i>
					<?php _e('Workers', 'easy-appointments');?>
				</a>
			</li>
			<li>
				<a href="#connection/">
					<i class="fa fa-sitemap"></i>
					<?php _e('Connections', 'easy-appointments');?>
				</a>
			</li>
			<li>
				<a href="#custumize/">
					<i class="fa fa-paint-brush"></i>
					<?php _e('Customize', 'easy-appointments');?>
				</a>
			</li>
		</ul>
		<div id="tab-content">
			
		</div>
	</div>
</script>

<script type="text/template" id="ea-tpl-locations-table">
<div>
	<h2>
		<a href="#" class="add-new-h2 add-new">
			<i class="fa fa-plus"></i>
			<?php _e('Add New Location', 'easy-appointments');?>
		</a>
		<a href="#" class="add-new-h2 refresh-list">
			<i class="fa fa-refresh"></i>
			<?php _e('Refresh', 'easy-appointments');?>
		</a>
		<span id="status-msg" class="status"></span>
	</h2>
	<table class="wp-list-table widefat fixed">
		<thead>
			<tr>
				<th class="manage-column column-title column-5">Id</th>
				<th class="manage-column column-title"><?php _e('Name','easy-appointments');?></th>
				<th class="manage-column column-title"><?php _e('Address','easy-appointments');?></th>
				<th class="manage-column column-title"><?php _e('Location','easy-appointments');?></th>
				<th class="manage-column column-title column-15"><?php _e('Actions','easy-appointments');?></th>
			</tr>
		</head>
		<tbody id="ea-locations">
			
		</tbody>
	</table>
</div>
</script>

<script type="text/template" id="ea-tpl-locations-row">
	<td><%= row.id %></td>
	<td class="post-title page-title column-title">
		<strong><%= row.name %></strong>
	</td>
	<td>
		<strong><%= row.address %></strong>
	</td>
	<td>
		<strong><%= row.location %></strong>
	</td>
	<td>
		<button class="button btn-edit"><?php _e('Edit','easy-appointments');?></button>
		<button class="button btn-del"><?php _e('Delete','easy-appointments');?></button>
	</td>
</script>

<script type="text/template" id="ea-tpl-locations-row-edit">
	<td><%= row.id %></td>
	<td><input type="text" data-prop="name" value="<%= row.name %>"></td>
	<td><input type="text" data-prop="address" value="<%= row.address %>"></td>
	<td><input type="text" data-prop="location" value="<%= row.location %>"></td>
	<td>
		<button class="button button-primary btn-save"><?php _e('Save','easy-appointments');?></button>
		<button class="button btn-cancel"><?php _e('Cancel','easy-appointments');?></button>
	</td>
</script>

<script type="text/template" id="ea-tpl-services-table">
<div>
	<h2>
		<a href="#" class="add-new-h2 add-new">
			<i class="fa fa-plus"></i>
			<?php _e('Add New Service','easy-appointments');?>
		</a>
		<a href="#" class="add-new-h2 refresh-list">
			<i class="fa fa-refresh"></i>
			<?php _e('Refresh','easy-appointments');?>
		</a>
		<span id="status-msg" class="status"></span>
	</h2>
	<table class="wp-list-table widefat fixed">
		<thead>
			<tr>
				<th class="manage-column column-title column-5">Id</th>
				<th class="manage-column column-title"><?php _e('Name','easy-appointments');?></th>
				<th class="manage-column column-title"><?php _e('Duration (min)','easy-appointments');?></th>
				<th class="manage-column column-title"><?php _e('Price','easy-appointments');?></th>
				<th class="manage-column column-title column-15"><?php _e('Actions','easy-appointments');?></th>
			</tr>
		</head>
		<tbody id="ea-services">
			
		</tbody>
	</table>
</div>
</script>

<script type="text/template" id="ea-tpl-services-row">
	<td><%= row.id %></td>
	<td class="post-title page-title column-title">
		<strong><%= row.name %></strong>
	</td>
	<td>
		<strong><%= row.duration %></strong>
	</td>
	<td>
		<strong><%= row.price %></strong>
	</td>
	<td>
		<button class="button btn-edit"><?php _e('Edit','easy-appointments');?></button>
		<button class="button btn-del"><?php _e('Delete','easy-appointments');?></button>
	</td>
</script>

<script type="text/template" id="ea-tpl-services-row-edit">
	<td><%= row.id %></td>
	<td><input type="text" data-prop="name" value="<%= row.name %>"></td>
	<td><input type="text" data-prop="duration" value="<%= row.duration %>"></td>
	<td><input type="text" data-prop="price" value="<%= row.price %>"></td>
	<td>
		<button class="button button-primary btn-save"><?php _e('Save','easy-appointments');?></button>
		<button class="button btn-cancel"><?php _e('Cancel','easy-appointments');?></button>
	</td>
</script>

<!-- Staff -->
<script type="text/template" id="ea-tpl-staff-table">
<div>
	<h2>
		<a href="#" class="add-new-h2 add-new">
			<i class="fa fa-plus"></i>
			<?php _e('Add New Worker','easy-appointments');?>
		</a>
		<a href="#" class="add-new-h2 refresh-list">
			<i class="fa fa-refresh"></i>
			<?php _e('Refresh','easy-appointments');?>
		</a>
		<span id="status-msg" class="status"></span>
	</h2>
	<table class="wp-list-table widefat fixed">
		<thead>
			<tr>
				<th class="manage-column column-title column-5">Id</th>
				<th class="manage-column column-title"><?php _e('Name','easy-appointments');?></th>
				<th class="manage-column column-title"><?php _e('Description','easy-appointments');?></th>
				<th class="manage-column column-title"><?php _e('Email','easy-appointments');?></th>
				<th class="manage-column column-title"><?php _e('Phone','easy-appointments');?></th>
				<th class="manage-column column-title column-15"><?php _e('Actions','easy-appointments');?></th>
			</tr>
		</head>
		<tbody id="ea-staff">
			
		</tbody>
	</table>
</div>
</script>

<script type="text/template" id="ea-tpl-worker-row">
	<td><%= row.id %></td>
	<td class="post-title page-title column-title">
		<strong><%= row.name %></strong>
	</td>
	<td>
		<strong><%= row.description %></strong>
	</td>
	<td>
		<strong><%= row.email %></strong>
	</td>
	<td>
		<strong><%= row.phone %></strong>
	</td>
	<td>
		<button class="button btn-edit"><?php _e('Edit','easy-appointments');?></button>
		<button class="button btn-del"><?php _e('Delete','easy-appointments');?></button>
	</td>
</script>

<script type="text/template" id="ea-tpl-worker-row-edit">
	<td><%= row.id %></td>
	<td><input type="text" data-prop="name" value="<%= row.name %>"></td>
	<td><input type="text" data-prop="description" value="<%= row.description %>"></td>
	<td><input type="text" data-prop="email" value="<%= row.email %>"></td>
	<td><input type="text" data-prop="phone" value="<%= row.phone %>"></td>
	<td>
		<button class="button button-primary btn-save"><?php _e('Save','easy-appointments');?></button>
		<button class="button btn-cancel"><?php _e('Cancel','easy-appointments');?></button>
	</td>
</script>

<!-- Connections -->
<script type="text/template" id="ea-tpl-connections-table">
<div>
	<h2>
		<a href="#" class="add-new-h2 add-new">
			<i class="fa fa-plus"></i>
			<?php _e('Add New Connection','easy-appointments');?>
		</a>
		<a href="#" class="add-new-h2 refresh-list">
			<i class="fa fa-refresh"></i>
			<?php _e('Refresh','easy-appointments');?>
		</a>
		<span id="status-msg" class="status"></span>
	</h2>
	<table class="wp-list-table widefat fixed">
		<thead>
			<tr>
				<th colspan="4" class="manage-column column-title">Id / <?php _e('Location','easy-appointments');?> / <?php _e('Service','easy-appointments');?> / <?php _e('Worker','easy-appointments');?></th>
				<th colspan="2" class="manage-column column-title"><?php _e('Days of week','easy-appointments');?></th>
				<th colspan="2" class="manage-column column-title">
					<?php _e('Time','easy-appointments');?>
				</th>
				<th colspan="2" class="manage-column column-title">
					<?php _e('Date','easy-appointments');?>
				</th>
				<th class="manage-column column-title"><?php _e('Is working','easy-appointments');?></th>
				<th class="manage-column column-title column-15"><?php _e('Actions','easy-appointments');?></th>
			</tr>
		</head>
		<tbody id="ea-connections">
			
		</tbody>
	</table>
</div>
</script>

<script type="text/template" id="ea-tpl-connection-row">
	<td colspan="4" class="table-row-td">
		#<%= row.id %>
		<br>
		<p> 
			<strong>
				<%= _.findWhere(locations, {id:row.location}).name  %>
			</strong>
		</p>
		<p>
			<strong>
				<%= _.findWhere(services, {id:row.service}).name  %>
			</strong>
		</p>
		<p>
			<strong>
				<%= _.findWhere(workers, {id:row.worker}).name  %>
			</strong>
		</p>
	</td>
	<td colspan="2">
		<% _.each(row.day_of_week, function(item,key,list) { %>
		<span><%= item %></span><br>
		<% }); %>
	</td>
	<td colspan="2">
		<p class="label-up"><?php _e('Starts at','easy-appointments');?> :</p>
		<strong><%= row.time_from %></strong><br>
		<p class="label-up"><?php _e('ends at','easy-appointments');?> :</p>
		<strong><%= row.time_to %></strong>
	</td>
	<td colspan="2">
		<p class="label-up"><?php _e('Active from','easy-appointments');?> :</p>
		<strong><%= row.day_from %></strong><br>
		<p class="label-up"><?php _e('to','easy-appointments');?> :</p>
		<strong><%= row.day_to %></strong>
	</td>
	<td>
		<strong>
			<% if(row.is_working == 0) { %>
				<?php _e('No','easy-appointments');?>
			<% } else { %>
				<?php _e('Yes','easy-appointments');?>
			<% } %>
		</strong>
	</td>
	<td class="action-center">
		<button class="button btn-edit"><?php _e('Edit','easy-appointments');?></button><br>
		<button class="button btn-del"><?php _e('Delete','easy-appointments');?></button><br>
		<button class="button btn-clone"><?php _e('Clone','easy-appointments');?></button><br>
	</td>
</script>

<script type="text/template" id="ea-tpl-connection-row-edit">
	<td colspan="4">
		#<%= row.id %><br>
		<select data-prop="location">
			<option value=""> -- <?php _e('Location','easy-appointments');?> -- </option>
	<% _.each(locations,function(item,key,list){
		if(item.id == row.location) { %>
			<option value="<%= item.id %>" selected="selected"><%= item.name %></option>
	<% } else { %>
			<option value="<%= item.id %>"><%= item.name %></option>
	<% }
		});%>
		</select>
		<br>
		<select data-prop="service">
			<option value=""> -- <?php _e('Service','easy-appointments');?> -- </option>
	<% _.each(services,function(item,key,list){
		// create variables
		if(item.id == row.service) { %>
			<option value="<%= item.id %>" selected="selected"><%= item.name %></option>
	<% } else { %>
			<option value="<%= item.id %>"><%= item.name %></option>
	<% }
		});%>
		</select>
		<br>
		<select data-prop="worker">
			<option value=""> -- <?php _e('Worker','easy-appointments');?> -- </option>
	<% _.each(workers,function(item,key,list){
          // create variables
        if(item.id == row.worker) { %>
        	<option value="<%= item.id %>" selected="selected"><%= item.name %></option>
     <% } else { %>
          	<option value="<%= item.id %>"><%= item.name %></option>
     <% }
    	});%>
		</select>
    </td>
	<td colspan="2">
		<select data-prop="day_of_week" size="7" multiple>
	<% var weekdays = [
	        { id: "Monday", name: "<?php _e('Monday','easy-appointments');?>"},
	        { id: "Tuesday", name: "<?php _e('Tuesday','easy-appointments');?>"},
	        { id: "Wednesday", name: "<?php _e('Wednesday','easy-appointments');?>"},
	        { id: "Thursday", name: "<?php _e('Thursday','easy-appointments');?>"},
	        { id: "Friday", name: "<?php _e('Friday','easy-appointments');?>"},
	        { id: "Saturday", name: "<?php _e('Saturday','easy-appointments');?>"},
	        { id: "Sunday", name: "<?php _e('Sunday','easy-appointments');?>"}
	    ];
	  _.each(weekdays,function(item,key,list){
          // create variables
        if(_.indexOf(row.day_of_week, item.name) !== -1) { %>
        	<option value="<%= item.name %>" selected="selected"><%= item.name %></option>
     <% } else { %>
          	<option value="<%= item.name %>"><%= item.name %></option>
     <% }
     });%>
		</select>
	</td>
	<td colspan="2">
		<strong><?php _e('Start', 'easy-appointments');?> :</strong><br>
		<input type="text" data-prop="time_from" class="time-from" value="<%= row.time_from %>"><br>
		<strong><?php _e('End', 'easy-appointments');?> :</strong><br>
		<input type="text" data-prop="time_to" class="time-to" value="<%= row.time_to %>">
	</td>
	<td colspan="2">
		<strong>&nbsp;</strong><br>
		<input type="text" data-prop="day_from" class="day-from" value="<%= row.day_from %>"><br>
		<strong>&nbsp;</strong><br>
		<input type="text" data-prop="day_to" class="day-to" value="<%= row.day_to %>">
	</td>
	<td>
		<select data-prop="is_working" name="">
			<% if(row.is_working == 0) { %>
			<option value="0" selected="selected"><?php _e('No', 'easy-appointments');?></option>
			<option value="1"><?php _e('Yes', 'easy-appointments');?></option>
			<% } else { %>
			<option value="0"><?php _e('No', 'easy-appointments');?></option>
			<option value="1" selected="selected"><?php _e('Yes', 'easy-appointments');?></option>
			<% } %>
		</select>
	</td>
	<td class="action-center">
		<button class="button button-primary btn-save"><?php _e('Save', 'easy-appointments');?></button>
		<button class="button btn-cancel"><?php _e('Cancel', 'easy-appointments');?></button>
	</td>
</script>

<script type="text/template" id="ea-tpl-custumize">
	<div class="wp-filter">
		<h2><?php _e('Connections', 'easy-appointments');?> :</h2>
		<table class="form-table form-table-translation">
			<tbody>
				<tr>
					<th class="row">
						<label for=""><?php _e('Multiple work', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input class="field" data-key="multiple.work" name="multiple.work" type="checkbox" <% if (_.findWhere(settings, {ea_key:'multiple.work'}).ea_value == "1") { %>checked<% } %>>
					</td>
					<td>
						<span class="description"> <?php _e('Mark this option if you want to calculate free worker slots only by current service and location. If it\'s not marked system will check if worker is working on any location and service at current time.', 'easy-appointments');?></span>
					</td>
				</tr>
			</body>
		</table>
		<hr class="divider">
		<h2><?php _e('Mail', 'easy-appointments');?> : </h2>
		<h3><?php _e('Notifications', 'easy-appointments');?></h3>
		<p class="notifications-help"><?php _e('You can use this tags inside email content', 'easy-appointments');?> : <strong>#id#, #date#, #start#, #end#, #status#, #created#, #price#, #ip#, #service_name#, #worker_name#, #location_name#, <span id="custom-tags"></span></strong></p>
		<table class='notifications form-table'>
			<tbody>
				<tr>
					<td>
						<h4><?php _e('Pending', 'easy-appointments');?></h4>
						<textarea class="field" data-key="mail.pending"><%= _.findWhere(settings, {ea_key:'mail.pending'}).ea_value %></textarea>
					</td>
					<td>
						<h4><?php _e('Reservation', 'easy-appointments');?></h4>
						<textarea class="field" data-key="mail.reservation"><%= _.findWhere(settings, {ea_key:'mail.reservation'}).ea_value %></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<h4><?php _e('Canceled', 'easy-appointments');?></h4>
						<textarea class="field" data-key="mail.canceled"><%= _.findWhere(settings, {ea_key:'mail.canceled'}).ea_value %></textarea>
					</td>
					<td>
						<h4><?php _e('Confirmed', 'easy-appointments');?></h4>
						<textarea class="field" data-key="mail.confirmed"><%= _.findWhere(settings, {ea_key:'mail.confirmed'}).ea_value %></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="form-table form-table-translation">
			<tbody>
				<tr>
					<th class="row">
						<label for=""><?php _e('Pending notification emails', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input style="width: 300px" class="field" data-key="pending.email" name="currency" type="text" value="<%= _.findWhere(settings, {ea_key:'pending.email'}).ea_value %>"><br>
					</td>
					<td>
						<span class="description"> <?php _e('Enter email adress that will recive new reservation notification. Separate multiple emails with , (comma)', 'easy-appointments');?></span>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label for=""><?php _e('Send email to user', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input class="field" data-key="send.user.email" name="send.user.email" type="checkbox" <% if (_.findWhere(settings, {ea_key:'send.user.email'}).ea_value == "1") { %>checked<% } %>><br>
					</td>
					<td>
						<span class="description"> <?php _e('Mark this option if you want to user recive email after filing the form.', 'easy-appointments');?></span>
					</td>
				</tr>
			</tbody>
		</table>
		<hr class="divider">
		<h2><?php _e('Labels', 'easy-appointments');?> :</h2>
		<table class="form-table form-table-translation">
			<tbody>
				<tr>
					<th class="row">
						<label for=""><?php _e('Service', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input class="field" data-key="trans.service" name="service" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.service'}).ea_value %>"><br>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label for=""><?php _e('Location', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input class="field" data-key="trans.location" name="location" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.location'}).ea_value %>"><br>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label for=""><?php _e('Worker', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input  class="field" data-key="trans.worker" name="worker" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.worker'}).ea_value %>"><br>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label for=""><?php _e('Done message', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input class="field" data-key="trans.done_message" name="done_message" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.done_message'}).ea_value %>"><br>
					</td>
					<td>
						<span class="description"> <?php _e('Message that user recive after completing appointment', 'easy-appointments');?></span>
					</td>
				</tr>
			</tbody>
		</table>
		<hr class="divider">
		<h2><?php _e('Date & Time', 'easy-appointments');?> : </h2>
		<table class="form-table form-table-translation">
			<tbody>
				<tr>
					<th class="row">
						<label><?php _e('Time format', 'easy-appointments');?> :</label>
					</th>
					<td>
						<select data-key="time_format" class="field" name="time_format">
							<option value="00-24" <% if (_.findWhere(settings, {ea_key:'time_format'}).ea_value === "00-24") { %>selected="selected"<% } %>>00-24</option>
							<option value="am-pm" <% if (_.findWhere(settings, {ea_key:'time_format'}).ea_value === "am-pm") { %>selected="selected"<% } %>>AM-PM</option>
						</select>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label><?php _e('Calendar localization', 'easy-appointments');?> :</label>
					</th>
					<td>
						<select data-key="datepicker" class="field" name="datepicker">
					<% var langs = [
						'af','ar','ar-DZ','az','be','bg','bs','ca','cs','cy-GB','da','de','el','en','en-AU','en-GB','en-NZ','en-US','eo','es','et','eu','fa','fi','fo','fr','fr-CA','fr-CH','gl','he','hi','hr','hu','hy','id','is','it','it-CH','ja','ka','kk','km','ko','ky','lb','lt','lv','mk','ml','ms','nb','nl','nl-BE','nn','no','pl','pt','pt-BR','rm','ro','ru','sk','sl','sq','sr','sr-SR','sv','ta','th','tj','tr','uk','vi','zh-CN','zh-HK','zh-TW'
					];
					_.each(langs,function(item,key,list){
						if(_.findWhere(settings, {ea_key:'datepicker'}).ea_value === item) { %>
							<option value="<%= item %>" selected="selected"><%= item %></option>
						<% } else { %>
							<option value="<%= item %>"><%= item %></option>
						<% }
						});%>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<hr class="divider">
		<h2><?php _e('Custom form fields', 'easy-appointments');?> - <small>Create all fields that you need. Custom order them by drag and drop.</small></h2>
		<table class="form-table">
			<tbody>
				<tr>
					<th colspan="2">
						<span>Name :</span>
						<input type="text">
						<span>Type :</span>
						<select>
							<option value="INPUT">Input</option>
							<option value="SELECT">Select</option>
							<option value="TEXTAREA">Textarea</option>
						</select>
						<button class="button button-primary btn-add-field"><?php _e('Add', 'easy-appointments');?></button>
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<ul id="custom-fields"></ul>
					</td>
				</tr>
			</tbody>
		</table>
		<hr class="divider">
		<h2>Form</h2>
		<table class="form-table">
			<tbody>
				<tr>
					<th class="row">
						<label for=""><?php _e('Custom style', 'easy-appointments');?> :</label>
					</th>
					<td class="custom-css">
						<textarea class="field" data-key="custom.css"><% if (typeof _.findWhere(settings, {ea_key:'custom.css'}) !== 'undefined') { %><%= (_.findWhere(settings, {ea_key:'custom.css'})).ea_value %><% } %></textarea>
					</td>
					<td>
						<span class="description"> <?php _e('Place here custom css styles. This will be included in both standard and bootstrap widget.', 'easy-appointments');?></span>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="form-table">
			<tbody>
				<tr>
					<th class="row">
						<label for=""><?php _e('I agree field', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input class="field" type="checkbox" name="show.iagree" data-key="show.iagree"<% if (typeof _.findWhere(settings, {ea_key:'show.iagree'}) !== 'undefined' && _.findWhere(settings, {ea_key:'show.iagree'}).ea_value == '1') { %>checked<% } %> />
					</td>
					<td>
						<span class="description"> <?php _e('I agree option at the end of form. If this is marked user must confirme "I agree" checkbox.', 'easy-appointments');?></span>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label><?php _e('After cancel scroll to', 'easy-appointments');?> :</label>
					</th>
					<td>
						<select data-key="cancel.scroll" class="field" name="cancel.scroll">
					<% var langs = [
						'calendar','worker', 'service', 'location'
					];
					_.each(langs,function(item,key,list){
						if(typeof _.findWhere(settings, {ea_key:'cancel.scroll'}) !== 'undefined' && _.findWhere(settings, {ea_key:'cancel.scroll'}).ea_value === item) { %>
							<option value="<%= item %>" selected="selected"><%= item %></option>
						<% } else { %>
							<option value="<%= item %>"><%= item %></option>
						<% }
						});%>
						</select>
					</td>
				</tr>
			</body>
		</table>
		<h2>Money</h2>
		<table class="form-table form-table-translation">
			<tbody>
				<tr>
					<th class="row">
						<label for=""><?php _e('Currency', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input class="field" data-key="trans.currency" name="currency" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.currency'}).ea_value %>"><br>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label for=""><?php _e('Hide price', 'easy-appointments');?> :</label>
					</th>
					<td>
						<input class="field" data-key="price.hide" name="price.hide" type="checkbox" <% if (_.findWhere(settings, {ea_key:'price.hide'}).ea_value == "1") { %>checked<% } %>><br>
					</td>
				</tr>
			</body>
		</table>
		<br><br>
		<button class="button button-primary btn-save-settings"><?php _e('Save', 'easy-appointments');?></button>
		<br><br>
	</div>
</script>

<script type="text/template" id="ea-tpl-custom-forms">
	<li data-name="<%= item.label %>" style="display: list-item;">
		<div class="menu-item-bar">
			<div class="menu-item-handle">
				<span class="item-title"><span class="menu-item-title"><%= item.label %></span> <span class="is-submenu" style="display: none;">sub item</span></span>
				<span class="item-controls">
					<span class="item-type"><%= item.type %></span>
						<a class="single-field-options"><i class="fa fa-chevron-down"></i></a>
				</span>
			</div>
		</div>
	</li>
</script>

<script type="text/template" id="ea-tpl-custom-form-options">
<div class="field-settings">
	<p>
		<label>Label :</label><input type="text" class="field-label" name="field-label" value="<%= item.label %>">
	</p>
	<% if (item.type === "SELECT") { %>
		<p>
			<label>Options :</label>
		</p>
		<p>
			<ul class="select-options">
			<% _.each(item.options, function(element) { %>
				<li data-element="<%= element %>"><%= element %><a href="#" class="remove-select-option"><i class="fa fa-trash-o"></i></a></li>
			<% }); %>
			</ul>
		</p>
		<p><input type="text"><a href="#" class="add-select-option">&nbsp;&nbsp;<i class="fa fa-plus"></i> Add option</a></p>
	<% } %>
	<p>
		<label>Required :</label><input type="checkbox" class="required" name="required" <% if (item.required == "1") { %>checked<% } %>>
	</p>
	<p>
		<label>Visible :</label><input type="checkbox" class="visible" name="visible" <% if (item.visible == "1") { %>checked<% } %>>
	</p>
	<p><a href="#" class="deletion item-delete">Delete</a> | <a href="#" class="item-save">Apply</a></p>
</div>
</script>
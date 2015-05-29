<script type="text/template" id="ea-settings-main">
<?php 
	get_current_screen()->render_screen_meta();
?>
	<div class="wrap">
		<ul id="tab-header">
			<li>
				<a href="#locations/">
					<i class="fa fa-map-marker"></i>
					Locations
				</a>
			</li>
			<li>
				<a href="#services/">
					<i class="fa fa-cube"></i>
					Services
				</a>
			</li>
			<li>
				<a href="#staff/">
					<i class="fa fa-user"></i>
					Staff
				</a>
			</li>
			<li>
				<a href="#connection/">
					<i class="fa fa-sitemap"></i>
					Connections
				</a>
			</li>
			<li>
				<a href="#custumize/">
					<i class="fa fa-paint-brush"></i>
					Customize
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
			Add New Location
		</a>
		<a href="#" class="add-new-h2 refresh-list">
			<i class="fa fa-refresh"></i>
			Refresh
		</a>
		<span id="status-msg" class="status"></span>
	</h2>
	<table class="wp-list-table widefat fixed">
		<thead>
			<tr>
				<th class="manage-column column-title column-5">Id</th>
				<th class="manage-column column-title">Name</th>
				<th class="manage-column column-title">Address</th>
				<th class="manage-column column-title">Location</th>
				<th class="manage-column column-title column-15">Actions</th>
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
		<button class="button btn-edit">Edit</button>
		<button class="button btn-del">Delete</button>
	</td>
</script>

<script type="text/template" id="ea-tpl-locations-row-edit">
	<td><%= row.id %></td>
	<td><input type="text" data-prop="name" value="<%= row.name %>"></td>
	<td><input type="text" data-prop="address" value="<%= row.address %>"></td>
	<td><input type="text" data-prop="location" value="<%= row.location %>"></td>
	<td>
		<button class="button button-primary btn-save">Save</button>
		<button class="button btn-cancel">Cancel</button>
	</td>
</script>

<script type="text/template" id="ea-tpl-services-table">
<div>
	<h2>
		<a href="#" class="add-new-h2 add-new">
			<i class="fa fa-plus"></i>
			Add New Service
		</a>
		<a href="#" class="add-new-h2 refresh-list">
			<i class="fa fa-refresh"></i>
			Refresh
		</a>
		<span id="status-msg" class="status"></span>
	</h2>
	<table class="wp-list-table widefat fixed">
		<thead>
			<tr>
				<th class="manage-column column-title column-5">Id</th>
				<th class="manage-column column-title">Name</th>
				<th class="manage-column column-title">Duration (min)</th>
				<th class="manage-column column-title">Price</th>
				<th class="manage-column column-title column-15">Actions</th>
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
		<button class="button btn-edit">Edit</button>
		<button class="button btn-del">Delete</button>
	</td>
</script>

<script type="text/template" id="ea-tpl-services-row-edit">
	<td><%= row.id %></td>
	<td><input type="text" data-prop="name" value="<%= row.name %>"></td>
	<td><input type="text" data-prop="duration" value="<%= row.duration %>"></td>
	<td><input type="text" data-prop="price" value="<%= row.price %>"></td>
	<td>
		<button class="button button-primary btn-save">Save</button>
		<button class="button btn-cancel">Cancel</button>
	</td>
</script>

<!-- Staff -->
<script type="text/template" id="ea-tpl-staff-table">
<div>
	<h2>
		<a href="#" class="add-new-h2 add-new">
			<i class="fa fa-plus"></i>
			Add New Worker
		</a>
		<a href="#" class="add-new-h2 refresh-list">
			<i class="fa fa-refresh"></i>
			Refresh
		</a>
		<span id="status-msg" class="status"></span>
	</h2>
	<table class="wp-list-table widefat fixed">
		<thead>
			<tr>
				<th class="manage-column column-title column-5">Id</th>
				<th class="manage-column column-title">Name</th>
				<th class="manage-column column-title">Description</th>
				<th class="manage-column column-title">Email</th>
				<th class="manage-column column-title">Phone</th>
				<th class="manage-column column-title column-15">Actions</th>
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
		<button class="button btn-edit">Edit</button>
		<button class="button btn-del">Delete</button>
	</td>
</script>

<script type="text/template" id="ea-tpl-worker-row-edit">
	<td><%= row.id %></td>
	<td><input type="text" data-prop="name" value="<%= row.name %>"></td>
	<td><input type="text" data-prop="description" value="<%= row.description %>"></td>
	<td><input type="text" data-prop="email" value="<%= row.email %>"></td>
	<td><input type="text" data-prop="phone" value="<%= row.phone %>"></td>
	<td>
		<button class="button button-primary btn-save">Save</button>
		<button class="button btn-cancel">Cancel</button>
	</td>
</script>

<!-- Connections -->
<script type="text/template" id="ea-tpl-connections-table">
<div>
	<h2>
		<a href="#" class="add-new-h2 add-new">
			<i class="fa fa-plus"></i>
			Add New Connection
		</a>
		<a href="#" class="add-new-h2 refresh-list">
			<i class="fa fa-refresh"></i>
			Refresh
		</a>
		<span id="status-msg" class="status"></span>
	</h2>
	<table class="wp-list-table widefat fixed">
		<thead>
			<tr>
				<th colspan="4" class="manage-column column-title">Id / Location / Service / Worker</th>
				<th colspan="2" class="manage-column column-title">Days of week</th>
				<th colspan="2" class="manage-column column-title">
					Time
				</th>
				<th colspan="2" class="manage-column column-title">
					Date
				</th>
				<th class="manage-column column-title">Is working</th>
				<th class="manage-column column-title column-15">Actions</th>
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
		<p class="label-up">Starts at :</p>
		<strong><%= row.time_from %></strong><br>
		<p class="label-up">ends at :</p>
		<strong><%= row.time_to %></strong>
	</td>
	<td colspan="2">
		<p class="label-up">Active from :</p>
		<strong><%= row.day_from %></strong><br>
		<p class="label-up">to :</p>
		<strong><%= row.day_to %></strong>
	</td>
	<td>
		<strong>
			<% if(row.is_working == 0) { %>
				No
			<% } else { %>
				Yes
			<% } %>
		</strong>
	</td>
	<td class="action-center">
		<button class="button btn-edit">Edit</button><br>
		<button class="button btn-del">Delete</button><br>
		<button class="button btn-clone">Clone</button><br>
	</td>
</script>

<script type="text/template" id="ea-tpl-connection-row-edit">
	<td colspan="4">
		#<%= row.id %><br>
		<select data-prop="location">
			<option value=""> -- Location -- </option>
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
			<option value=""> -- Service -- </option>
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
			<option value=""> -- Worker -- </option>
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
	        { id: "Monday", name: "Monday"},
	        { id: "Tuesday", name: "Tuesday"},
	        { id: "Wednesday", name: "Wednesday"},
	        { id: "Thursday", name: "Thursday"},
	        { id: "Friday", name: "Friday"},
	        { id: "Saturday", name: "Saturday"},
	        { id: "Sunday", name: "Sunday"}
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
		<strong>Start :</strong><br>
		<input type="text" data-prop="time_from" class="time-from" value="<%= row.time_from %>"><br>
		<strong>End :</strong><br>
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
			<option value="0" selected="selected">No</option>
			<option value="1">Yes</option>
			<% } else { %>
			<option value="0">No</option>
			<option value="1" selected="selected">Yes</option>	
			<% } %>

		</select>
	</td>
	<td class="action-center">
		<button class="button button-primary btn-save">Save</button>
		<button class="button btn-cancel">Cancel</button>
	</td>
</script>

<script type="text/template" id="ea-tpl-custumize">
	<div class="wp-filter">
		<h2>Mail: </h2>
		<h3>Notifications</h3>
		<p class="notifications-help">You can use this tags inside email content : <strong>#name#, #email#, #address#</strong></p>
		<table class='notifications form-table'>
			<tbody>
				<tr>
					<td>
						<h4>Pending</h4>
						<textarea class="field" data-key="mail.pending"><%= _.findWhere(settings, {ea_key:'mail.pending'}).ea_value %></textarea>
					</td>
					<td>
						<h4>Reservation</h4>
						<textarea class="field" data-key="mail.reservation"><%= _.findWhere(settings, {ea_key:'mail.reservation'}).ea_value %></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<h4>Canceled</h4>
						<textarea class="field" data-key="mail.canceled"><%= _.findWhere(settings, {ea_key:'mail.canceled'}).ea_value %></textarea>
					</td>
					<td>
						<h4>Confirmed</h4>
						<textarea class="field" data-key="mail.confirmed"><%= _.findWhere(settings, {ea_key:'mail.confirmed'}).ea_value %></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		<h2>Translation: </h2>
		<table class="form-table form-table-translation">
			<tbody>
				<tr>
					<th class="row">
						<label for="">Service :</label>
					</th>
					<td>
						<input class="field" data-key="trans.service" name="service" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.service'}).ea_value %>"><br>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label for="">Location :</label>
					</th>
					<td>
						<input class="field" data-key="trans.location" name="location" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.location'}).ea_value %>"><br>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label for="">Worker :</label>
					</th>
					<td>
						<input  class="field" data-key="trans.worker" name="worker" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.worker'}).ea_value %>"><br>
					</td>
				</tr>
				<tr>
					<th class="row">
						<label for="">Done message :</label>
					</th>
					<td>
						<input class="field" data-key="trans.done_message" name="done_message" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.done_message'}).ea_value %>"><br>
					</td>
				</tr>
			</tbody>
		</table>
		<h2>Date/Time: </h2>
		<table class="form-table form-table-translation">
			<tbody>
				<tr>
					<th class="row">
						<label>Time format :</label>
					</th>
					<td>
						<select data-key="time_format" class="field" name="time_format">
							<option value="00-24" <% if (_.findWhere(settings, {ea_key:'time_format'}).ea_value === "00-24") { %>selected="selected"<% } %>>00-24</option>
							<option value="am-pm" <% if (_.findWhere(settings, {ea_key:'time_format'}).ea_value === "am-pm") { %>selected="selected"<% } %>>AM-PM</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<h2>Money</h2>
		<table class="form-table form-table-translation">
			<tbody>
				<tr>
					<th class="row">
						<label for="">Currency :</label>
					</th>
					<td>
						<input class="field" data-key="trans.currency" name="currency" type="text" value="<%= _.findWhere(settings, {ea_key:'trans.currency'}).ea_value %>"><br>
					</td>
				</tr>
			</body>
		</table>
		<br><br>
		<button class="button button-primary btn-save-settings">Save</button>
		<br><br>
	</div>
</script>
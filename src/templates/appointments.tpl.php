<script type="text/template" id="ea-appointments-main">
<?php 
	get_current_screen()->render_screen_meta();
?>
	<div class="wrap">
		<h2>Appointments</h2>
		<br>
		<table class="filter-part wp-filter">
			<tbody>
				<tr>
					<td class="filter-label"><label for="ea-filter-locations"><strong>Location :</strong></label></td>
					<td class="filter-select">
						<select name="ea-filter-locations" id="ea-filter-locations" data-c="location">
							<option value="">-</option>
							<% _.each(cache.Locations,function(item,key,list){ %>
								<option value="<%= item.id %>"><%= item.name %></option>
							<% });%>
						</select>
					</td>
					<td class="filter-label"><label for="ea-filter-services"><strong>Service :</strong></label></td>
					<td class="filter-select">
						<select name="ea-filter-services" id="ea-filter-services" data-c="service">
							<option value="">-</option>
							<% _.each(cache.Services,function(item,key,list){ %>
								<option value="<%= item.id %>"><%= item.name %></option>
							<% });%>
						</select>
					</td>
					<td class="filter-label"><label for="ea-filter-from"><strong>From :</strong></label></td>
					<td><input class="date-input" type="text" name="ea-filter-from" id="ea-filter-from" data-c="from"></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td class="filter-label"><label for="ea-filter-workers"><strong>Staff :</strong></label></td>
					<td class="filter-select">
						<select name="ea-filter-workers" id="ea-filter-workers" data-c="worker">
							<option value="">-</option>
							<% _.each(cache.Workers,function(item,key,list){ %>
								<option value="<%= item.id %>"><%= item.name %></option>
							<% });%>
						</select>
					</td>
					<td class="filter-label"><label for="ea-filter-status"><strong>Status :</strong></label></td>
					<td class="filter-select">
						<select name="ea-filter-status" id="ea-filter-status" data-c="status">
							<option value="">-</option>
							<% _.each(cache.Status,function(item,key,list){ %>
								<option value="<%= item %>"><%= item %></option>
							<% });%>
						</select>
					</td>
					<td class="filter-label"><label for="ea-filter-to"><strong>To :</strong></label></td>
					<td><input class="date-input" type="text" name="ea-filter-to" id="ea-filter-to" data-c="to"></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<h2>
			<a href="#" class="add-new-h2 add-new">
				<i class="fa fa-plus"></i>
				Add New Appointment
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
					<th colspan="2" class="manage-column column-title">Id / Location / Service / Worker</th>
					<th colspan="2" class="manage-column column-title">Custumer</th>
					<th class="manage-column column-title">Date / time</th>
					<th class="manage-column column-title">Descrtiption</th>
					<th class="manage-column column-title">Status / Price / Created</th>
					<th class="manage-column column-title">Action</th>
				</tr>
			</thead>
			<tbody id="ea-appointments">
			</tbody>
		</table>
	</div>
</script>

<script type="text/template" id="ea-tpl-appointment-row">
	<td colspan="2" class="post-title page-title column-title">
		#<%= row.id %><br>
		<strong><%= _.findWhere(cache.Locations, {id:row.location}).name  %></strong>
		<strong><%= _.findWhere(cache.Services, {id:row.service}).name  %></strong>
		<strong><%= _.findWhere(cache.Workers, {id:row.worker}).name  %></strong>
	</td>
	<td colspan="2">
		<strong><%= row.name %></strong><br>
		<strong><%= row.email %></strong><br>
		<strong><%= row.phone %></strong>
	</td>
	<td>
		<strong><%= row.date %></strong><br>
		<strong><%= row.start %></strong>
	</td>
	<td>
		<strong><%= row.description %></strong>
	</td>
	<td>
		<strong><%= row.status %></strong><br>
		<!-- <strong><%= row.user %></strong><br> -->
		<strong><%= row.price %></strong><br>
		<strong><%= row.created %></strong>
	</td>
	<td class="action-center">
		<button class="button btn-edit">Edit</button>
		<button class="button btn-del">Delete</button>
	</td>
</script>

<script type="text/template" id="ea-tpl-appointment-row-edit">
<td colspan="8">
	<table>
		<tbody>
			<tr>
				<td colspan="2">
					<select class="app-fields" name="ea-input-locations" id="ea-input-locations" data-prop="location">
						<option value=""> -- Location -- </option>
						<% _.each(cache.Locations,function(item,key,list){
						if(item.id == row.location) { %>
							<option value="<%= item.id %>" selected="selected"><%= item.name %></option>
					     <% } else { %>
					          	<option value="<%= item.id %>"><%= item.name %></option>
					     <% }
					    });%>
					</select><br>
					<select class="app-fields ea-service" name="ea-input-services" id="ea-input-services" data-prop="service">
						<option value=""> -- Service -- </option>
						<% _.each(cache.Services,function(item,key,list){
				        	if(item.id == row.service) { %>
					        	<option value="<%= item.id %>" data-duration="<%= item.duration %>" data-price="<%= item.price %>" selected="selected"><%= item.name %></option>
					     <% } else { %>
					          	<option value="<%= item.id %>" data-duration="<%= item.duration %>"  data-price="<%= item.price %>"><%= item.name %></option>
					     <% }
					    });%>
					</select><br>
					<select class="app-fields" name="ea-input-workers" id="ea-input-workers" data-prop="worker">
						<option value=""> -- Worker -- </option>
						<% _.each(cache.Workers,function(item,key,list){
				        	if(item.id == row.worker) { %>
					        	<option value="<%= item.id %>" selected="selected"><%= item.name %></option>
					     <% } else { %>
					          	<option value="<%= item.id %>"><%= item.name %></option>
					     <% }
					    });%>
					</select>
				</td>
				<td colspan="2">
					<input type="text" data-prop="name" placeholder="Name" value="<%= row.name %>"><br>
					<input type="text" data-prop="email" placeholder="Email" value="<%= row.email %>"><br>
					<input type="text" data-prop="phone" placeholder="Phone" value="<%= row.phone %>">
				</td>
				<td>
					<p>Date :</p>
					<input class="app-fields date-start" type="text" data-prop="date" value="<%= row.date %>"><br>
					<p>Time :</p>
					<select data-prop="start" disabled="disabled" class="time-start">
						
					</select>
				</td>
				<td colspan="2">
					<textarea rows="5" data-prop="description"><%= row.description %></textarea><br>
				</td>
				<td>
					<select name="ea-select-status" data-prop="status">
						<% _.each(cache.Status,function(item,key,list){
				        	if(item == row.status) { %>
					        	<option value="<%= item %>" selected="selected"><%= item %></option>
					     <% } else { %>
					          	<option value="<%= item %>"><%= item %></option>
					     <% }
					    });%>
					</select>
					<span>Price : </span><input class="ea-price" style="width: 50px" type="text" data-prop="price" value="<%= row.price %>">
					<!-- <strong><%= row.user %></strong><br>
					<strong><%= row.created %></strong>-->
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<label for="send-mail"> Send email notificationy : </label>
					<input name="send-mail" type="checkbox">
				</td>
				<td colspan="2" style="text-align: right;">
					<button class="button button-primary btn-save">Save</button>
					<button class="button btn-cancel">Cancel</button>
				</td>
			</tr>
		</tbody>
	</table>
</td>
</script>

<script type="text/template" id="ea-tpl-appointment-times">
<% _.each(times,function(item,key,list){ 
	if(app.start === item.value) { %>
	<option value="<%= item.value %>" selected="selected"><%= item.show %></option>
	<% } else { %>
		<option value="<%= item.value %>" <% if(item.count === 0) {%>disabled<% } %>><%= item.show %></option>
	<% } %>
<% });%>
</script>
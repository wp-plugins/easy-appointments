<script type="text/template" id="ea-report-main">
<div class="report-container">
	<ul class="reports">
		<li class="report" data-report="overview">
			<a>
				<i class="fa fa-table"></i>
				<span><?php _e('Time table', 'easy-appointments');?></span>
			</a>
		</li>
		<li class="report" data-report="money">
			<a class="disabled">
				<i class="fa fa-money"></i>
				<span><?php _e('Money', 'easy-appointments');?></span>
			</a>
		</li>
		<li class="report" data-report="Export">
			<a class="disabled">
				<i class="fa fa-file-excel-o"></i>
				<span><?php _e('Export', 'easy-appointments');?></span>
			</a>
		</li>
	</ul>
	<div id="report-content">
		<div class="report-message"><?php _e('Click on menu icon to open report.', 'easy-appointments');?><br> <?php _e('New reports are comming soon!', 'easy-appointments');?></div>
	</div>
</div>
</script>

<!-- template for overview report -->
<script type="text/template" id="ea-report-overview">
	<div class="filter-select">
		<label htmlFor=""><?php _e('Location', 'easy-appointments');?> :</label>
		<select name="location" id="overview-location">
			<option value="">-</option>
			<% _.each(cache.Locations,function(item,key,list){ %>
				<option value="<%= item.id %>"><%= item.name %></option>
			<% });%>
		</select>
		<label htmlFor=""><?php _e('Service', 'easy-appointments');?> :</label>
		<select name="service" id="overview-service">
			<option value="">-</option>
			<% _.each(cache.Services,function(item,key,list){ %>
				<option value="<%= item.id %>"><%= item.name %></option>
			<% });%>
		</select>
		<label htmlFor=""><?php _e('Worker', 'easy-appointments');?> :</label>
		<select name="worker" id="overview-worker">
			<option value="">-</option>
			<% _.each(cache.Workers,function(item,key,list){ %>
				<option value="<%= item.id %>"><%= item.name %></option>
			<% });%>
		</select>
		<span>&nbsp&nbsp;</span>
		<button class=".refresh button-primary"><?php _e('Refresh', 'easy-appointments');?></button><br><br>
		<div name="month" class="datepicker" id="overview-month"/><br>
	</div>
	<div id="overview-data">
	</div>
</script>
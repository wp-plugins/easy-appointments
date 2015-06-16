<script type="text/template" id="ea-report-main">
<div class="report-container">
	<ul class="reports">
		<li class="report" data-report="overview">
			<a>
				<i class="fa fa-table"></i>
				<span>Time table</span>
			</a>
		</li>
		<li class="report" data-report="money">
			<a class="disabled">
				<i class="fa fa-money"></i>
				<span>Money</span>
			</a>
		</li>
		<li class="report" data-report="Export">
			<a class="disabled">
				<i class="fa fa-file-excel-o"></i>
				<span>Export</span>
			</a>
		</li>
	</ul>
	<div id="report-content">
		<div class="report-message">Click on menu icon to open report.<br> New reports are comming soon!</div>
	</div>
</div>
</script>

<!-- template for overview report -->
<script type="text/template" id="ea-report-overview">
	<div class="filter-select">
		<label htmlFor="">Location :</label>
		<select name="location" id="overview-location">
			<option value="">-</option>
			<% _.each(cache.Locations,function(item,key,list){ %>
				<option value="<%= item.id %>"><%= item.name %></option>
			<% });%>
		</select>
		<label htmlFor="">Service :</label>
		<select name="service" id="overview-service">
			<option value="">-</option>
			<% _.each(cache.Services,function(item,key,list){ %>
				<option value="<%= item.id %>"><%= item.name %></option>
			<% });%>
		</select>
		<label htmlFor="">Worker :</label>
		<select name="worker" id="overview-worker">
			<option value="">-</option>
			<% _.each(cache.Workers,function(item,key,list){ %>
				<option value="<%= item.id %>"><%= item.name %></option>
			<% });%>
		</select>
		<span>&nbsp&nbsp;</span>
		<button class=".refresh button-primary">Refresh</button><br><br>
		<div name="month" class="datepicker" id="overview-month"/><br>
	</div>
	<div id="overview-data">
	</div>
</script>
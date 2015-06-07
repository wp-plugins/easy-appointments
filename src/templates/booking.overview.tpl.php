<script type="text/template" id="ea-appointments-overview">
	<small>Please check your appointment details below and confirm:</small>
	<table>
		<tbody>
			<tr>
				<td><%= settings['trans.location'] %></td>
				<td><%= data.location %></td>
			</tr>
			<tr>
				<td><%= settings['trans.service'] %></td>
				<td><%= data.service%></td>
			</tr>
			<tr>
				<td><%= settings['trans.worker'] %></td>
				<td><%= data.worker %></td>
			</tr>
			<tr>
				<td>Date & Time</td>
				<td><%= data.date %> <%= data.time %></td>
			</tr>
		</tbody>
	</table>
</script>

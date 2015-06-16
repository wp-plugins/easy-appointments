<script type="text/template" id="ea-appointments-overview">
	<small>Please check your appointment details below and confirm:</small>
	<table>
		<tbody>
			<tr>
				<td class="ea-label"><%= settings['trans.location'] %></td>
				<td class="value"><%= data.location %></td>
			</tr>
			<tr>
				<td class="ea-label"><%= settings['trans.service'] %></td>
				<td class="value"><%= data.service%></td>
			</tr>
			<tr>
				<td class="ea-label"><%= settings['trans.worker'] %></td>
				<td class="value"><%= data.worker %></td>
			</tr>
			<tr>
				<td class="ea-label">Date & Time</td>
				<td class="value"><%= data.date %> <%= data.time %></td>
			</tr>
		</tbody>
	</table>
</script>

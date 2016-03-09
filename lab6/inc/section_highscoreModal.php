<!-- Modal -->
<div class="modal fade" id="highscoreModal" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Leaderboard</h4>
			</div>
			<div class="modal-body">
				<h5 class="text-center" id="tblDescription"></h5>
				<table class="table table-striped" id="tblGrid">
					<thead id="tblHead">
						<tr>
							<th class="text-center hidden-xs">Rank</th>
							<th class="text-center">Name</th>
							<th class="text-center">Matches</th>
							<th class="text-center">Score</th>
							<th class="text-center">Duration (secs)</th>
							<th class="text-center hidden-xs">Timestamp (SGT)</th>
						</tr>
					</thead>
					<tbody id="tblBody">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

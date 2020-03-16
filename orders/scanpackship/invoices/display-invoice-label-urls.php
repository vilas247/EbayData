<style type="text/css">
	.ngdialog.ngdialog-theme-default .ngdialog-content {
		width: 1000px !important;
	}
	.ngdialog.ngdialog-theme-default {
		padding-bottom: 10px !important;
		padding-top: 10px !important;
	}
</style>
<h2 style="color: #5b5b5b; font-size: 26px; font-weight: normal; margin-bottom: 5px; margin-left: 15px; margin-top: 15px;">Print Invoice and Labels</h2>
<div class="row">
	<div class="col-lg-12 mar-top-20 amazon-repricing-inventory">
		<div id="" class="table-responsive table-bordered">
			<table class="table pad-table-10 table-bordered table-striped">
				<tbody>
					<tr>
						<td data-title="'Label URL'" style="text-align:center;"><iframe id="labelPdfToPrint" src="<?= $_REQUEST['labelMergePdf'] ?>" width="95%" height="450px"></iframe></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="row background-gray mar-left-right-0">
			<div class="col-md-4 mar-top-20">
				<button class="btn btn-theme" type="button" ng-click="cancel()">
					Close
				</button>
			</div>
		</div>
	</div>
</div>

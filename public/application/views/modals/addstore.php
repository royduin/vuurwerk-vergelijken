<div class="modal fade" id="addStore" tabindex="-1" role="dialog" aria-labelledby="addStoreModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="addStoreModalLabel">Winkel toevoegen</h4>
			</div>
			<div class="modal-body">
				<?=form_open(site_url('ajax/addstore'),['role' => 'form','class' => 'form-horizontal']);?>
					<div class="form-group">
						<label for="add-store-name" class="control-label col-sm-3">Winkel naam</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="add-store-name" id="add-store-name" placeholder="Winkel naam">
						</div>
					</div>
					<div class="form-group">
						<label for="add-store-website" class="control-label col-sm-3">Winkel website</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="add-store-website" id="add-store-website" placeholder="http://www.winkel.nl">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
				<button type="button" class="btn btn-danger" id="add-store-submit">Toevoegen</button>
			</div>
		</div>
	</div>
</div>
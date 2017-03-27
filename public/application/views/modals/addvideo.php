<div class="modal fade" id="addVideo" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="addVideoModalLabel">Video toevoegen</h4>
			</div>
			<div class="modal-body">
				<?=form_open(site_url('ajax/addvideo'),['role' => 'form','class' => 'form-horizontal']);?>
					<input type="hidden" name="add-video-product-id" id="add-video-product-id" value="">
					<div class="form-group">
						<label class="control-label col-sm-3">Product</label>
						<div class="col-sm-9">
							<p class="form-control-static" id="add-video-product"></p>
						</div>
					</div>
					<div class="form-group">
						<label for="add-video-titel" class="control-label col-sm-3">Video titel</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="add-video-titel" id="add-video-titel" placeholder="Titel">
						</div>
					</div>
					<div class="form-group">
						<label for="add-video-video" class="control-label col-sm-3">Youtube video</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="add-video-video" id="add-video-video" placeholder="http://www.youtube.com/watch?v=">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
				<button type="button" class="btn btn-danger" id="add-video-submit">Toevoegen</button>
			</div>
		</div>
	</div>
</div>
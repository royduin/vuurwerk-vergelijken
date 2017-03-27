<div class="modal fade" id="addPrice" tabindex="-1" role="dialog" aria-labelledby="addPriceModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="addPriceModalLabel">Prijs toevoegen</h4>
			</div>
			<div class="modal-body">
				<?=form_open(site_url('ajax/addprice'),['role' => 'form','class' => 'form-horizontal']);?>
					<input type="hidden" name="add-price-product-id" id="add-price-product-id" value="">
					<input type="hidden" name="add-price-year" id="add-price-year" value="">
					<div class="form-group">
						<label class="control-label col-sm-2">Product</label>
						<div class="col-sm-10">
							<p class="form-control-static" id="add-price-product"></p>
						</div>
					</div>
					<div class="form-group">
						<label for="add-price-store" class="control-label col-sm-2">Winkel</label>
						<div class="col-sm-10">
							<select class="form-control" name="add-price-store" id="add-price-store">
								<option value="0">Kies...</option>
								<? foreach($modal_winkels as $winkel): ?>
									<option value="<?=$winkel->winkel_id;?>"><?=html_escape($winkel->winkel_naam);?></option>
								<? endforeach; ?>
							</select>
							<p class="help-block">Staat een winkel hier niet tussen? <a href="#" class="add-store">Laat het ons weten</a>!</p>
						</div>
					</div>
					<div class="form-group">
						<label for="add-price-amount" class="control-label col-sm-2">Aantal</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="add-price-amount" id="add-price-amount" placeholder="Aantal" value="1">
						</div>
					</div>
					<div class="form-group">
						<label for="add-price-price" class="control-label col-sm-2">Prijs</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">&euro;</span>
								<input type="text" class="form-control" name="add-price-price" id="add-price-price" placeholder="0,00">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="add-price-source" class="control-label col-sm-2">Bron</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="add-price-source" id="add-price-source" placeholder="http://www.winkel.nl/product">
							<p class="help-block">Waar heb je de prijs gevonden?</p>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
				<button type="button" class="btn btn-danger" id="add-price-submit">Toevoegen</button>
			</div>
		</div>
	</div>
</div>
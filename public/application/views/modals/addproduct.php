<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<? if($this->ion_auth->is_admin()): ?>
					<a href="<?=site_url('admin/search');?>" target="_blank" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-search"></span> Zoek op andere sites</a>
				<? endif; ?>
				<h4 class="modal-title" id="addProductModalLabel">Product toevoegen</h4>
			</div>
			<div class="modal-body">
				<?=form_open(site_url('ajax/addproduct'),['role' => 'form','class' => 'form-horizontal']);?>
					<div class="form-group">
						<label for="add-product-naam" class="control-label col-sm-3">Naam</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="add-product-naam" id="add-product-naam" placeholder="Naam">
						</div>
					</div>
					<? if($this->ion_auth->is_admin()): ?>
						<div class="form-group">
							<label for="add-product-slug" class="control-label col-sm-3">Slug</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="add-product-slug" id="add-product-slug" placeholder="Slug">
							</div>
						</div>
					<? endif; ?>
					<div class="form-group">
						<label for="add-product-artikelnummer" class="control-label col-sm-3">Artikelnummer</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="add-product-artikelnummer" id="add-product-artikelnummer" placeholder="Artikelnummer">
						</div>
					</div>
					<div class="form-group">
						<label for="add-product-nieuw" class="control-label col-sm-3">Nieuw in jaar</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="add-product-nieuw" id="add-product-nieuw" placeholder="<?=config_item('jaar');?>">
						</div>
					</div>
					<div class="form-group">
						<label for="add-product-buitenland" class="control-label col-sm-3">Te koop in NL?</label>
						<div class="col-sm-9">
							<div class="checkbox">
								<label for="add-product-buitenland">
									<input type="checkbox" name="add-product-buitenland" id="add-product-buitenland" value="1"> Nee
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="add-product-soort" class="control-label col-sm-3">Soort</label>
						<div class="col-sm-9">
							<select name="add-product-soort" id="add-product-soort" class="form-control">
								<option value="0">Kies...</option>
								<? foreach($soorten as $soort): ?>
									<option value="<?=$soort->soort_id;?>" data-specificaties="<?=$soort->soort_specificaties;?>"><?=$soort->soort_naam;?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="add-product-importeur" class="control-label col-sm-3">Importeur</label>
						<div class="col-sm-9">
							<select name="add-product-importeur" id="add-product-importeur" class="form-control">
								<option value="0">Kies...</option>
								<? foreach($modal_importeurs as $importeur): ?>
									<option value="<?=$importeur->importeur_id;?>"><?=$importeur->importeur_naam;?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="add-product-merk" class="control-label col-sm-3">Merk / collectie</label>
						<div class="col-sm-9">
							<select name="add-product-merk" id="add-product-merk" class="form-control">
								<option value="0">Kies...</option>
								<? foreach($modal_merken as $merk): ?>
									<option value="<?=$merk->merk_id;?>"><?=$merk->merk_naam;?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group hidden">
						<label for="add-product-aantal" class="control-label col-sm-3">Aantal</label>
						<div class="col-sm-9">
							<input type="text" class="form-control spec" name="add-product-aantal" id="add-product-aantal" placeholder="Aantal">
						</div>
					</div>
					<div class="form-group hidden">
						<label for="add-product-inch" class="control-label col-sm-3">Inch</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control spec" name="add-product-inch" id="add-product-inch" placeholder="Inch">
								<span class="input-group-addon">inch (2 decimalen)</span>
							</div>
						</div>
					</div>
					<div class="form-group hidden">
						<label for="add-product-schoten" class="control-label col-sm-3">Schoten</label>
						<div class="col-sm-9">
							<input type="text" class="form-control spec" name="add-product-schoten" id="add-product-schoten" placeholder="Schoten">
						</div>
					</div>
					<div class="form-group hidden">
						<label for="add-product-gram" class="control-label col-sm-3">Gram</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control spec" name="add-product-gram" id="add-product-gram" placeholder="Gram">
								<span class="input-group-addon">gram (2 decimalen)</span>
							</div>
						</div>
					</div>
					<div class="form-group hidden">
						<label for="add-product-tube" class="control-label col-sm-3">Gram per tube</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control spec" name="add-product-tube" id="add-product-tube" placeholder="Gram per tube">
								<span class="input-group-addon">gram (2 decimalen)</span>
							</div>
						</div>
					</div>
					<div class="form-group hidden">
						<label for="add-product-duur" class="control-label col-sm-3">Duur</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control spec" name="add-product-duur" id="add-product-duur" placeholder="Duur">
								<span class="input-group-addon">seconden</span>
							</div>
						</div>
					</div>
					<div class="form-group hidden">
						<label for="add-product-hoogte" class="control-label col-sm-3">Hoogte</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control spec" name="add-product-hoogte" id="add-product-hoogte" placeholder="Hoogte">
								<span class="input-group-addon">meter</span>
							</div>
						</div>
					</div>
					<div class="form-group hidden">
						<label for="add-product-lengte" class="control-label col-sm-3">Lengte</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control spec" name="add-product-lengte" id="add-product-lengte" placeholder="Lengte">
								<span class="input-group-addon">meter</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="add-product-video" class="control-label col-sm-3">Video</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input type="text" class="form-control" name="add-product-video" id="add-product-video" placeholder="Video" value="http://www.youtube.com/watch?v=">
								<span class="input-group-btn">
									<a href="#" data-href="https://www.youtube.com/results?search_sort=video_view_count&amp;search_query=" target="_blank" id="video_link" class="btn btn-default" data-toggle="tooltip" title="Zoek op Youtube op de ingevulde naam en het artikelnummer"><span class="glyphicon glyphicon-search"></span> Zoeken op Youtube</a>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="add-product-omschrijving" class="control-label col-sm-3">Omschrijving</label>
						<div class="col-sm-9">
							<textarea rows="5" class="form-control" name="add-product-omschrijving" id="add-product-omschrijving" placeholder="Omschrijving"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="add-product-afbeelding" class="control-label col-sm-3">Afbeelding</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="add-product-afbeelding" id="add-product-afbeelding" placeholder="Afbeelding url">
						</div>
					</div>
					<p>Mist er een importeur / fabrikant of merk / collectie? Neem <a href="<?=site_url('contact');?>">contact</a> op!</p>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
				<button type="button" class="btn btn-danger" id="add-product-submit">Toevoegen</button>
			</div>
		</div>
	</div>
</div>
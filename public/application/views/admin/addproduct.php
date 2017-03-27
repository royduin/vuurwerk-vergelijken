<div class="pull-right"><a href="<?=site_url('admin/search');?>" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> Zoek op andere sites</a></div>
<h1>Product toevoegen</h1>

<? if($this->session->flashdata('success')): ?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		Het product is toegevoegd!
	</div>
<? endif; ?>

<?=form_open(site_url('admin/addproduct'),['role' => 'form','class' => 'form-horizontal']);?>
	<div class="form-group required<?=form_error('naam') ? ' has-error' : '';?>">
		<label for="naam" class="control-label col-sm-2">Naam</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="naam" id="naam" placeholder="Naam" value="<?=set_value('naam'); ?>">
			<? if(form_error('naam')): ?>
				<p class="help-block"><?=form_error('naam'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('slug') ? ' has-error' : '';?>">
		<label for="slug" class="control-label col-sm-2">Slug</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="<?=set_value('slug'); ?>">
			<? if(form_error('slug')): ?>
				<p class="help-block"><?=form_error('slug'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('artikelnummer') ? ' has-error' : '';?>">
		<label for="artikelnummer" class="control-label col-sm-2">Artikelnummer</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="artikelnummer" id="artikelnummer" placeholder="Artikelnummer" value="<?=set_value('artikelnummer'); ?>">
			<? if(form_error('artikelnummer')): ?>
				<p class="help-block"><?=form_error('artikelnummer'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('nieuw') ? ' has-error' : '';?>">
		<label for="nieuw" class="control-label col-sm-2">Nieuw in jaar</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="nieuw" id="nieuw" placeholder="Nieuw in jaar" value="<?=set_value('nieuw'); ?>">
			<? if(form_error('nieuw')): ?>
				<p class="help-block"><?=form_error('nieuw'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group<?=form_error('buitenland') ? ' has-error' : '';?>">
		<label for="buitenland" class="control-label col-sm-2">Te koop in NL?</label>
		<div class="col-sm-10">
			<div class="checkbox">
				<label for="buitenland">
					<input type="checkbox" name="buitenland" id="buitenland" value="1" <?=set_checkbox('buitenland','1');?>> Nee
				</label>
			</div>
			<? if(form_error('buitenland')): ?>
				<p class="help-block"><?=form_error('buitenland'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('soort_id') ? ' has-error' : '';?>">
		<label for="soort_id" class="control-label col-sm-2">Soort</label>
		<div class="col-sm-10">
			<select name="soort_id" id="soort_id" class="form-control">
				<option value="0">Kies...</option>
				<? foreach($soorten as $soort): ?>
					<option value="<?=$soort->soort_id;?>" data-specificaties="<?=$soort->soort_specificaties;?>" <?=set_select('soort_id',$soort->soort_id);?>><?=$soort->soort_naam;?></option>
				<? endforeach; ?>
			</select>
			<? if(form_error('soort_id')): ?>
				<p class="help-block"><?=form_error('soort_id'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('importeur_id') ? ' has-error' : '';?>">
		<label for="importeur_id" class="control-label col-sm-2">Importeur</label>
		<div class="col-sm-10">
			<select name="importeur_id" id="importeur_id" class="form-control">
				<option value="0">Kies...</option>
				<? foreach($importeurs as $importeur): ?>
					<option value="<?=$importeur->importeur_id;?>" <?=set_select('importeur_id',$importeur->importeur_id);?>><?=$importeur->importeur_naam;?></option>
				<? endforeach; ?>
			</select>
			<? if(form_error('importeur_id')): ?>
				<p class="help-block"><?=form_error('importeur_id'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('merk_id') ? ' has-error' : '';?>">
		<label for="merk_id" class="control-label col-sm-2">Merk</label>
		<div class="col-sm-10">
			<select name="merk_id" id="merk_id" class="form-control">
				<option value="0">Kies...</option>
				<? foreach($merken as $merk): ?>
					<option value="<?=$merk->merk_id;?>" <?=set_select('merk_id',$merk->merk_id);?>><?=$merk->merk_naam;?></option>
				<? endforeach; ?>
			</select>
			<? if(form_error('merk_id')): ?>
				<p class="help-block"><?=form_error('merk_id'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('aantal') ? ' has-error' : '';?><?=isset($specs) && in_array('aantal',$specs) ? '' : ' hidden';?>">
		<label for="aantal" class="control-label col-sm-2">Aantal</label>
		<div class="col-sm-10">
			<input type="text" class="form-control spec" name="aantal" id="aantal" placeholder="Aantal" value="<?=set_value('aantal'); ?>">
			<? if(form_error('aantal')): ?>
				<p class="help-block"><?=form_error('aantal'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('inch') ? ' has-error' : '';?> <?=isset($specs) && in_array('inch',$specs) ? '' : ' hidden';?>">
		<label for="inch" class="control-label col-sm-2">Inch</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="text" class="form-control spec" name="inch" id="inch" placeholder="Inch" value="<?=set_value('inch'); ?>">
				<span class="input-group-addon">inch</span>
			</div>
			<p class="help-block">2 decimalen zijn te gebruiken bijvoorbeeld: 12.34</p>
			<? if(form_error('inch')): ?>
				<p class="help-block"><?=form_error('inch'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('schoten') ? ' has-error' : '';?> <?=isset($specs) && in_array('schoten',$specs) ? '' : ' hidden';?>">
		<label for="schoten" class="control-label col-sm-2">Schoten</label>
		<div class="col-sm-10">
			<input type="text" class="form-control spec" name="schoten" id="schoten" placeholder="Schoten" value="<?=set_value('schoten'); ?>">
			<? if(form_error('schoten')): ?>
				<p class="help-block"><?=form_error('schoten'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('gram') ? ' has-error' : '';?> <?=isset($specs) && in_array('gram',$specs) ? '' : ' hidden';?>">
		<label for="gram" class="control-label col-sm-2">Gram</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="text" class="form-control spec" name="gram" id="gram" placeholder="Gram" value="<?=set_value('gram'); ?>">
				<span class="input-group-addon">gram</span>
			</div>
			<p class="help-block">2 decimalen zijn te gebruiken bijvoorbeeld: 12.34</p>
			<? if(form_error('gram')): ?>
				<p class="help-block"><?=form_error('gram'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group<?=form_error('tube') ? ' has-error' : '';?> <?=isset($specs) && in_array('tube',$specs) ? '' : ' hidden';?>">
		<label for="tube" class="control-label col-sm-2">Gram per tube</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="text" class="form-control spec" name="tube" id="tube" placeholder="Gram per tube" value="<?=set_value('tube'); ?>">
				<span class="input-group-addon">gram</span>
			</div>
			<p class="help-block">2 decimalen zijn te gebruiken bijvoorbeeld: 12.34</p>
			<? if(form_error('tube')): ?>
				<p class="help-block"><?=form_error('tube'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group<?=form_error('duur') ? ' has-error' : '';?> <?=isset($specs) && in_array('duur',$specs) ? '' : ' hidden';?>">
		<label for="duur" class="control-label col-sm-2">Duur</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="text" class="form-control spec" name="duur" id="duur" placeholder="Duur" value="<?=set_value('duur'); ?>">
				<span class="input-group-addon">seconden</span>
			</div>
			<? if(form_error('duur')): ?>
				<p class="help-block"><?=form_error('duur'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group<?=form_error('hoogte') ? ' has-error' : '';?> <?=isset($specs) && in_array('hoogte',$specs) ? '' : ' hidden';?>">
		<label for="hoogte" class="control-label col-sm-2">Hoogte</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="text" class="form-control spec" name="hoogte" id="hoogte" placeholder="Hoogte" value="<?=set_value('hoogte'); ?>">
				<span class="input-group-addon">meter</span>
			</div>
			<? if(form_error('hoogte')): ?>
				<p class="help-block"><?=form_error('hoogte'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group<?=form_error('lengte') ? ' has-error' : '';?> <?=isset($specs) && in_array('lengte',$specs) ? '' : ' hidden';?>">
		<label for="lengte" class="control-label col-sm-2">Lengte</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="text" class="form-control spec" name="lengte" id="lengte" placeholder="Lengte" value="<?=set_value('lengte'); ?>">
				<span class="input-group-addon">meter</span>
			</div>
			<? if(form_error('lengte')): ?>
				<p class="help-block"><?=form_error('lengte'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group<?=form_error('video') ? ' has-error' : '';?>">
		<label for="video" class="control-label col-sm-2">Video</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="text" class="form-control" name="video" id="video" placeholder="Video" value="<?=set_value('video','http://www.youtube.com/watch?v='); ?>">
				<span class="input-group-btn">
					<a href="#" data-href="https://www.youtube.com/results?search_sort=video_view_count&amp;search_query=" target="_blank" id="video_link" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> Zoeken op Youtube</a>
				</span>
			</div>
			<? if(form_error('video')): ?>
				<p class="help-block"><?=form_error('video'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group<?=form_error('omschrijving') ? ' has-error' : '';?>">
		<label for="omschrijving" class="control-label col-sm-2">Omschrijving</label>
		<div class="col-sm-10">
			<textarea rows="5" class="form-control" name="omschrijving" id="omschrijving" placeholder="Omschrijving"><?=set_value('omschrijving'); ?></textarea>
			<? if(form_error('omschrijving')): ?>
				<p class="help-block"><?=form_error('omschrijving'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group required<?=form_error('afbeelding') ? ' has-error' : '';?>">
		<label for="afbeelding" class="control-label col-sm-2">Afbeelding</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="afbeelding" id="afbeelding" placeholder="Afbeelding url" value="<?=set_value('afbeelding'); ?>">
			<? if(form_error('afbeelding')): ?>
				<p class="help-block"><?=form_error('afbeelding'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input type="submit" class="btn btn-danger" name="submit" value="Toevoegen">
		</div>
	</div>
</form>
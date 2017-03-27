<a href="#" class="pull-right btn btn-danger add-product" data-toggle="tooltip" data-placement="top" title="Product toevoegen"><span class="glyphicon glyphicon-plus"></span> Product toevoegen</a>

<h1>
	<?=html_escape($soort->soort_naam);?>
	<? if(isset($merk->merk_naam)): ?>
		<? if(stristr($merk->merk_naam,'collection') !== FALSE || stristr($merk->merk_naam,'selection') !== FALSE || stristr($merk->merk_naam,'collectie') !== FALSE): ?>
			<? if(stristr($merk->merk_naam,'the') !== FALSE): ?>
				in
			<? else: ?>
				in de
			<? endif; ?>
		<? else: ?>
			van
		<? endif; ?>
		<?=html_escape($merk->merk_naam);?>
	<? endif; ?>
</h1>

<? if($soort->soort_omschrijving_kort): ?>
<div class="panel panel-danger">
	<div class="panel-body">
		<p><?=html_escape($soort->soort_omschrijving_kort);?></p>
	</div>
</div>
<? endif; ?>

<? if(!isset($merken)): ?>
	<div class="alert alert-info" role="alert">Er zijn nog geen producten in deze categorie.</div>
<? else: ?>
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-danger">
				<div class="panel-heading visible-md visible-lg">Filters <a href="<?=site_url($this->uri->segment(1));?>#producten" title="Filters resetten" class="pull-right" data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-remove"></span></a></div>
				<div class="panel-heading visible-xs visible-sm" data-toggle="collapse" data-target="#filters">Filters <div class="pull-right"><span class="caret"></span></div></div>
				<div class="list-group collapse in hidden-xs" id="filters">
					<div class="list-group-item visible-xs visible-sm">
						<a href="<?=site_url($this->uri->segment(1));?>#producten" title="Filters resetten" class="btn btn-danger btn-block btn-xs"><span class="glyphicon glyphicon-remove"></span> Filters resetten</a>
					</div>
					<div class="list-group-item">
						<label for="colletie">Merk / collectie</label>
						<select class="form-control" id="colletie" name="collectie">
							<option value="<?=site_url($this->uri->segment(1));?>">Alle</option>
							<? foreach($merken as $brand): ?>
								<option value="<?=site_url($this->uri->segment(1).'/'.$brand->merk_slug);?>"<?=$this->uri->segment(2) == $brand->merk_slug ? ' selected' : '';?>><?=html_escape($brand->merk_naam);?></option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="list-group-item">
						<label for="importeur">Importeur / fabrikant</label>
						<select class="form-control" id="importeur">
							<option value="0">Alle</option>
							<? foreach($importeurs as $importeur): ?>
								<option value="<?=$importeur->importeur_slug;?>"<?=$this->input->get('importeur') == $importeur->importeur_slug ? ' selected' : '';?>><?=html_escape($importeur->importeur_naam);?></option>
							<? endforeach; ?>
						</select>
					</div>
					<?php if($slider->max_prijs): ?>
						<div class="list-group-item">
							<label>Prijs</label>
							<div class="slider slider-prijs" data-spec="prijs" data-value="<?=html_escape($this->input->get('prijs'));?>" data-start="0" data-end="<?=$slider->max_prijs;?>"></div>
						</div>
					<?php endif; ?>
					<? foreach(explode(',',$soort->soort_specificaties) as $spec): ?>
						<? if($slider->{'min_'.$spec} != $slider->{'max_'.$spec}): ?>
							<div class="list-group-item">
								<label>
									<? if($spec == 'tube'): ?>
										Gemiddelde gram per tube
									<? elseif($spec == 'aantal' AND $soort->soort_id == 11): ?>
										Aantal cakes
									<? elseif($spec == 'duur'): ?>
										Duur (seconden)
									<? elseif($spec == 'hoogte'): ?>
										Hoogte (meters)
									<? else: ?>
										<?=ucfirst($spec);?>
									<? endif; ?>
								</label>
								<div class="slider slider-<?=$spec;?>" data-spec="<?=$spec;?>" data-value="<?=html_escape($this->input->get($spec));?>" data-start="0" data-end="<?=$slider->{'max_'.$spec};?>"></div>
							</div>
						<? endif; ?>
					<? endforeach;?>
					<? if(count($jaren) > 1): ?>
						<div class="list-group-item">
							<label for="jaar">Nieuw in jaar</label>
							<select class="form-control" id="jaar">
								<option value="0">Alle</option>
								<? foreach($jaren as $jaar): ?>
									<option value="<?=$jaar->nieuw;?>"<?=$this->input->get('jaar') == $jaar->nieuw ? ' selected' : '';?>><?=$jaar->nieuw;?></option>
								<? endforeach; ?>
							</select>
						</div>
					<? endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="panel panel-danger" id="producten">
				<div class="panel-heading">Producten <? if($total): ?><span class="pull-right">totaal <?=$total;?><? if($total_pages != 1): ?>, pagina <?=$cur_page;?>/<?=$total_pages;?><? endif; ?></span><? endif; ?></div>
				<? if(!count($producten)): ?>
					<div class="panel-body">
						Er zijn geen producten gevonden met de door jou opgegeven filters.
					</div>
				<? else: ?>
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th class="col-sm-1"></th>
									<th class="col-sm-<?=(8 - count(explode(',',$soort->soort_specificaties)));?>"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=naam&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op naam">Naam</a></th>
									<? foreach(explode(',',$soort->soort_specificaties) as $spec): ?>
										<? if($spec == 'aantal'): ?>
											<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=aantal&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op aantal<?=($soort->soort_id == 11 ? ' cakes' : '');?>">Aantal</a></th>
										<? elseif($spec == 'inch'): ?>
											<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=inch&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op inch">Inch</a></th>
										<? elseif($spec == 'gram'): ?>
											<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=gram&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op gram">Gram</a></th>
										<? elseif($spec == 'tube'): ?>
											<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=tube&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op gemiddelde gram per tube">Gram/tube</a></th>
										<? elseif($spec == 'schoten'): ?>
											<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=schoten&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op schoten">Schoten</a></th>
										<? elseif($spec == 'duur'): ?>
											<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=duur&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op brandtijd">Duur</a></th>
										<? elseif($spec == 'hoogte'): ?>
											<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=hoogte&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op brandtijd">Hoogte</a></th>
										<? elseif($spec == 'lengte'): ?>
											<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=lengte&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op lengte">Lengte</a></th>
										<? endif; ?>
									<? endforeach;?>
									<th class="col-sm-1"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=prijs&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op vanaf prijs">Prijs <small><?=config_item('jaar');?></small></a></th>
									<th class="col-sm-2"><a href="<?=$base_url;?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=beoordeling&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#producten" data-toggle="tooltip" data-placement="bottom" title="Sorteren op beoordeling">Beoordeling</a></th>
								</tr>
							</thead>
							<tbody>
								<? foreach($producten as $product): ?>
									<tr>
										<td class="white-background">
											<? if(file_exists('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png')): ?>
												<a href="<?=site_url($this->uri->segment(1).'/'.$product->merk_slug.'/'.$product->slug);?>" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
													<img src="<?=site_url('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png');?>" alt="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
												</a>
											<? endif; ?>
										</td>
										<td><a href="<?=site_url($this->uri->segment(1).'/'.$product->merk_slug.'/'.$product->slug);?>" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>"><?=html_escape($product->naam);?></a></td>
										<? foreach(explode(',',$soort->soort_specificaties) as $spec): ?>
											<? if($spec == 'aantal'): ?>
												<td><?=$product->aantal ?: '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je in welke hoeveelheid dit product verkocht wordt? Laat het ons weten!">?</a>';?></td>
											<? elseif($spec == 'inch'): ?>
												<td><?=$product->inch != 0 ? price($product->inch) : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je hoeveel inch dit product is? Laat het ons weten!">?</a>';?></td>
											<? elseif($spec == 'gram'): ?>
												<td><?=$product->gram != 0 ? price($product->gram) : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je hoeveel gram er in dit product zit? Laat het ons weten!">?</a>';?></td>
											<? elseif($spec == 'tube'): ?>
												<td><?=$product->tube != 0 ? price($product->tube) : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je hoeveel gram er gemiddeld in een tube zit bij dit product? Laat het ons weten!">?</a>';?></td>
											<? elseif($spec == 'schoten'): ?>
												<td><?=$product->schoten ?: '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je hoeveel schoten dit product heeft? Laat het ons weten!">?</a>';?></td>
											<? elseif($spec == 'duur'): ?>
												<td><?=$product->duur ? $product->duur.'s' : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je wat de brandtijd is van dit product? Laat het ons weten!">?</a>';?></td>
											<? elseif($spec == 'hoogte'): ?>
												<td><?=$product->hoogte ? $product->hoogte.'m' : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je wat de hoogte van de effecten is bij dit product? Laat het ons weten!">?</a>';?></td>
											<? elseif($spec == 'lengte'): ?>
												<td><?=$product->lengte ? $product->lengte.'m' : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je wat de lengte is van dit product? Laat het ons weten!">?</a>';?></td>
											<? endif; ?>
										<? endforeach;?>								
										<td><?=$product->prijs != 0 ? '&euro;'.price($product->prijs) : ($product->buitenland ? '' : '<a href="#" class="add-price" data-toggle="tooltip" data-placement="top" data-product="'.(!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '').$product->naam.'" data-product-id="'.$product->product_id.'" data-jaar="'.config_item('jaar').'" title="De prijs is onbekend, heb je de prijs ergens gezien? Laat het ons weten!">Onbekend</a>');?></td>
										<td class="text-center">
											<span class="pull-left"><?=$product->beoordeling;?> <span class="glyphicon glyphicon-star"></span></span> 
											<?=($product->video ? '<a href="'.$product->video.'" class="fancybox" rel="videos" title="Bekijk video" data-fancybox-title="'.(!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '').html_escape($product->naam).'" data-toggle="tooltip" data-placement="top"><span class="glyphicon glyphicon-facetime-video"></span></a>' : '');?> 
											<? if(!isset($this->session->userdata('wishlist')['products'][$product->product_id])): ?>
												<a href="#" class="pull-right add-wishlist" data-ajax-url="<?=site_url('ajax/addtowishlist');?>" data-product-id="<?=$product->product_id;?>" data-toggle="tooltip" data-placement="top" title="Product toevoegen aan verlanglijst"><span class="glyphicon glyphicon-plus"></span></a>
											<? else: ?>
												<a href="#" class="pull-right remove-wishlist" data-ajax-url="<?=site_url('ajax/removefromwishlist');?>" data-product-id="<?=$product->product_id;?>" data-toggle="tooltip" data-placement="top" title="Verwijder dit product van je verlanglijst"><span class="glyphicon glyphicon-remove"></span></a>
											<? endif; ?>
										</td>
									</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					</div>
				<? endif; ?>
			</div>
			<?=$pagination;?>
		</div>
	</div>

	<? if(isset($merk->merk_omschrijving)): ?>
		<? if($merk->merk_omschrijving): ?>
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h2><?=$soort->soort_naam;?> van <?=$merk->merk_naam; ?></h2>
				</div>
				<div class="panel-body">
					<p><?=$merk->merk_omschrijving;?></p>
				</div>
			</div>
		<? endif; ?>
	<? else: ?>
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h2>Vuurwerk <?=strtolower($soort->soort_naam); ?></h2>
			</div>
			<div class="panel-body">
				<p><?=$soort->soort_omschrijving_lang;?></p>
			</div>
		</div>
	<? endif; ?>
<? endif; ?>
<? if(isset($producten) AND !isset($shared)): ?>
	<a href="#" class="pull-right btn btn-danger clear-wishlist" data-ajax-url="<?=site_url('ajax/clearwishlist');?>" data-toggle="tooltip" data-placement="top" title="Alles van de verlanglijst verwijderen"><span class="glyphicon glyphicon-remove"></span></a>
<? endif; ?>

<? if(!isset($shared)): ?>
	<h1>Vuurwerk verlanglijst</h1>
<? else: ?>
	<h1>Gedeelde vuurwerk verlanglijst</h1>
<? endif; ?>

<? if(isset($producten)): ?>

	<? if(!isset($shared) AND !$this->ion_auth->logged_in()): ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			Let op! Je bent niet ingelogd en dus is dit verlanglijstje niet bij je account opgeslagen. Wil je dit verlanglijstje bewaren <a href="#" class="alert-link register" title="Account aanmaken">maak dan een account aan</a> of <a href="#" class="alert-link login" title="Inloggen">login</a>.
		</div>
	<? endif; ?>

	<? if(isset($shared) AND $totalfound != $totalshared): ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			Let op! Er zijn <?=$totalshared;?> producten gedeeld, echter zijn er maar <?=$totalfound;?> gevonden. Waarschijnlijk klopt de verlanglijst delen link die je gebruikt hebt niet.
		</div>
	<? endif; ?>

	<? if(!isset($shared) AND $this->ion_auth->logged_in()): ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			Het opslaan van een verlanglijst is nog niet mogelijk. Wil je deze functionaliteit snel zien? Help ons om van <a href="<?=site_url();?>">vuurwerk-vergelijken.nl</a> een succes te maken door producten en prijzen toe te voegen!
		</div>
	<? endif; ?>

	<? foreach($soorten as $soort): ?>
		<? if(isset($producten[$soort->soort_naam])): ?>
			<div class="panel panel-danger" id="<?=$soort->soort_slug;?>">
				<div class="panel-heading"><h2><?=html_escape($soort->soort_naam);?></h2></div>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="col-sm-1">Aantal</th>
								<th class="col-sm-1"></th>
								<th class="col-sm-<?=(8 - count(explode(',',$soort->soort_specificaties)));?>"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=naam&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op naam">Naam</a></th>
								<? foreach(explode(',',$soort->soort_specificaties) as $spec): ?>
									<? if($spec == 'aantal'): ?>
										<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=aantal&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op aantal<?=($soort->soort_id == 11 ? ' cakes' : '');?>">Aantal</a></th>
									<? elseif($spec == 'inch'): ?>
										<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=inch&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op inch">Inch</a></th>
									<? elseif($spec == 'gram'): ?>
										<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=gram&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op gram">Gram</a></th>
									<? elseif($spec == 'tube'): ?>
										<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=tube&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op gemiddelde gram per tube">Gram/tube</a></th>
									<? elseif($spec == 'schoten'): ?>
										<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=schoten&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op schoten">Schoten</a></th>
									<? elseif($spec == 'duur'): ?>
										<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=duur&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op brandtijd">Duur</a></th>
									<? elseif($spec == 'hoogte'): ?>
										<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=hoogte&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op brandtijd">Hoogte</a></th>
									<? elseif($spec == 'lengte'): ?>
										<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=lengte&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op lengte">Lengte</a></th>
									<? endif; ?>
								<? endforeach;?>
								<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=prijs&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op prijs">Prijs <small><?=config_item('jaar');?></small></a></th>
								<th class="col-sm-1"><a href="<?=current_url();?><?=$clean_query ? '?'.$clean_query.'&' : '?';?>order=beoordeling&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#<?=$soort->soort_slug;?>" data-toggle="tooltip" data-placement="bottom" title="Sorteren op beoordeling">Beoordeling</a></th>
							</tr>
						</thead>
						<tbody>
							<? foreach($producten[$soort->soort_naam] as $product): ?>
								<tr>
									<td>
										<? if(!isset($shared)): ?>
											<div class="input-group">
												<input type="text" class="col-sm-1 form-control" value="<?=$product->amount;?>">
												<span class="input-group-btn">
													<button class="btn btn-default change-wishlist" type="button" title="Aantal bewerken" data-toggle="tooltip" data-placement="bottom"><span class="glyphicon glyphicon-refresh"></span></button>
												</span>
											</div>
										<? else: ?>
											<strong><?=$product->amount;?></strong>
										<? endif; ?>
									</td>
									<td class="white-background">
										<? if(file_exists('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png')): ?>
											<a href="<?=site_url($product->soort_slug.'/'.$product->merk_slug.'/'.$product->slug);?>" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
												<img src="<?=site_url('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png');?>" alt="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
											</a>
										<? endif; ?>
									</td>
									<td><a href="<?=site_url($product->soort_slug.'/'.$product->merk_slug.'/'.$product->slug);?>" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>"><?=html_escape($product->naam);?></a></td>
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
									<td><?=$product->prijs != 0 ? '&euro;'.price($product->prijs) : ($product->buitenland ? '' : '<a href="#" class="add-price" data-toggle="tooltip" data-placement="top" data-product="'.(!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '').html_escape($product->naam).'" data-product-id="'.$product->product_id.'" data-jaar="'.config_item('jaar').'" title="De prijs is onbekend, heb je de prijs ergens gezien? Laat het ons weten!">Onbekend</a>');?></td>
									<td class="text-center">
										<span class="pull-left"><?=$product->beoordeling;?> <span class="glyphicon glyphicon-star"></span></span> 
										<?=($product->video ? '<a href="'.$product->video.'" class="fancybox" rel="videos" title="Bekijk video" data-fancybox-title="'.(!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '').html_escape($product->naam).'" data-toggle="tooltip" data-placement="top"><span class="glyphicon glyphicon-facetime-video"></span></a>' : '');?> 
										<? if(!isset($this->session->userdata('wishlist')['products'][$product->product_id])): ?>
											<a href="#" class="pull-right add-wishlist" data-ajax-url="<?=site_url('ajax/addtowishlist');?>" data-product-id="<?=$product->product_id;?>" data-toggle="tooltip" data-placement="top" title="Product toevoegen aan<?=isset($shared) ? ' je eigen' : '';?> verlanglijst"><span class="glyphicon glyphicon-plus"></span></a>
										<? else: ?>
											<a href="#" class="pull-right remove-wishlist" data-ajax-url="<?=site_url('ajax/removefromwishlist');?>" data-product-id="<?=$product->product_id;?>" data-toggle="tooltip" data-placement="top" title="Verwijderd dit product van je<?=isset($shared) ? ' eigen' : '';?> verlanglijst"><span class="glyphicon glyphicon-remove"></span></a>
										<? endif; ?>
									</td>
								</tr>
							<? endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		<? endif; ?>
	<? endforeach; ?>

	<div class="panel panel-danger">
		<div class="panel-body">
			Totaal: <strong>&euro;<?=price($totaal_prijs); ?></strong> bij de goedkoopste vuurwerk winkels <?=$geen_prijs ? '(let op, van '.$geen_prijs.' product'.($geen_prijs > 1 ? 'en' : '').' is er (nog) geen prijs bekend)' : '';?>
		</div>
	</div>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Verlanglijst delen
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="link">Link</label>
				<input type="text" id="link" class="form-control" value="<?=$link;?>">
			</div>
		</div>
	</div>

<? else: ?>

	<div class="panel panel-danger">
		<div class="panel-body">Maak eenvoudig je vuurwerk verlanglijst en zie waar je je vuurwerk het goedkoopste kan krijgen!</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-danger">
				<div class="panel-heading"><h2>Vuurwerk verlanglijst maken</div>
				<div class="panel-body">Overal waar producten te vinden zijn op de website kan je (veelal middels het plus icoontje) deze toevoegen aan je verlanglijst. Wanneer ingelogd kan je meerdere verlanglijsten maken, deze een naam geven en uiteraard kan je verlanglijst altijd eenvoudig gedeeld worden.</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-danger">
				<div class="panel-heading"><h2>Vuurwerk prijzen vergelijken</div>
				<div class="panel-body">Net zoals de website heet, kan je ook in je verlanglijst vuurwerk vergelijken. Zie eenvoudig waar je je verlanglijst het beste kan bestellen en bespaar geld!</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-danger">
				<div class="panel-heading"><h2>Vuurwerk bestellen</div>
				<div class="panel-body">Heb je je verlanglijst compleet? Wanneer vuurwerk winkels mee willen werken wordt het mogelijk om via <a href="<?=site_url();?>" title="Vuurwerk-vergelijken.nl">vuurwerk-vergelijken.nl</a> je verlanglijst eenvoudig te bestellen. Voor vragen kan je altijd <a href="<?=site_url('contact');?>" title="Contact opnemen">contact opnemen</a>.</div>
			</div>
		</div>
	</div>

<? endif; ?>
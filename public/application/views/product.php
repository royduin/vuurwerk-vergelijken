<div class="product" itemscope itemtype="http://data-vocabulary.org/Product">
	<? if(!isset($this->session->userdata('wishlist')['products'][$product->product_id])): ?>
		<a href="#" class="pull-right btn btn-danger add-wishlist" data-ajax-url="<?=site_url('ajax/addtowishlist');?>" data-product-id="<?=$product->product_id;?>" data-toggle="tooltip" data-placement="top" title="Product toevoegen aan verlanglijst"><span class="glyphicon glyphicon-plus"></span></a>
	<? else: ?>
		<a href="#" class="pull-right btn btn-danger remove-wishlist" data-ajax-url="<?=site_url('ajax/removefromwishlist');?>" data-product-id="<?=$product->product_id;?>" data-toggle="tooltip" data-placement="top" title="Verwijder dit product van je verlanglijst"><span class="glyphicon glyphicon-remove"></span></a>
	<? endif; ?>
	<h1><?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><span itemprop="name"><?=html_escape($product->naam);?></span><?=($product->nieuw == config_item('jaar') ? ' <span class="label label-success">Nieuw!</span>' : '');?></h1>

	<div class="panel panel-danger">
		<div class="panel-body">
			<p itemprop="description"><?=join(' en ', array_filter(array_merge(array(join(', ', array_slice($product_descr, 0, -1))), array_slice($product_descr, -1))));?>.<?=$product->omschrijving ? ' '.nl2br($product->omschrijving) : '';?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 col-md-push-9">
			<? if(file_exists('img/producten/'.$product->product_id.'/'.$product->slug.'.png')): ?>
				<a href="<?=site_url('img/producten/'.$product->product_id.'/'.$product->slug.'.png');?>" class="fancybox" title="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?> afbeelding" rel="videos">
					<img src="<?=site_url('img/producten/'.$product->product_id.'/thumb260/'.$product->slug.'.png');?>" class="center-block img-responsive" alt="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" itemprop="image">
				</a>
			<? endif; ?>
			<div class="rating" itemprop="review" itemscope itemtype="http://data-vocabulary.org/Review-aggregate" data-product-id="<?=$product->product_id;?>" data-ajax-url="<?=site_url('ajax/rating');?>">
				<span itemprop="itemreviewed" class="hidden"><?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?></span>
				<a href="#" title="Beoordeel dit product als zeer slecht" data-star="1"><span class="glyphicon glyphicon-star<?=$score >= 1 ? '' : '-empty';?>"></span></a>
				<a href="#" title="Beoordeel dit product als slecht" data-star="2"><span class="glyphicon glyphicon-star<?=$score >= 2 ? '' : '-empty';?>"></span></a>
				<a href="#" title="Beoordeel dit product als redelijk" data-star="3"><span class="glyphicon glyphicon-star<?=$score >= 3 ? '' : '-empty';?>"></span></a>
				<a href="#" title="Beoordeel dit product als goed" data-star="4"><span class="glyphicon glyphicon-star<?=$score >= 4 ? '' : '-empty';?>"></span></a>
				<a href="#" title="Beoordeel dit product als zeer goed" data-star="5"><span class="glyphicon glyphicon-star<?=$score >= 5 ? '' : '-empty';?>"></span></a>
				<p><span itemprop="rating"><?=$score;?></span> sterren (<span itemprop="votes"><?=$stemmen;?></span> stemmen)</p>
			</div>
			<? if($product->video): ?>
				<a href="<?=$product->video;?>" class="fancybox btn btn-danger btn-block btn-lg" rel="videos" title="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?> video">Bekijk video</a>
			<? endif; ?>
			<div class="addthis_sharing_toolbox center-block"></div>
		</div>
		<div class="col-md-9 col-md-pull-3">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<?=html_escape($product->naam);?> informatie
					<a href="#" class="edit-product pull-right" data-toggle="tooltip" title="Product informatie wijzigen" data-product="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" data-product-id="<?=$product->product_id;?>"><span class="glyphicon glyphicon-pencil"></span></a>
				</div>
				<table class="table table-striped">
					<tr>
						<th class="col-sm-6">Artikelnummer</th>
						<td class="col-sm-6" itemprop="identifier" content="mpn:<?=$product->artikelnummer;?>"><?=$product->artikelnummer;?></td>
					</tr>
					<tr>
						<th>Categorie</th>
						<td><a href="<?=site_url($soort->soort_slug);?>" title="<?=html_escape($soort->soort_naam);?>"><?=html_escape($soort->soort_naam);?></a></td>
					</tr>
					<tr>
						<th>Importeur / fabrikant</th>
						<td><a href="<?=site_url('importeurs/'.$product->importeur_slug);?>" title="<?=html_escape($product->importeur_naam);?>"><?=html_escape($product->importeur_naam);?></a></td>
					</tr>
					<tr>
						<th>Merk / collectie</th>
						<td><a href="<?=site_url($soort->soort_slug.'/'.$merk->merk_slug);?>" itemprop="brand" title="<?=html_escape($merk->merk_naam);?>"><?=html_escape($merk->merk_naam);?></a></td>
					</tr>
					<? if($product->nieuw): ?>
						<tr>
							<th>Nieuw in</th>
							<td><?=$product->nieuw;?></td>
						</tr>
					<? endif; ?>
				</table>
			</div>
			<div class="panel panel-danger">
				<div class="panel-heading">
					<?=html_escape($product->naam);?> specificaties
					<a href="#" class="edit-product pull-right" data-toggle="tooltip" title="Specificaties wijzigen" data-product="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" data-product-id="<?=$product->product_id;?>"><span class="glyphicon glyphicon-pencil"></span></a>
				</div>
				<table class="table table-striped">
					<? foreach(explode(',',$soort->soort_specificaties) as $spec): ?>
						<tr>
							<? if($spec == 'aantal'): ?>
								<th class="col-sm-6">Aantal<?=($soort->soort_id == 11) ? ' cakes' : '';?></th>
								<td class="col-sm-6"><?=$product->aantal ?: '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je in welke hoeveelheid dit product verkocht wordt? Laat het ons weten!">?</a>';?></td>
							<? elseif($spec == 'inch'): ?>
								<th class="col-sm-6">Inch</th>
								<td class="col-sm-6"><?=$product->inch != 0 ? price($product->inch) : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je hoeveel inch dit product is? Laat het ons weten!">?</a>';?></td>
							<? elseif($spec == 'gram'): ?>
								<th class="col-sm-6">Gram</th>
								<td class="col-sm-6"><?=$product->gram != 0 ? price($product->gram) : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je hoeveel gram er in dit product zit? Laat het ons weten!">?</a>';?></td>
							<? elseif($spec == 'tube'): ?>
								<th class="col-sm-6">Gemiddelde gram per tube</th>
								<td class="col-sm-6"><?=$product->tube != 0 ? price($product->tube) : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je hoeveel gram er gemiddeld in een tube zit bij dit product? Laat het ons weten!">?</a>';?></td>
							<? elseif($spec == 'schoten'): ?>
								<th class="col-sm-6">Schoten</th>
								<td class="col-sm-6"><?=$product->schoten ?: '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je hoeveel schoten dit product heeft? Laat het ons weten!">?</a>';?></td>
							<? elseif($spec == 'duur'): ?>
								<th class="col-sm-6">Duur</th>
								<td class="col-sm-6"><?=$product->duur ? $product->duur.'s' : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je wat de brandtijd is van dit product? Laat het ons weten!">?</a>';?></td>
							<? elseif($spec == 'hoogte'): ?>
								<th class="col-sm-6">Hoogte</th>
								<td class="col-sm-6"><?=$product->hoogte ? $product->hoogte.'m' : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je wat de hoogte van de effecten is bij dit product? Laat het ons weten!">?</a>';?></td>
							<? elseif($spec == 'lengte'): ?>
								<th class="col-sm-6">Lengte</th>
								<td class="col-sm-6"><?=$product->lengte ? $product->lengte.'m' : '<a href="#" class="edit-product" data-toggle="tooltip" data-placement="top" title="Weet je wat de lengte is van dit product? Laat het ons weten!">?</a>';?></td>
							<? endif; ?>
						</tr>
					<? endforeach; ?>
				</table>
			</div>
		</div>
	</div>

	<? if($product->buitenland): ?>
		<div class="alert alert-danger" role="alert">Dit product is niet te koop bij Nederlandse vuurwerk winkels.</div>
	<? else: ?>
		<div class="panel panel-danger" id="prijzen">
			<div class="panel-heading">
				<a href="#" class="add-price pull-right" data-toggle="tooltip" title="Prijs toevoegen" data-product="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" data-product-id="<?=$product->product_id;?>" data-jaar="<?=config_item('jaar');?>"><span class="glyphicon glyphicon-plus"></span></a>
				<h2><?=html_escape($product->naam);?> prijzen</h2>
			</div>
			<? if(count($winkels)): ?>
				<? if(isset($prijs_laagste) AND isset($prijs_hoogste)): ?>
					<span itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer-aggregate" class="hidden">
						<span itemprop="lowPrice"><?=$prijs_laagste;?></span>
						<span itemprop="highPrice"><?=$prijs_hoogste;?></span>
						<meta itemprop="currency" content="EUR" />
						<span itemprop="offerCount"><?=count($winkels);?></span>
						<span itemprop="condition" content="new">Nieuw</span>
					</span>
				<? endif; ?>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th><a href="?order=winkel&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#prijzen" data-toggle="tooltip" data-placement="bottom" title="Sorteren op de winkel naam">Winkel</a></th>
								<th><a href="?order=aantal&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#prijzen" data-toggle="tooltip" data-placement="bottom" title="Sorteren op aantal">Aantal</a></th>
								<? foreach(config_item('jaren') as $jaar): ?>
									<th><a href="?order=<?=$jaar;?>&amp;dir=<?=$this->input->get('dir') == 'desc' ? 'asc' : 'desc';?>#prijzen" data-toggle="tooltip" data-placement="bottom" title="Sorteren op de prijzen van <?=$jaar;?>">Prijs <?=$jaar;?></a></th>
								<? endforeach; ?>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<? foreach($winkels as $winkel): ?>
								<tr>
									<td><?=$winkel->affiliate ? '<strong>' : '';?><a href="<?=site_url('winkels/'.$winkel->slug);?>" title="<?=html_escape($winkel->winkel_naam);?>"><?=html_escape($winkel->winkel_naam);?></a><?=$winkel->filialen > 1 ? ' ('.$winkel->filialen.' filialen)' : '';?><?=$winkel->affiliate ? '</strong> <span class="label label-success">Aanrader</span>' : '';?></td>
									<td><?=$winkel->aantal;?></td>
									<? foreach(config_item('jaren') as $jaar): ?>
										<td><?=$winkel->{'prijs'.$jaar} ? '&euro;'.price($winkel->{'prijs'.$jaar}).($winkel->{'prijs'.$jaar} != $winkel->{'staffelprijs'.$jaar} ? ' <small>(&euro;'.price($winkel->{'staffelprijs'.$jaar}).' per stuk)</small>' : '') : '<a href="#" class="add-price" data-toggle="tooltip" data-placement="top" data-product="'.(!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '').html_escape($product->naam).'" data-product-id="'.$product->product_id.'" data-store-id="'.$winkel->winkel_id.'" data-jaar="'.$jaar.'" title="De prijs is (nog) onbekend, heb je de prijs ergens gezien? Laat het ons weten!">Onbekend</a>';?></td>
									<? endforeach; ?>
									<td>
										<? if($winkel->affiliate): ?>
											<a href="<?=$winkel->affiliate_url;?>" target="_blank" class="btn btn-success btn-xs" title="Ga direct naar dit product bij <?=html_escape($winkel->winkel_naam);?>" data-toggle="tooltip"><span class="glyphicon glyphicon-share"></span></a>
										<? endif; ?>
									</td>
								</tr>
							<? endforeach; ?>
						</tbody>
						<tfoot>
							<tr class="danger">
								<td colspan="<?=count(config_item('jaren'))+3;?>">Mist er een prijs van een winkel? <a href="#" class="add-price" data-product="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" data-product-id="<?=$product->product_id;?>" data-jaar="<?=config_item('jaar');?>">Laat het ons weten!</a></td>
							</tr>
						</tfoot>
					</table>
				</div>
			<? else: ?>
				<div class="panel-body">
					Dit product is momenteel nergens verkrijgbaar. Toch ergens gezien? <a href="#" class="add-price" data-product="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" data-product-id="<?=$product->product_id;?>" data-jaar="<?=config_item('jaar');?>">Laat het ons weten!</a>
				</div>
			<? endif; ?>
		</div>
	<? endif; ?>

	<div class="panel panel-danger">
		<div class="panel-heading">
			<?=html_escape($product->naam);?> video's van bezoekers
			<a href="#" class="add-video pull-right" data-toggle="tooltip" title="Video toevoegen" data-product="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" data-product-id="<?=$product->product_id;?>"><span class="glyphicon glyphicon-plus"></span></a>
		</div>
		<div class="panel-body">
			<? if(count($videos)): ?>
				<div class="row">
					<? foreach($videos as $video): ?>
						<div class="col-xs-6 col-sm-3 col-md-2">
							<div class="thumbnail" data-toggle="tooltip" title="<?=html_escape($video->titel);?>">
								<a href="<?=$video->video;?>" class="fancybox" rel="videos" title="<?=html_escape($video->titel);?>">
									<img src="//img.youtube.com/vi/<?=get_video_id($video->video);?>/default.jpg" alt="<?=html_escape($video->titel);?>">
								</a>
								<div class="caption oneliner">
									<strong><?=html_escape($video->titel);?></strong>
								</div>
							</div>
						</div>
					<? endforeach; ?>
				</div>
			<? else: ?>
				Er zijn nog geen video's toegevoegd door bezoekers. <a href="#" class="add-video"  data-product="<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" data-product-id="<?=$product->product_id;?>">Video toevoegen?</a>
			<? endif; ?>
		</div>
	</div>

	<? if(isset($similars) AND count($similars) == 4): ?>
		<div class="panel panel-danger">
			<div class="panel-heading">
				Vergelijkbaar met de <?=html_escape($product->naam);?>
			</div>
			<div class="panel-body">
				<div class="row">
					<? foreach($similars as $similar): ?>
						<div class="col-xs-6 col-md-3">
							<div class="thumbnail">
								<a href="<?=site_url($similar->soort_slug.'/'.$similar->merk_slug.'/'.$similar->slug);?>" title="<?=!stristr($similar->naam,$similar->merk_naam) ? html_escape($similar->merk_naam).' ' : '';?><?=html_escape($similar->naam);?>">
									<? if(file_exists('img/producten/'.$similar->product_id.'/thumb260/'.$similar->slug.'.png')): ?>
										<img src="<?=site_url('img/producten/'.$similar->product_id.'/thumb260/'.$similar->slug.'.png');?>" alt="<?=!stristr($similar->naam,$similar->merk_naam) ? html_escape($similar->merk_naam).' ' : '';?><?=html_escape($similar->naam);?>">
									<? endif; ?>
									<? if($similar->prijs): ?>
										<span class="label label-danger thumbnail-price"><small>Vanaf</small> &euro;<?=price($similar->prijs);?></span>
									<? endif; ?>
								</a>
								<div class="caption">
									<p class="oneliner"><a href="<?=site_url($similar->soort_slug.'/'.$similar->merk_slug.'/'.$similar->slug);?>" title="<?=!stristr($similar->naam,$similar->merk_naam) ? html_escape($similar->merk_naam).' ' : '';?><?=html_escape($similar->naam);?>"><?=!stristr($similar->naam,$similar->merk_naam) ? html_escape($similar->merk_naam).' ' : '';?><?=html_escape($similar->naam);?></a></p>
								</div>
							</div>
						</div>
					<? endforeach;?>
				</div>
			</div>
		</div>
	<? endif ;?>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Recensies van, en reacties over de <?=html_escape($product->naam);?>
		</div>
		<div class="panel-body">
			<div id="disqus_thread"></div>
			<script type="text/javascript">
				var disqus_shortname = 'vuurwerkvergelijken';
				var disqus_title = '<?=!stristr($product->naam,$merk->merk_naam) ? html_escape($merk->merk_naam).' ' : '';?><?=html_escape($product->naam);?>';
				(function() {
					var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				})();
			</script>
			<noscript>Zet Javascript aan om de reacties te kunnen bekijken.</noscript>
		</div>
	</div>

	<div class="panel panel-danger panel-body hidden-xs">
		Wil je dit product op je website tonen? Embed deze eenvoudig middels een afbeelding: <a href="<?=site_url('embed/product/'.$soort->soort_slug.'/'.$merk->merk_slug.'/'.$product->slug);?>" target="_blank"><?=site_url('embed/product/'.$soort->soort_slug.'/'.$merk->merk_slug.'/'.$product->slug);?></a> of gebruik de onderstaande code op een forum. Deze afbeelding wordt automatisch up-to-date gehouden zodat altijd de laatste informatie getoond wordt.
		<textarea class="form-control" rows="2">[url=<?=site_url($soort->soort_slug.'/'.$merk->merk_slug.'/'.$product->slug);?>][img]<?=site_url('embed/product/'.$soort->soort_slug.'/'.$merk->merk_slug.'/'.$product->slug);?>[/img][/url]</textarea>
	</div>

	<? if($product_added || $prices_added): ?>
		<div class="alert alert-danger" role="alert">
			<? if($product_added && $prices_added): ?>
				<a href="<?=site_url();?>" class="alert-link">Vuurwerk-vergelijken.nl</a> wil <?=$product_added;?> bedanken voor het toevoegen van dit product én <?=$prices_added;?> voor het toevoegen van prijzen van vuurwerk winkels.
			<? elseif($product_added): ?>
				<a href="<?=site_url();?>" class="alert-link">Vuurwerk-vergelijken.nl</a> wil <?=$product_added;?> bedanken voor het toevoegen van dit product.
			<? elseif($prices_added): ?>
				<a href="<?=site_url();?>" class="alert-link">Vuurwerk-vergelijken.nl</a> wil <?=$prices_added;?> bedanken voor het toevoegen van prijzen van vuurwerk winkels.
			<? endif; ?>
			<? if(!$this->ion_auth->logged_in()): ?>
				<small>Wil je hier ook je naam (en eventueel website) hebben staan? <a href="#" class="alert-link register" title="Account aanmaken">Maak dan een account aan</a> of <a href="#" class="alert-link login" title="Inloggen">login</a> en voeg een product en/of prijs toe!</small>
			<? endif; ?>
		</div>
	<? endif; ?>

</div>

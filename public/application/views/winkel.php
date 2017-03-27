<div class="store" itemscope itemtype="http://data-vocabulary.org/Organization">
	<h1 itemprop="name"><?=html_escape($winkel->winkel_naam);?><?=$winkel->affiliate ? ' <span class="label label-success">Aanrader</span>' : '';?></h1>

	<div class="row">
		<div class="col-sm-3 col-sm-push-9">
			<div class="panel panel-danger">
				<div class="panel-heading"><h2><?=html_escape($winkel->winkel_naam);?> informatie</h2></div>
				<div class="list-group">
					<? if($winkel->gemiddeld): ?>
						<div class="list-group-item">
							<?=html_escape($winkel->winkel_naam);?> is <?=$winkel->gemiddeld < -0 ? '<strong class="text-success">'.str_replace('-','',$winkel->gemiddeld).'% goedkoper</strong>' : '<strong class="text-danger">'.$winkel->gemiddeld.'% duurder</strong>';?> dan andere vuurwerk winkels.
						</div>
					<? endif; ?>
					<div class="list-group-item">
						<?=$winkel->omschrijving ?: 'Er is (nog) geen omschrijving beschikbaar voor deze vuurwerk winkel.';?>
					</div>
				</div>
			</div>
			<div class="rating" itemprop="review" itemscope itemtype="http://data-vocabulary.org/Review-aggregate" data-winkel-id="<?=$winkel->winkel_id;?>" data-ajax-url="<?=site_url('ajax/rating');?>" data-csrf="<?=$this->security->get_csrf_hash();?>">
				<span itemprop="itemreviewed" class="hidden"><?=html_escape($winkel->winkel_naam);?></span>
				<a href="#" title="Beoordeel dit product als zeer slecht" data-star="1"><span class="glyphicon glyphicon-star<?=$score >= 1 ? '' : '-empty';?>"></span></a>
				<a href="#" title="Beoordeel dit product als slecht" data-star="2"><span class="glyphicon glyphicon-star<?=$score >= 2 ? '' : '-empty';?>"></span></a>
				<a href="#" title="Beoordeel dit product als redelijk" data-star="3"><span class="glyphicon glyphicon-star<?=$score >= 3 ? '' : '-empty';?>"></span></a>
				<a href="#" title="Beoordeel dit product als goed" data-star="4"><span class="glyphicon glyphicon-star<?=$score >= 4 ? '' : '-empty';?>"></span></a>
				<a href="#" title="Beoordeel dit product als zeer goed" data-star="5"><span class="glyphicon glyphicon-star<?=$score >= 5 ? '' : '-empty';?>"></span></a>
				<p><span itemprop="rating"><?=$score;?></span> sterren (<span itemprop="votes"><?=$stemmen;?></span> stemmen)</p>
			</div>
			<a href="<?=$winkel->website;?>" class="btn btn-<?=$winkel->affiliate ? 'success' : 'danger';?> btn-block btn-lg" target="_blank" itemprop="url">Bezoek website</a>
		</div>
		<div class="col-sm-9 col-sm-pull-3">
			<div class="panel panel-danger">
				<div class="panel-heading"<?=count($filialen) > 5 ? ' data-toggle="collapse" data-target="#filialen" aria-expanded="false" aria-controls="filialen"' : '';?>>
					<? if(count($filialen) > 5): ?>
						<span class="pull-right caret"></span>
						<small class="pull-right">(openen/sluiten)</small>
					<? endif; ?>
					<? if($total = count($filialen)): ?>
						<span class="pull-right">(totaal <?=$total;?>) </span>
					<? endif; ?>
					<h2><?=html_escape($winkel->winkel_naam);?> filialen</h2>
				</div>
				<? if(!empty($filialen)): ?>
					<ul class="list-group<?=count($filialen) > 5 ? ' collapse" id="filialen' : '';?>">
						<? foreach($filialen as $filiaal): ?>
							<li class="list-group-item">
								<h3 class="list-group-item-heading"><?=$filiaal->plaats;?></h3>
								<address class="list-group-item-text" itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">Provincie <span itemprop="region"><?=$filiaal->provincie;?></span>: <span itemprop="street-address"><?=html_escape($filiaal->adres);?></span> <span itemprop="postal-code"><?=html_escape($filiaal->postcode);?></span> <span itemprop="locality"><?=html_escape($filiaal->plaats);?></span></address>
								<? if($filiaal->telefoon): ?>
									Telefoon nummer: <a href="tel:<?=preg_replace('/\D/','',$filiaal->telefoon);?>"><?=$filiaal->telefoon;?></a>
								<? endif; ?>
							</li>
						<? endforeach; ?>
					</ul>
				<? else: ?>
					<div class="panel-body">
						Er zijn nog een filialen bekend van <?=html_escape($winkel->winkel_naam);?>
					</div>
				<? endif; ?>
			</div>

			<div class="panel panel-danger">
				<div class="panel-heading"><h2><?=html_escape($winkel->winkel_naam);?> levert in <?=config_item('jaar');?> producten van</h2></div>
				<? if(!empty($importeurs)): ?>
					<ul class="list-group">
						<? foreach($importeurs as $slug=>$importeur): ?>
							<li class="list-group-item">
								<a href="<?=site_url('importeurs/'.$slug);?>">
									<?=$importeur;?>
								</a>
							</li>
						<? endforeach; ?>
					</ul>
				<? else: ?>
					<div class="panel-body">
						Het is nog niet bekend van welke importeurs <?=html_escape($winkel->winkel_naam);?> vuurwerk levert in <?=config_item('jaar');?>.
					</div>
				<? endif; ?>
			</div>
		</div>
	</div>

	<h2>Vuurwerk bij <?=html_escape($winkel->winkel_naam);?> in <?=config_item('jaar');?></h2>

	<? if(empty($producten)): ?>
		<div class="alert alert-danger" role="alert">Er zijn (nog) geen producten bekend van <?=html_escape($winkel->winkel_naam);?> voor <?=config_item('jaar');?>.</div>
	<? else: ?>
		<div class="row">
			<? foreach($soorten as $soort): ?>
				<? if(isset($producten[$soort->soort_naam])): ?>
					<div class="col-sm-6">
						<div class="panel panel-danger">
							<div class="panel-heading"><h3><?=html_escape($soort->soort_naam);?> bij <?=html_escape($winkel->winkel_naam);?></h3></div>
							<? if($soort->soort_omschrijving_kort): ?>
								<div class="panel-body">
									<?=html_escape($soort->soort_omschrijving_kort);?>
								</div>
							<? endif; ?>
							<div class="list-group">
								<? foreach($producten[$soort->soort_naam] as $product): ?>
									<a href="<?=site_url($product->soort_slug.'/'.$product->merk_slug.'/'.$product->slug);?>" class="list-group-item" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
										<div class="pull-left">
											<? if(file_exists('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png')): ?>
												<img src="<?=site_url('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png');?>" alt="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
											<? endif; ?>
										</div>
										<h4 class="list-group-item-heading"><?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?></h4>
										<p class="list-group-item-text"><?=$product->aantal > 1 ? 'Vanaf ' : '';?>&euro;<?=price($product->prijs);?></p>
									</a>
								<? endforeach; ?>
							</div>
						</div>
					</div>
				<? endif; ?>
			<? endforeach; ?>
		</div>
	<? endif; ?>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Recensies en reacties
		</div>
		<div class="panel-body">
				<div id="disqus_thread"></div>
				<script type="text/javascript">
					var disqus_shortname = 'vuurwerkvergelijken';
					var disqus_title = '<?=html_escape($winkel->winkel_naam);?>';
					(function() {
						var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					})();
				</script>
				<noscript>Zet Javascript aan om de reacties te kunnen bekijken.</noscript>
		</div>
	</div>
</div>
<h1><?=html_escape($importeur->importeur_naam);?></h1>

<div class="panel panel-danger">
	<div class="panel-heading"><h2><?=html_escape($importeur->importeur_naam);?> informatie</h2></div>
	<div class="panel-body">
		<? if($importeur->importeur_omschrijving): ?>
			<p><?=$importeur->importeur_omschrijving;?></p>
		<? else: ?>
			Er is (nog) geen omschrijving beschikbaar voor deze vuurwerk importeur / fabrikant
		<? endif; ?>
	</div>
</div>

<h2>Vuurwerk van vuurwerk importeur / fabrikant <?=html_escape($importeur->importeur_naam);?></h2>

<? if(empty($producten)): ?>
	<div class="alert alert-info" role="alert">Er zijn (nog) geen producten bekend van <?=html_escape($importeur->importeur_naam);?>.</div>
<? else: ?>
	<div class="row">
		<? foreach($producten as $merk=>$products): ?>
			<div class="col-sm-6">
				<div class="panel panel-danger">
					<div class="panel-heading"><h3><?=$merk;?></h3></div>
					<div class="list-group">
						<? foreach($products as $product): ?>
							<a href="<?=site_url($product->soort_slug.'/'.$product->merk_slug.'/'.$product->slug);?>" class="list-group-item" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
								<div class="pull-left">
									<? if(file_exists('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png')): ?>
										<img src="<?=site_url('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png');?>" alt="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
									<? endif; ?>
								</div>
								<h4 class="list-group-item-heading"><?=html_escape($product->naam);?></h4>
								<p class="list-group-item-text"><?=$product->prijs ? 'In '.config_item('jaar').' te koop vanaf &euro;'.price($product->prijs) : ($product->buitenland ? 'Niet te koop bij Nederlandse vuurwerk winkels' : 'Geen prijs bekend of niet meer te koop');?></p>
							</a>
						<? endforeach; ?>
					</div>
				</div>
			</div>
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
				var disqus_title = 'Importeur <?=html_escape($importeur->importeur_naam);?>';
				(function() {
					var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				})();
			</script>
			<noscript>Zet Javascript aan om de reacties te kunnen bekijken.</noscript>
	</div>
</div>

<h1>Vuurwerk top 10</h1>

<div class="panel panel-danger panel-body">
	Opzoek naar het beste vuurwerk? <a href="<?=site_url();?>">Vuurwerk-vergelijken.nl</a> heeft het beste vuurwerk voor je op een rijtje gezet! Deze top vuurwerk lijsten zijn samengesteld middels de stemmen van bezoekers. Ben je van mening dat een ander product hier hoort te staan? Beoordeel het vuurwerk en wie weet staat binnenkort jouw favoriete product wel hier in de vuurwerk top 10!
</div>

<div class="row">
	<? foreach($soorten as $soort): ?>
		<? if(isset($producten[$soort->soort_naam])): ?>
			<? $counter = 1; ?>
			<div class="col-sm-6">
				<div class="panel panel-danger">
					<div class="panel-heading"><h2>Top 10 <?=html_escape(strtolower($soort->soort_naam));?></h2></div>
					<? if($soort->soort_omschrijving_kort): ?>
						<div class="panel-body">
							<?=html_escape($soort->soort_omschrijving_kort);?>
						</div>
					<? endif; ?>
					<div class="list-group">
						<? foreach($producten[$soort->soort_naam] as $product): ?>
							<a href="<?=site_url($product->soort_slug.'/'.$product->merk_slug.'/'.$product->slug);?>" class="list-group-item" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
								<div class="pull-left">
									<span class="badge alert-danger top-number"><?=$counter;?></span>
									<? if(file_exists('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png')): ?>
										<img src="<?=site_url('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png');?>" alt="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
									<? endif; ?>
								</div>
								<div class="pull-right">
									<span class="glyphicon glyphicon-star"></span> <?=$product->beoordeling;?>
								</div>
								<h4 class="list-group-item-heading"><?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?></h4>
								<p class="list-group-item-text"><?=$product->prijs ? 'In '.config_item('jaar').' te koop vanaf &euro;'.price($product->prijs) : 'Geen prijs bekend of niet meer te koop';?></p>
							</a>
							<? $counter++;?>
						<? endforeach; ?>
					</div>
				</div>
			</div>
		<? endif; ?>
	<? endforeach; ?>
</div>
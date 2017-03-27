<h1>Zoeken<?=$this->uri->segment(2) ? ' naar "'.html_escape(str_replace('-',' ',$this->uri->segment(2))).'"' : '';?></h1>

<? if(isset($winkels) AND $winkels): ?>
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h2>Gevonden vuurwerk winkels</h2>
		</div>
		<div class="list-group">
			<? foreach($winkels as $winkel): ?>
				<a href="<?=site_url('winkels/'.$winkel->slug);?>" title="<?=html_escape($winkel->winkel_naam);?>" class="list-group-item">
					<strong><?=html_escape($winkel->winkel_naam);?></strong>
				</a>
			<? endforeach; ?>
		</div>
	</div>
<? endif; ?>

<? if(isset($importeurs) AND $importeurs): ?>
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h2>Gevonden vuurwerk importeurs</h2>
		</div>
		<div class="list-group">
			<? foreach($importeurs as $importeur): ?>
				<a href="<?=site_url('importeurs/'.$importeur->importeur_slug);?>" title="<?=html_escape($importeur->importeur_naam);?>" class="list-group-item">
					<strong><?=html_escape($importeur->importeur_naam);?></strong>
				</a>
			<? endforeach; ?>
		</div>
	</div>
<? endif; ?>

<? if(isset($producten) AND $producten): ?>
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h2>Gevonden producten</h2>
		</div>
		<div class="list-group">
			<? foreach($producten as $product): ?>
				<a href="<?=site_url($product->soort_slug.'/'.$product->merk_slug.'/'.$product->slug);?>" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>" class="list-group-item">
					<? if(file_exists('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png')): ?>
						<img src="<?=site_url('img/producten/'.$product->product_id.'/thumb50/'.$product->slug.'.png');?>" alt="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
					<? endif; ?>
					<strong><?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?></strong>
				</a>
			<? endforeach; ?>
		</div>
	</div>
<? endif; ?>
<? if(!isset($producten) AND !isset($importeurs) AND !isset($winkels)): ?>
	<div class="alert alert-info" role="alert">Typ hierboven een zoekwoord in.</div>
<? elseif(!$producten AND !$importeurs AND !$winkels): ?>
	<div class="alert alert-info" role="alert">Er is <strong>niets gevonden</strong>, probeer je <strong>zoekterm zo kort mogelijk</strong> te houden. Ben je opzoek naar bijvoorbeeld cakes van Barely Legal? Zoek dan op "barely legal" in plaats van "cakes van barely legal". Mocht het echt niet lukken kan je altijd nog via Google de website doorzoeken: <strong><a href="https://www.google.nl/search?q=site%3Avuurwerk-vergelijken.nl%20<?=html_escape(str_replace('-',' ',$this->uri->segment(2)));?>" target="_blank">https://www.google.nl/search?q=site%3Avuurwerk-vergelijken.nl%20<?=html_escape(str_replace('-',' ',$this->uri->segment(2)));?></a></strong></div>
<? endif; ?>
<h1>Vuurwerkwinkels</h1>

<div class="panel panel-danger">
	<div class="panel-heading"><h2>Alle vuurwerkwinkels in Nederland</h2></div>
	<div class="panel-body">
		Opzoek naar een vuurwerk winkel in Nederland? Wij hebben vrijwel alle vuurwerkwinkels verzameld en deze worden hieronder overzichtelijk weergegeven. Mist er een vuurwerk winkel? <a href="#" class="add-store">Laat het ons weten!</a>
	</div>
</div>

<div class="panel panel-danger">
	<div class="panel-body">
		<div id="map-canvas"></div>
	</div>
</div>

<? $provincie = false; ?>
<? foreach($winkels as $provincie=>$winkel): ?>
	<div class="panel panel-danger" id="<?=html_escape($provincie);?>">
		<div class="panel-heading"><h2>Vuurwerkwinkels in de provincie <?=html_escape($provincie);?></h2></div>
		<div class="panel-body">
			Alle vuurwerkwinkels in <?=html_escape($provincie);?>:
		</div>
		<div class="list-group">
			<? foreach($winkel as $shop): ?>
				<? if($shop->lat && $shop->lng): ?>
					<? $locations[] = '["'.html_escape($shop->winkel_naam).'","'.str_replace(',','.',$shop->lat).'","'.str_replace(',','.',$shop->lng).'","<strong>'.html_escape($shop->winkel_naam).'</strong><br>'.html_escape($shop->adres).'<br>'.html_escape($shop->postcode).' '.html_escape($shop->plaats).'<br><a href=\"'.site_url('winkels/'.$shop->slug).'\">Ga naar deze winkel</a>"]'; ?>
				<? endif; ?>
				<a href="<?=site_url('winkels/'.$shop->slug);?>" class="list-group-item">
					<? if($shop->gemiddeld): ?>
						<div class="pull-right <?=$shop->gemiddeld <= 0 ? 'text-success' : 'text-danger';?>"><?=$shop->gemiddeld.'%';?></div>
					<? endif; ?>
					<h3 class="list-group-item-heading"><?=html_escape($shop->winkel_naam);?><?=$shop->affiliate ? '</strong> <span class="label label-success">Aanrader</span>' : '';?></h3>
					<p class="list-group-item-text"><?=$shop->beoordeling;?> <span class="glyphicon glyphicon-star"></span> <?=html_escape($shop->adres);?> <?=html_escape($shop->postcode);?> <?=html_escape($shop->plaats);?></p>
				</a>
			<? endforeach;?>
		</div>
	</div>
<? endforeach; ?>

<script>
var locations = [<?=implode(',',$locations); ?>];
</script>

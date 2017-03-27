<h1 class="text-center"><img src="<?=site_url('img/vuurwerk-vergelijken.png');?>" alt="Vuurwerk Vergelijken" class="img-responsive center-block"><small class="hidden-xs">Vergelijk eenvoudig de prijzen van alle vuurwerkwinkels in Nederland!</small></h1>

<div class="row home-categories">
	<? $counter = 1; ?>
	<? foreach($soorten as $soort): ?>
		<? if($counter <= 4): ?>
			<div class="col-xs-6 col-md-3">
				<div class="thumbnail">
					<a href="<?=site_url($soort->soort_slug);?>" title="Vergelijk <?=strtolower($soort->soort_naam);?>">
						<img src="<?=($soort->soort_afbeelding ? site_url('img/soorten/'.$soort->soort_afbeelding) : '//placehold.it/300x200');?>" alt="<?=$soort->soort_omschrijving_kort;?>">
					</a>
					<div class="caption">
						<h3><a href="<?=site_url($soort->soort_slug);?>" title="Vergelijk <?=strtolower($soort->soort_naam);?>"><?=$soort->soort_naam;?></a></h3>
						<p class="hidden-xs"><?=$soort->soort_omschrijving_kort;?></p>
						<a href="<?=site_url($soort->soort_slug);?>" class="btn btn-danger btn-block hidden-xs" role="button" title="Vergelijk <?=strtolower($soort->soort_naam);?>">Vergelijk <?=strtolower($soort->soort_naam);?></a>
					</div>
				</div>
			</div>
		<? else: ?>
			<div class="col-xs-12 col-sm-6<?=($counter <= 7 ? ' col-md-4' : '');?>">
				<div class="thumbnail thumbnail-small">
					<a href="<?=site_url($soort->soort_slug);?>" title="Vergelijk <?=strtolower($soort->soort_naam);?>">
						<img src="<?=($soort->soort_afbeelding ? site_url('img/soorten/'.$soort->soort_afbeelding) : '//placehold.it/50x50');?>" alt="<?=$soort->soort_omschrijving_kort;?>" class="pull-left">
					</a>
					<h3 class="pull-left"><a href="<?=site_url($soort->soort_slug);?>" title="Vergelijk <?=strtolower($soort->soort_naam);?>"><?=$soort->soort_naam;?></a></h3>
					<a href="<?=site_url($soort->soort_slug);?>" class="btn btn-danger" title="Vergelijk <?=strtolower($soort->soort_naam);?>" role="button"><span class="glyphicon glyphicon-chevron-right"></span></a>
					<div class="clearfix"></div>
				</div>
			</div>
		<? endif; ?>
		<? $counter++; ?>
	<? endforeach; ?>
</div>

<a href="<?=site_url('top-10');?>" class="btn btn-danger btn-block btn-lg margin-bottom-20" title="Vuurwerk top 10"><span class="glyphicon glyphicon-star"></span> Bekijk de vuurwerk top 10 <span class="glyphicon glyphicon-star"></span></a>

<div class="panel panel-danger">
	<div class="panel-heading">
		Populair vuurwerk
	</div>
	<div class="panel-body">
		<div class="row">
			<? foreach($populair as $product): ?>
				<div class="col-xs-6 col-md-3">
					<div class="thumbnail">
						<a href="<?=site_url($product->soort_slug.'/'.$product->merk_slug.'/'.$product->slug);?>" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
							<? if(file_exists('img/producten/'.$product->product_id.'/thumb260/'.$product->slug.'.png')): ?>
								<img src="<?=site_url('img/producten/'.$product->product_id.'/thumb260/'.$product->slug.'.png');?>" alt="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>">
							<? endif; ?>
							<? if($product->prijs): ?>
								<span class="label label-danger thumbnail-price"><small>Vanaf</small> &euro;<?=price($product->prijs);?></span>
							<? endif; ?>
						</a>
						<div class="caption">
							<p class="oneliner"><a href="<?=site_url($product->soort_slug.'/'.$product->merk_slug.'/'.$product->slug);?>" title="<?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?>"><?=!stristr($product->naam,$product->merk_naam) ? html_escape($product->merk_naam).' ' : '';?><?=html_escape($product->naam);?></a></p>
						</div>
					</div>
				</div>
			<? endforeach;?>
		</div>		
	</div>
</div>

<div class="panel panel-danger">
	<div class="panel-heading">
		<h2>Vuurwerk prijzen vergelijken</h2>
	</div>
	<div class="panel-body">
		<p>Alle folders bekijken en websites afspeuren voor de beste prijs? Dat hoeft niet meer! Met <a href="//vuurwerk-vergelijken.nl">vuurwerk-vergelijken.nl</a> zorgen wij dat alles netjes voor je op een rijtje staat. Wij zorgen, samen met onze bezoekers, er elk jaar voor dat de nieuwste producten met prijzen, video's én specificaties hier te vinden zijn. Dit alles wordt, in tegenstelling tot veel andere websites, heel overzichtelijk weergeven op je pc, tablet én smartphone. Naast het vergelijken van prijzen en specificaties van cakes, vuurpijlen, paketten en matten helpen wij je graag bij al je vragen omtrent vuurwerk.</p>
	</div>
</div>

<div class="panel panel-danger">
	<div class="panel-heading">
		<h2>Vuurwerk kopen</h2>
	</div>
	<div class="panel-body">
		<p>Ben je van plan dit jaar weer vuurwerk te kopen? Neem dan zeker een kijkje op <a href="//vuurwerk-vergelijken.nl">vuurwerk-vergelijken.nl</a>! Het kan namelijk behoorlijk in je portemonnee schelen door eerst vuurwerk te vergelijken. Naast het vergelijken raden wij aan om vuurwerk in de voorverkoop te bestellen. In de voorverkoop hebben veel winkels acties met gratis vuurwerk bij besteding van een bepaald bedrag! Daarnaast zien wij geregeld dat winkels de prijzen omhoog gooien na de voorverkoop. Het gaat dat vaak om enkele euro's, dat alles bij elkaar opgeteld is vaak nog een behoorlijk bedrag. Ben je trouwens bekend met de huidige <a href="<?=site_url('vuurwerkregels');?>">vuurwerkregels</a> in Nederland?</p>
	</div>
</div>

<div class="panel panel-danger">
	<div class="panel-heading">
		<h2>Illegaal vuurwerk</h2>
	</div>
	<div class="panel-body">
		<p>Omdat de vuurwerk prijzen steeds hoger worden in Nederland gaan veel mensen naar het buiteland voor vuurwerk. België, maar ook Duitsland zijn zeer populair. In Duitsland wordt vuurwerk bijvoorbeeld gewoon in de supermarkt verkocht. Tevens zijn de regels omtrent vuurwerk in het buitenland vaak minder streng dan in Nederland waardoor je vaak meer voor minder hebt. Het vuurwerk uit het buitenland wordt hier in Nederland als illegaal gezien, dit komt omdat het vuurwerk niet goedgekeurd is voor gebruik in Nederland. Dit neemt echter niet weg dat het vaak prima vuurwerk is! Het is tenslotte in het land waar het vandaan komt goedgekeurd. Wij van <a href="//vuurwerk-vergelijken.nl">vuurwerk-vergelijken.nl</a> moedigen niet aan om vuurwerk in het buitenland te kopen, populair vuurwerk uit het buitenland wordt echter wél getoond op de website.</p>
	</div>
</div>

<div class="progress">
	<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
		
	</div>
</div>

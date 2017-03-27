<h1>Vuurwerk importeurs / fabrikanten</h1>

<div class="panel panel-danger">
	<div class="panel-heading"><h2>Alle vuurwerk importeurs / fabrikanten</h2></div>
	<!-- <div class="panel-body">
		Vuurwerk importeurs en fabrikanten informatie...
	</div> -->
	<div class="list-group">
		<? foreach($importeurs as $importeur): ?>
			<a href="<?=site_url('importeurs/'.$importeur->importeur_slug);?>" class="list-group-item">
				<h3 class="list-group-item-heading"><?=html_escape($importeur->importeur_naam);?></h3>
				<!-- <p class="list-group-item-text">Importeur / fabrikant informatie...</p> -->
			</a>
		<? endforeach;?>
	</div>
</div>

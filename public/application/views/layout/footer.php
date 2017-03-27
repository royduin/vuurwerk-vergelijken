	<? if(!isset($_GET['vuurwerkmania'])): ?>
		<!-- <div class="center-block ad-block">
			<a href="http://dt51.net/c/?wi=248205&amp;si=9863&amp;li=1441783&amp;ws=footer&amp;dl=" target="_blank">
				<img src="<?=site_url('img/vuurwerkmania.jpg');?>" class="img-responsive" alt="Gratis cake bij Vuurwerkmania">
			</a>
		</div> -->
	<? endif; ?>

	<div class="center-block hidden-xs ad-block">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-6642181733327735" data-ad-slot="2717183808"></ins>
		<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
	</div>

	<? if($layout == 'producten'): ?>
		<? $this->load->view('modals/addproduct'); ?>
	<? endif; ?>

	<? if($this->uri->segment(1) == 'winkels' OR isset($modal_winkels)): ?>
		<? $this->load->view('modals/addstore'); ?>
	<? endif; ?>
	
	<? if(isset($modal_winkels)): ?>
		<? $this->load->view('modals/addprice'); ?>
	<? endif; ?>

	<? if(isset($videos)): ?>
		<? $this->load->view('modals/addvideo'); ?>
	<? endif; ?>

	<? if(!$this->ion_auth->logged_in()): ?>
		<? $this->load->view('modals/register'); ?>
		<? $this->load->view('modals/login'); ?>
	<? endif; ?>

	<div id="loader">
		<img src="<?=site_url('img/loader.gif');?>" alt="">
	</div>
<footer>
	<div class="row hidden-sm hidden-xs footer-menu">
		<div class="col-sm-3">
			<strong>Vuurwerk</strong>
			<ul class="list-unstyled">
				<li><span class="glyphicon glyphicon-chevron-right"></span> <a href="<?=site_url('top-10');?>">Vuurwerk top 10</a></li>
				<li><span class="glyphicon glyphicon-chevron-right"></span> <a href="<?=site_url('vuurwerkregels');?>">Vuurwerkregels</a></li>
			</ul>
		</div>
		<div class="col-sm-3">
			<strong>Vuurwerk importeurs/fabrikanten</strong>
			<ul class="list-unstyled">
				<? foreach($footer_importeurs as $importeur): ?>
					<li><span class="glyphicon glyphicon-chevron-right"></span> <a href="<?=site_url('importeurs/'.$importeur->importeur_slug);?>"><?=html_escape($importeur->importeur_naam);?></a></li>
				<? endforeach; ?>
				<li><span class="glyphicon glyphicon-chevron-right"></span> <a href="<?=site_url('importeurs');?>">Bekijk alle importeurs/fabrikanten</a></li>
			</ul>
		</div>
		<div class="col-sm-3">
			<strong>Vuurwerkwinkels</strong>
			<ul class="list-unstyled">
				<? foreach($footer_provincies as $provincie): ?>
					<li><span class="glyphicon glyphicon-chevron-right"></span> <a href="<?=site_url('winkels');?>#<?=html_escape($provincie->provincie);?>">Vuurwerkwinkels in <?=html_escape($provincie->provincie);?></a></li>
				<? endforeach; ?>
				<li><span class="glyphicon glyphicon-chevron-right"></span> <a href="<?=site_url('winkels');?>">Bekijk alle vuurwerk winkels</a></li>
			</ul>
		</div>
		<div class="col-sm-3">
			<strong>Vuurwerk soorten</strong>
			<ul class="list-unstyled">
				<? foreach($soorten as $soort): ?>
					<li><span class="glyphicon glyphicon-chevron-right"></span> <a href="<?=site_url($soort->soort_slug);?>"><?=$soort->soort_naam;?></a></li>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
	<span class="hidden-xs pull-left">Copyright &copy; 2013 - <?=date('Y');?> Vuurwerk-vergelijken.nl (<a href="<?=site_url('disclaimer');?>">disclaimer</a>)</span> <span class="pull-right">Alle getoonde prijzen zijn voorverkoop prijzen</span>
</footer>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=site_url('js/vendor/jquery-1.10.2.min.js');?>"><\/script>')</script>
<script src="<?=site_url('js/vendor/bootstrap.min.js');?>"></script>
<script src="<?=site_url('js/vendor/jquery.fancybox.pack.js');?>"></script>
<script src="<?=site_url('js/vendor/jquery.fancybox-media.js');?>"></script>
<!-- <script src="<?=site_url('js/plugins.js');?>"></script> -->
<? if(!$this->uri->segment(1)): ?>
	<script src="<?=site_url('js/vendor/jquery.countdown.min.js');?>"></script>
<? endif; ?>
<? if($layout == 'producten'): ?>
	<script src="<?=site_url('js/vendor/jquery.nouislider.min.js');?>"></script>
<? endif; ?>
<script src="<?=site_url('js/main.'.config_item('version').'.js');?>"></script>
<? if(isset($maps)): ?>
	<script src="<?=site_url('js/maps.js');?>"></script>
<? endif; ?>
<script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5442935b4b08cbd5" async></script>
<? if(!$this->ion_auth->is_admin()): ?>
<script>
	(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
	function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
	e=o.createElement(i);r=o.getElementsByTagName(i)[0];
	e.src='//www.google-analytics.com/analytics.js';
	r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
	ga('create','XX-XXXXXXXX-X');ga('send','pageview');
</script>
<? endif; ?>
</body>
</html>

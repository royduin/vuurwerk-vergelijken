<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?=(isset($page_title) ? $page_title : config_item('website_name')); ?></title>
	<? if(isset($page_descr) AND !empty($page_descr)): ?>
		<meta name="description" content="<?=$page_descr;?>">
	<? endif; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=site_url('css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?=site_url('css/bootstrap-theme.min.css');?>">
	<link rel="stylesheet" href="<?=site_url('css/fancybox/jquery.fancybox.css');?>">
	<? if($layout == 'producten'): ?>
		<link rel="stylesheet" href="<?=site_url('css/jquery.nouislider.css');?>">
	<? endif; ?>
	<link rel="stylesheet" href="<?=site_url('css/main.'.config_item('version').'.css');?>">
	<script src="<?=site_url('js/vendor/modernizr-2.7.1.min.js');?>"></script>
	<? if(isset($noindex)): ?>
	<meta name="robots" content="noindex, follow">
	<? endif; ?>
	<? if(isset($maps)): ?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCd8davkL6OWRedoWisz3bLywScC5GJKhg&sensor=true&language=nl&region=nl"></script>
	<? endif; ?>
	<link rel="canonical" href="<?=current_url();?>">
	<? if(isset($page_prev)): ?>
		<link rel="prev" href="<?=$page_prev;?>" />
	<? endif; ?>
	<? if(isset($page_next)): ?>
		<link rel="next" href="<?=$page_next;?>" />
	<? endif; ?>

	<!-- Icons -->
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
	<link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196">
	<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/mstile-144x144.png">

	<!-- Social media -->
	<meta property="og:site_name" content="Vuurwerk-vergelijken.nl" />
	<meta property="og:locale" content="nl_NL" />
	<meta property="og:title" content="<?=(isset($page_title) ? $page_title : config_item('website_name')); ?>"/>
	<meta property="og:type" content="<?=$layout == 'product' ? 'product' : 'website'; ?>"/>
	<? if($layout == 'product'): ?>
		<? if(file_exists('img/producten/'.$product->product_id.'/'.$product->slug.'.png')): ?>
			<meta property="og:image" content="<?=site_url('img/producten/'.$product->product_id.'/'.$product->slug.'.png');?>"/>
		<? else: ?>
			<meta property="og:image" content="<?=site_url('img/logo-260.png');?>"/>	
		<? endif; ?>
		<? if($product->video): ?>
			<meta property="og:video" content="<?=$product->video;?>"/>
		<? endif; ?>
		<? if(isset($prijs_laagste)): ?>
			<meta property="og:price:amount" content="<?=str_replace(',','.',price($prijs_laagste));?>" />
		<? endif; ?>
		<meta property="og:price:currency" content="EUR" />
	<? else: ?>
		<meta property="og:image" content="<?=site_url('img/logo-260.png');?>"/>
	<? endif; ?>
	<meta property="og:url" content="<?=current_url();?>"/>
	<? if(isset($page_descr) AND !empty($page_descr)): ?>
		<meta property="og:description" content="<?=$page_descr;?>"/>
	<? endif; ?>

</head>
<body<?=(isset($_GET['vuurwerkmania']) ? ' style="background: #191919 url(/img/background.jpg) no-repeat center top fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : '');?>>
<!--[if lt IE 8]>
	<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="container"<?=(isset($_GET['vuurwerkmania']) ? ' style="background: white;"' : '');?>>
	<p class="text-center">Deze website overnemen? Neem contact op met: <a href="mailto:info@vuurwerk-vergelijken.nl">info@vuurwerk-vergelijken.nl</a></p>
	<div class="navbar navbar-default navbar-inverse" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?=site_url('verlanglijst');?>" class="navbar-toggle navbar-wishlist" title="Verlanglijst"><span class="glyphicon glyphicon-heart"></span></a>
			<a class="navbar-brand" href="<?=site_url();?>">Vuurwerk vergelijken</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav visible-xs">
				<? foreach($soorten as $srt): ?>
				<li<?=($this->uri->segment(1) == $srt->soort_slug ? ' class="active"' : '');?>><a href="<?=site_url($srt->soort_slug);?>"><?=$srt->soort_naam;?></a></li>
				<? endforeach; ?>
				<li class="divider"></li>
				<li<?=($this->uri->segment(1) == 'winkels' ? ' class="active"' : '');?>><a href="<?=site_url('winkels');?>">Winkels</a></li>
				<li<?=($this->uri->segment(1) == 'importeurs' ? ' class="active"' : '');?>><a href="<?=site_url('importeurs');?>">Importeurs</a></li>
				<li class="divider"></li>
				<? if(!$this->ion_auth->logged_in()): ?>
					<li><a href="#" class="login">Inloggen</a></li>
					<li><a href="#" class="register">Registeren</a></li>
				<? else: ?>
					<? if($this->ion_auth->is_admin()): ?>
						<li><a href="<?=site_url('admin');?>">Beheer</a></li>
					<? endif; ?>
					<li><a href="<?=site_url('account');?>">Mijn account</a></li>
					<li><a href="<?=site_url('uitloggen');?>">Uitloggen</a></li>
				<? endif; ?>
				<li class="divider"></li>
				<li<?=($this->uri->segment(1) == 'contact' ? ' class="active"' : '');?>><a href="<?=site_url('contact');?>">Contact</a></li>
			</ul>
			<ul class="nav navbar-nav visible-sm">
				<? $counter = 1; ?>
				<? foreach($soorten as $srt): ?>
					<? if($counter == 5): ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Meer <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
					<? endif; ?>
					<li<?=($this->uri->segment(1) == $srt->soort_slug ? ' class="active"' : '');?>><a href="<?=site_url($srt->soort_slug);?>"><?=$srt->soort_naam;?></a></li>
					<? $counter++; ?>
				<? endforeach; ?>
						<li class="divider"></li>
						<li<?=($this->uri->segment(1) == 'winkels' ? ' class="active"' : '');?>><a href="<?=site_url('winkels');?>">Winkels</a></li>
						<li<?=($this->uri->segment(1) == 'importeurs' ? ' class="active"' : '');?>><a href="<?=site_url('importeurs');?>">Importeurs</a></li>
						<li class="divider"></li>
						<? if(!$this->ion_auth->logged_in()): ?>
							<li><a href="#" class="login">Inloggen</a></li>
							<li><a href="#" class="register">Registeren</a></li>
						<? else: ?>
							<? if($this->ion_auth->is_admin()): ?>
								<li><a href="<?=site_url('admin');?>">Beheer</a></li>
							<? endif; ?>
							<li><a href="<?=site_url('account');?>">Mijn account</a></li>
							<li><a href="<?=site_url('uitloggen');?>">Uitloggen</a></li>
						<? endif; ?>
						<li class="divider"></li>
						<li<?=($this->uri->segment(1) == 'contact' ? ' class="active"' : '');?>><a href="<?=site_url('contact');?>">Contact</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav visible-md">
				<? $counter = 1; ?>
				<? foreach($soorten as $srt): ?>
					<? if($counter == 7): ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Meer <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
					<? endif; ?>
					<li<?=($this->uri->segment(1) == $srt->soort_slug ? ' class="active"' : '');?>><a href="<?=site_url($srt->soort_slug);?>"><?=$srt->soort_naam;?></a></li>
					<? $counter++; ?>
				<? endforeach; ?>
						<li class="divider"></li>
						<li<?=($this->uri->segment(1) == 'winkels' ? ' class="active"' : '');?>><a href="<?=site_url('winkels');?>">Winkels</a></li>
						<li<?=($this->uri->segment(1) == 'importeurs' ? ' class="active"' : '');?>><a href="<?=site_url('importeurs');?>">Importeurs</a></li>
						<li class="divider"></li>
						<? if(!$this->ion_auth->logged_in()): ?>
							<li><a href="#" class="login">Inloggen</a></li>
							<li><a href="#" class="register">Registeren</a></li>
						<? else: ?>
							<? if($this->ion_auth->is_admin()): ?>
								<li><a href="<?=site_url('admin');?>">Beheer</a></li>
							<? endif; ?>
							<li><a href="<?=site_url('account');?>">Mijn account</a></li>
							<li><a href="<?=site_url('uitloggen');?>">Uitloggen</a></li>
						<? endif; ?>
						<li class="divider"></li>
						<li<?=($this->uri->segment(1) == 'contact' ? ' class="active"' : '');?>><a href="<?=site_url('contact');?>">Contact</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav visible-lg">
				<? $counter = 1; ?>
				<? foreach($soorten as $srt): ?>
					<? if($counter == 8): ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Meer <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
					<? endif; ?>
					<li<?=($this->uri->segment(1) == $srt->soort_slug ? ' class="active"' : '');?>><a href="<?=site_url($srt->soort_slug);?>" title="<?=$srt->soort_naam;?>"><?=$srt->soort_naam;?></a></li>
					<? $counter++; ?>
				<? endforeach; ?>
						<li class="divider"></li>
						<li<?=($this->uri->segment(1) == 'winkels' ? ' class="active"' : '');?>><a href="<?=site_url('winkels');?>">Winkels</a></li>
						<li<?=($this->uri->segment(1) == 'importeurs' ? ' class="active"' : '');?>><a href="<?=site_url('importeurs');?>">Importeurs</a></li>
						<li class="divider"></li>
						<? if(!$this->ion_auth->logged_in()): ?>
							<li><a href="#" class="login">Inloggen</a></li>
							<li><a href="#" class="register">Registeren</a></li>
						<? else: ?>
							<? if($this->ion_auth->is_admin()): ?>
								<li><a href="<?=site_url('admin');?>">Beheer</a></li>
							<? endif; ?>
							<li><a href="<?=site_url('account');?>">Mijn account</a></li>
							<li><a href="<?=site_url('uitloggen');?>">Uitloggen</a></li>
						<? endif; ?>
						<li class="divider"></li>
						<li<?=($this->uri->segment(1) == 'contact' ? ' class="active"' : '');?>><a href="<?=site_url('contact');?>">Contact</a></li>
					</ul>
				</li>
			</ul>
			<a href="<?=site_url('verlanglijst');?>" class="pull-right navbar-toggle navbar-wishlist hidden-xs" title="Verlanglijst"><span class="glyphicon glyphicon-heart"></a>
		</div>
	</div>
	
	<!--<div class="center-block ad-block">
		<a href="https://dt51.net/c/?wi=248205&si=11200&li=1502368&ws=" target="_blank">
			<img src="https://animated.dt71.net/11200/1502368/index.php?wi=248205&si=11200&li=1502368&ws=" alt="" class="img-responsive" style="display: inline-block;">
		</a>
	</div>-->
	
	<? if(isset($_GET['vuurwerkmania'])): ?>
		<div class="center-block ad-block">
			<a href="http://dt51.net/c/?wi=248205&amp;si=9863&amp;li=1441783&amp;ws=footer&amp;dl=" target="_blank">
				<img src="<?=site_url('img/vuurwerkmania.jpg');?>" class="img-responsive" alt="Gratis cake bij Vuurwerkmania">
			</a>
		</div>
	<? endif; ?>

	<div class="search">
		<?=form_open(site_url('zoeken'),['role' => 'form','class' => 'form-inline']);?>
			<div class="input-group">
				<input type="text" class="form-control" name="q" placeholder="Zoeken..." value="<?=$this->uri->segment(1) == 'zoeken' ? html_escape(str_replace('-',' ',$this->uri->segment(2))) : '';?>">
				<span class="input-group-btn">
					<button class="btn btn-danger" type="submit"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</form>
	</div>
	
	<? if($this->uri->segment(1)): ?>
		<ol class="breadcrumb">
			<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url();?>" itemprop="url"><span itemprop="title">Home</span></a></li>
			<? if(isset($soort) AND isset($merk) AND isset($product)): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url($soort->soort_slug);?>" itemprop="url"><span itemprop="title"><?=$soort->soort_naam;?></span></a></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url($soort->soort_slug.'/'.$merk->merk_slug);?>" itemprop="url"><span itemprop="title"><?=$merk->merk_naam;?></span></a></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title"><?=html_escape($product->naam);?></span></li>
			<? elseif(isset($soort) AND isset($merk)): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url($soort->soort_slug);?>" itemprop="url"><span itemprop="title"><?=$soort->soort_naam;?></span></a></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title"><?=$merk->merk_naam;?></span></li>
			<? elseif(isset($soort)): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title"><?=$soort->soort_naam;?></span></li>
			<? elseif($this->uri->segment(1) == 'admin'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><a href="<?=site_url('admin');?>" itemprop="url"><span itemprop="title">Beheer</span></a></li>
			<? elseif(isset($winkel)): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url('winkels');?>" itemprop="url"><span itemprop="title">Winkels</span></a></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title"><?=html_escape($winkel->winkel_naam);?></span></li>
			<? elseif(isset($winkels)): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Winkels</span></li>
			<? elseif(isset($importeur)): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url('importeurs');?>" itemprop="url"><span itemprop="title">Importeurs</span></a></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title"><?=$importeur->importeur_naam;?></span></li>
			<? elseif(isset($importeurs)): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Importeurs</span></li>
			<? elseif($this->uri->segment(1) == 'contact'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Contact</span></li>
			<? elseif($this->uri->segment(1) == 'disclaimer'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Disclaimer</span></li>
			<? elseif($this->uri->segment(1) == 'zoeken'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Zoeken</span></li>
			<? elseif($this->uri->segment(1) == 'verlanglijst'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Verlanglijst</span></li>
			<? elseif($this->uri->segment(1) == 'account'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Mijn account</span></li>
			<? elseif($this->uri->segment(1) == 'top-10'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Top 10</span></li>
			<? elseif($this->uri->segment(1) == 'vuurwerkregels'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Vuurwerk regels</span></li>
			<? elseif($layout == '404'): ?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">Pagina niet gevonden</span></li>
			<? endif; ?>
		</ol>
	<? endif; ?>

	<!-- <div class="center-block hidden-xs ad-block">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-6642181733327735" data-ad-slot="2717183808"></ins>
		<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
	</div> -->

<h1>Mijn account (<?=$user->username;?>)</h1>
<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h2>Account wijzigen</h2>
			</div>
			<div class="panel-body">
				<?=$this->session->flashdata('success') ? '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$this->session->flashdata('success').'</div>' : '';?>
				<?=$this->session->flashdata('error') ? '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$this->session->flashdata('error').'</div>' : '';?>
				<div class="alert alert-info">Wanneer je hieronder een weergave naam (en eventueel een website) opgeeft verschijnen deze gegevens onderaan een product pagina wanneer je het betreffende product (óf een prijs hieraan) hebt toegevoegd.</div>
				<?=form_open(site_url('account'),['role' => 'form','class' => 'form-horizontal']);?>
					<div class="form-group<?=form_error('email') ? ' has-error' : '';?>">
						<label for="email" class="control-label col-md-4">E-mail adres</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="email" id="email" placeholder="E-mail adres" value="<?=set_value('email',$user->email);?>">
							<?=form_error('email') ? '<p class="help-block">'.form_error('email').'</p>' : '';?>
						</div>
					</div>
					<div class="form-group<?=form_error('weergave-naam') ? ' has-error' : '';?>">
						<label for="weergave-naam" class="control-label col-md-4">Weergave naam</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="weergave-naam" id="weergave-naam" placeholder="Weergave naam" value="<?=set_value('weergave-naam',$user->weergave_naam);?>">
							<?=form_error('weergave-naam') ? '<p class="help-block">'.form_error('weergave-naam').'</p>' : '';?>
						</div>
					</div>
					<div class="form-group<?=form_error('website-url') ? ' has-error' : '';?>">
						<label for="website-url" class="control-label col-md-4">Website url</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="website-url" id="website-url" placeholder="http://website.nl" value="<?=set_value('website-url',$user->website_url);?>">
							<?=form_error('website-url') ? '<p class="help-block">'.form_error('website-url').'</p>' : '';?>
						</div>
					</div>
					<div class="form-group<?=form_error('password-current') ? ' has-error' : '';?>">
						<label for="password-current" class="control-label col-md-4">Huidig wachtwoord</label>
						<div class="col-md-8">
							<input type="password" class="form-control" name="password-current" id="password-current" placeholder="Huidig wachtwoord" value="">
							<?=form_error('password-current') ? '<p class="help-block">'.form_error('password-current').'</p>' : '';?>
						</div>
					</div>
					<div class="form-group<?=form_error('password-new') ? ' has-error' : '';?>">
						<label for="password-new" class="control-label col-md-4">Nieuw wachtwoord</label>
						<div class="col-md-8">
							<input type="password" class="form-control" name="password-new" id="password-new" placeholder="Nieuw wachtwoord" value="">
							<?=form_error('password-new') ? '<p class="help-block">'.form_error('password-new').'</p>' : '';?>
						</div>
					</div>
					<div class="form-group<?=form_error('password-new2') ? ' has-error' : '';?>">
						<label for="password-new2" class="control-label col-md-4">Herhaal wachtwoord</label>
						<div class="col-md-8">
							<input type="password" class="form-control" name="password-new2" id="password-new2" placeholder="Herhaal wachtwoord" value="">
							<?=form_error('password-new2') ? '<p class="help-block">'.form_error('password-new2').'</p>' : '';?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-9">
							<input type="submit" class="btn btn-danger pull-right" value="Wijzigen">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h2>Door jou toegevoegde producten en/of prijzen</h2>
			</div>
			<div class="panel-body">
				Nog in ontwikkeling...
			</div>
		</div>
	</div>
</div>
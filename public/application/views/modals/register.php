<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="registerModalLabel">Account aanmaken</h4>
			</div>
			<div class="modal-body">
				<?=form_open(site_url('ajax/register'),['role' => 'form','class' => 'form-horizontal']);?>
					<div class="form-group">
						<label for="register-username" class="control-label col-sm-4">Gebruikersnaam</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="register-username" id="register-username" placeholder="Gebruikersnaam">
						</div>
					</div>
					<div class="form-group">
						<label for="register-email" class="control-label col-sm-4">E-mail adres</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="register-email" id="register-email" placeholder="E-mail adres">
						</div>
					</div>
					<div class="form-group">
						<label for="register-password" class="control-label col-sm-4">Wachtwoord</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="register-password" id="register-password" placeholder="Wachtwoord">
						</div>
					</div>
					<div class="form-group">
						<label for="register-password2" class="control-label col-sm-4">Herhaal wachtwoord</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" name="register-password2" id="register-password2" placeholder="Herhaal wachtwoord">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
				<button type="button" class="btn btn-danger" id="register-submit">Aanmaken</button>
			</div>
		</div>
	</div>
</div>
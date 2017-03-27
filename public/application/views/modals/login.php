<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="loginModalLabel">Inloggen</h4>
			</div>
			<div class="modal-body">
				<?=form_open(site_url('ajax/login'),['role' => 'form','class' => 'form-horizontal']);?>
					<div class="form-group">
						<label for="login-email" class="control-label col-sm-3">E-mail adres</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="login-email" id="login-email" placeholder="E-mail adres">
						</div>
					</div>
					<div class="form-group">
						<label for="login-password" class="control-label col-sm-3">Wachtwoord</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="login-password" id="login-password" placeholder="Wachtwoord">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="login-stay" id="login-stay" value="1"> Ingelogd blijven
								</label>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
				<button type="button" class="btn btn-danger" id="login-submit">Inloggen</button>
			</div>
		</div>
	</div>
</div>
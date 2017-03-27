<h1>Afbeelding toevoegen</h1>

<? if($this->session->flashdata('success')): ?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		De afbeelding is toegevoegd!
	</div>
<? endif; ?>

<?=form_open(site_url('admin/addimage'),['role' => 'form','class' => 'form-horizontal']);?>
	<div class="form-group<?=form_error('naam') ? ' has-error' : '';?>">
		<label for="id" class="control-label col-sm-2">Product ID</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="id" id="id" placeholder="Product ID" value="<?=set_value('id'); ?>">
			<? if(form_error('id')): ?>
				<p class="help-block"><?=form_error('id'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group<?=form_error('afbeelding') ? ' has-error' : '';?>">
		<label for="afbeelding" class="control-label col-sm-2">Afbeelding</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="afbeelding" id="afbeelding" placeholder="Afbeelding url" value="<?=set_value('afbeelding'); ?>">
			<? if(form_error('afbeelding')): ?>
				<p class="help-block"><?=form_error('afbeelding'); ?></p>
			<? endif; ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input type="submit" class="btn btn-danger" name="submit" value="Toevoegen">
		</div>
	</div>
</form>
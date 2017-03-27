<style>
	input {
		width: 100%;
	}
	iframe {
		height: 90%;
		width: 33%;
		float: left;
	}
</style>

<? echo form_open('admin/search');?>
	<input type="text" name="term" value="<?=html_escape($this->input->post('term'));?>">
</form>

<?
$term = str_replace('+','%20',urlencode($this->input->post('term')));
if($this->input->post('term')):
?>

<iframe src="<?=site_url('admin/search/'.urlencode('site:vuurwerkbieb.nl').'%20'.$term);?>"></iframe>
<iframe src="<?=site_url('admin/search/'.urlencode('site:vuurwerkcrew.nl').'%20'.$term);?>"></iframe>
<iframe src="<?=site_url('admin/search/'.urlencode('site:freakpyromaniacs.com/products').'%20'.$term);?>"></iframe>

<? endif; ?>
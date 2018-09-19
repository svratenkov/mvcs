<!-- Black board partial, smth like command shell with 'Clear output' button -->
<div class="well well-sm">
	<pre class="bg-black">
		<?= $output; ?>
	</pre>
	<a href="<?= url('clear');?>" class="btn btn-danger" title="Clear compiler output">Clear output</a>
</div>

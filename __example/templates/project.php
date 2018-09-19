<div class="container-fluid">
	<h3><em>Project `<?= $active->name; ?>` details</em></h3>

	<table class="table table-bordered table-striped">
		<tr>
			<td style="text-align: right; font-weight: bold;">CSS file</td>
			<td><?= $active->css_file; ?></td>
		</tr>
		<tr>
			<td style="text-align: right; font-weight: bold;">SCSS file</td>
			<td><?= $active->scss_file; ?></td>
		</tr>
		<tr>
			<td style="text-align: right; font-weight: bold;">Cache Dir</td>
			<td>
				<?= $active->cache_dir; ?>
				&nbsp;
				<a href="<?= url('cache'); ?>" class="btn btn-warning btn-xs" title="Clear project cache">Clear Cache</a>
			</td>
		</tr>
		<tr>
			<td style="text-align: right; font-weight: bold;">CSS file style</td>
			<td><?= $css_format.' ('.$active->css_style.')'; ?></td>
		</tr>
		<tr>
			<td style="text-align: right; font-weight: bold;">CSS file signature</td>
			<td><?= $active->signature ? 'Yes' : 'No'; ?></td>
		</tr>
	</table>
</div>


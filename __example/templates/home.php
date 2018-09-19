<div class="container-fluid">
<br/>

<?php if ($alert_no_projects):?>
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h2 class="panel-title"><strong>Attention:</strong> There are no projects defined!</h2>
		</div>
		<div class="panel-body">
			<div class="alert alert-danger" role="alert">
				<p>
					<strong>Without projects any request to <b><code>ScssWeb</code></b> is redirected to this page!</strong>
				</p>
				<p>
					Please define one or more of your projects in the projects config file <code>projects.php</code> in <b><code>ScssWeb</code></b> root dir.
					You may use <code>projects.example.php</code> as a starting point.
				</p>
			</div>
		</div>
	</div>
<?php endif;?>

	<div class="panel panel-primary">
<style>
	.stackedit { display: flex; }
	.stackedit__left  { position: relative !important; width: auto !important; }
	.stackedit__right { position: relative !important; left: 2rem !important; }
</style>

<!--
		<div class="panel-heading">
			<h2 class="panel-title"><?= $title ?></h2>
		</div>
-->
		<div class="panel-body">
			<?= $text ?>
		</div>
	</div>
</div>

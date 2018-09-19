<div class="container-fluid">
	<div class="row">
		<!-- output card -->
		<div class="col-sm-8">
			<div class="card">
				<div class="card-block">
					<pre class="bg-black"><?= $output; ?></pre>
					<a href="<?= url('clear');?>" class="btn btn-danger" title="Clear compiler output">Clear output</a>
				</div>
			</div>
		</div>

		<!-- command card -->
		<div class="col-sm-4">
			<div class="card">
				<div class="card-header">Shell Working Dir</div>
			<!--<form class="form flex-between" enctype="multipart/form-data" method="post" action="<?= url('shell/swd') ?>">-->
				<form class="form d-flex align-content-between" method="post" action="<?= url('shell/swd') ?>">
					<input type="text" class="form-control" title="<?=$swd?>" name="swd" value="<?=$swd?>">
					<button type="submit" class="btn btn-secondary" title="Set this dir as Shell Working Dir">
						<span class="arrow arrow-right" style="border-left-color:green;"></span>
					</button>
				</form>

				<div class="card-header">Execute shell command</div>
				<form class="form d-flex align-content-between" method="post" action="<?= url('shell/exec') ?>">
					<input type="text" class="form-control" title="<?=$cmd?>" name="cmd" value="<?=$cmd?>">
					<button type="submit" class="btn btn-secondary" title="Execute this command in the Shell Working Dir">
						<span class="arrow arrow-right" style="border-left-color:green;"></span>
					</button>
				</form>
			</div>

			<!-- commands suite -->
			<div class="card">
				<div class="card-header"><strong>Shell commands suite</strong></div>
				<div class="card-body">
					<nav>
					<!--<ul class="nav">-->
						<ul class="list-group list-group-flush">
						<?php foreach ($groups as $group => $cmds): ?>
						<!--<li class="shellGroup" onclick="clicked(this, '<?=$group?>');">-->
							<li class="list-group-item shellGroup" onclick="clicked(this, '<?=$group?>');">
							<!--<button class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#sub-<?=$group?>">-->
								<button class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#sub-<?=$group?>">
									<span class="caret"></span>&nbsp;
									<strong><?= $group ?></strong>
									<span class="badge badge-pill badge-info"><?= sizeof($cmds) ?></span>
								</button>
							</li>

						<!--<ul class="nav<?= $visible[$group] ? '' : ' collapse' ?>" id="sub-<?= $group ?>">-->
							<ul class="list-group list-group-flush<?= $visible[$group] ? '' : ' collapse' ?>" id="sub-<?= $group ?>">
							<?php foreach ($cmds as $name => $def): ?>
								<li class="list-group-item">
									<span class="flex-between">
										<span class="form-control" title="<?= $def['desc'] ?>"><?= $def['cmd']; ?></span>
										<a class="btn btn-secondary" href="<?= url('shell/copy/'.$group.'/'.$name) ?>" title="Copy this command to exec panel">
											<span class="glyphicon glyphicon-edit" style="color:green;"></span>
										</a>
										<a class="btn btn-secondary" href="<?= url('shell/cmd/'.$group.'/'.$name) ?>" title="Execute this command in the Shell Working Dir">
											<span class="arrow arrow-right" style="border-left-color:green;"></span>
										</a>
									</span>
								</li>
							<?php endforeach; ?>
							</ul>
						<?php endforeach; ?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>

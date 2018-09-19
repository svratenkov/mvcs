<div class="container-fluid">
	<!-- output panel -->
	<div class="row">
		<div class="col-xs-8">
			<!-- Black board partial, smth like command shell with 'Clear output' button -->
			<div class="well well-sm">
				<pre class="bg-black">
					<?= $output; ?>
				</pre>
				<a href="<?= url('clear');?>" class="btn btn-danger" title="Clear compiler output">Clear output</a>
			</div>
		</div>

		<!-- command panel -->
		<div class="col-xs-4 panel-group">
			<div class="panel panel-group panel-default">
				<div class="panel-body">
					<div class="panel">
						<strong>Shell Working Dir</strong>
					<!--<form class="form flex-between" enctype="multipart/form-data" method="post" action="<?= url('shell/swd') ?>">-->
						<form class="form flex-between" method="post" action="<?= url('shell/swd') ?>">
							<input type="text" class="form-control" title="<?=$swd?>" name="swd" value="<?=$swd?>">
							<button type="submit" class="btn btn-default" title="Set this dir as Shell Working Dir">
								<span class="arrow arrow-right" style="border-left-color:green;"></span>
							</button>
						</form>
					</div>
					<div class="panel">
						<strong>Execute shell command</strong>
						<form class="form flex-between" method="post" action="<?= url('shell/exec') ?>">
							<input type="text" class="form-control" title="<?=$cmd?>" name="cmd" value="<?=$cmd?>">
							<button type="submit" class="btn btn-default" title="Execute this command in the Shell Working Dir">
								<span class="arrow arrow-right" style="border-left-color:green;"></span>
							</button>
						</form>
					</div>
				</div>
			</div>

			<!-- commands suite -->
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Shell commands suite</strong></div>
				<div class="panel-body">
					<nav>
						<ul class="nav">
						<?php foreach ($groups as $group => $cmds): ?>
							<li class="shellGroup" onclick="clicked(this, '<?=$group?>');">
								<button class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#sub-<?=$group?>">
									<span class="caret"></span>&nbsp;
									<strong><?= $group ?></strong>
									<span class="badge"><?= sizeof($cmds) ?></span>
								</button>
							</li>

							<ul class="nav<?= $visible[$group] ? '' : ' collapse' ?>" id="sub-<?= $group ?>">
							<?php foreach ($cmds as $name => $def): ?>
								<li>
									<span class="flex-between">
										<span class="form-control" title="<?= $def['desc'] ?>"><?= $def['cmd']; ?></span>
										<a class="btn btn-default" href="<?= url('shell/copy/'.$group.'/'.$name) ?>" title="Copy this command to exec panel">
											<span class="glyphicon glyphicon-edit" style="color:green;"></span>
										</a>
										<a class="btn btn-default" href="<?= url('shell/cmd/'.$group.'/'.$name) ?>" title="Execute this command in the Shell Working Dir">
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

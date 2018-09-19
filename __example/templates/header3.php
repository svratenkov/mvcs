<style type="text/css">
.btn-black {
  color: #fff;
  background-color: #000;
  border-color: #ccc;
}
.btn-black:hover {
  color: #fff;
  background-color: #888;
  border-color: #ccc;
}
</style>

<div class="container-fluid">
	<div class="row bg-info">
		<div class="col-xs-12">
			<a href="<?= url('/'); ?>" class="btn btn-default" title="SCSS Compiler Help"><strong>Home</strong></a>
			<a href="<?= url('compile');?>" class="btn btn-primary active" title="One-shot compilation of the active project">Compile</a>
		<?php if (! $watching) { ?>
			<a href="<?= url('watch');?>" class="btn btn-success" title="Start watching mode compilation of the active project">Watch</a>
		<?php } else { ?>
			<a href="<?= url('stop');?>" class="btn btn-danger" onclick="watchStop()" title="Stop watching mode compilation of the active project">Stop</a>
		<?php } ?>
			<a href="<?= url('shell');?>" class="btn btn-black" title="Windows CmdShell">Shell</a>

			<span class="btn"><strong>Project:</strong></span>
			<span class="dropdown">
				<button class="btn btn-default dropdown-toggle btn-warning" type="button" data-toggle="dropdown">
					<?=$active?>&nbsp;&nbsp;<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
				<?php foreach ((array) $projects as $name): ?>
					<li<?= $name == $active ? ' class="active"' : ''; ?>>
						<a href="<?= url('project/'.$name); ?>" title="Activate project <?=$name?> and show it's details"><?=$name?></a>
					</li>
				<?php endforeach; ?>
				</ul>
			</span>
		</div>
	</div>
</div>

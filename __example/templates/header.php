<div class="container-fluid py-2 mb-2 list-group-item-info">

	<a href="<?= url('shell');?>" class="btn btn-success btn-menu" title="Windows CmdShell">Shell</a>

	<a href="<?= url('compile');?>" class="btn btn-info btn-menu" title="One-shot compilation of the active project">Compile</a>

<?php if (! $watching):?>
	<a href="<?= url('watch');?>" class="btn btn-primary btn-menu" title="Start watching mode compilation of the active project">Watch</a>
<?php else:?>
	<a href="<?= url('stop');?>" class="btn btn-danger btn-menu" onclick="watchStop()" title="Stop watching mode compilation of the active project">Stop</a>
<?php endif;?>

	<a href="<?= url('help'); ?>" class="btn btn-secondary btn-menu" title="SCSS Compiler Help">Help</a>

<!--<span class="btn">Project:</span>-->
	<span class="dropdown">
		<button class="btn btn-warning btn-menu dropdown-toggle" type="button" data-toggle="dropdown" title="Select SCSS project">
			<?=$active?>&nbsp;&nbsp;<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
		<?php foreach ((array) $projects as $name): ?>
			<li<?= $name == $active ? ' class="active"' : ''; ?>>
				<a class="dropdown-item" href="<?= url('project/'.$name); ?>" title="Activate project <?=$name?> and show it's details"><?=$name?></a>
			</li>
		<?php endforeach; ?>
		</ul>
	</span>
</div>

<div class="container-fluid py-2 mb-2" style="background-color: #D9EDF7">
	<a href="<?= url('shell');?>" class="btn btn-success" title="Windows CmdShell">Shell</a>

	<a href="<?= url('compile');?>" class="btn btn-info" title="One-shot compilation of the active project">Compile</a>

<?php if (! $watching):?>
	<a href="<?= url('watch');?>" style="min-width: 5rem;" class="btn btn-primary" title="Start watching mode compilation of the active project">Watch</a>
<?php else:?>
	<a href="<?= url('stop');?>" style="min-width: 5rem;" class="btn btn-danger" onclick="watchStop()" title="Stop watching mode compilation of the active project">Stop</a>
<?php endif;?>

	<a href="<?= url('/'); ?>" class="btn btn-secondary" title="SCSS Compiler Help">Help</a>

<!--<span class="btn">Project:</span>-->
	<span class="dropdown">
		<button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" title="Select SCSS project">
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

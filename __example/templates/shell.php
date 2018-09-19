<div class="container-fluid">
	<div class="row">
		<!-- output card -->
		<div class="col-sm-8">
			<div class="card">
				<div class="card-block">
					<pre class="bg-black"><?= $output; ?></pre>
					<a href="<?= url('shell/clear');?>" class="btn btn-danger" title="Clear compiler output">Clear output</a>
				</div>
			</div>
		</div>

		<!-- command card -->
		<div class="col-sm-4">
			<div class="card">
				<div class="card-header"><strong>Shell Working Dir</strong></div>
				<div class="card-body">
				<form class="form d-flex justify-content-between mb-0" method="post" action="<?= url('shell/swd') ?>">
					<input type="text" class="form-control" title="<?=$swd?>" name="swd" value="<?=$swd?>">
					<button type="submit" class="btn btn-outline-success" title="Set this dir as Shell Working Dir">
					<!--<span class="arrow arrow-right" style="border-left-color:green;"></span>-->
					<!--<i class="fas fa-caret-right"></i>-->
						<i class="fas fa-chevron-right"></i>
					</button>
				</form>
			</div>
			</div>

			<div class="card">
				<div class="card-header"><strong>Execute shell command</strong></div>
				<div class="card-body">
				<form class="form d-flex justify-content-between mb-0" method="post" action="<?= url('shell/exec') ?>">
					<input type="text" class="form-control" title="<?=$cmd?>" name="cmd" value="<?=$cmd?>">
					<button type="submit" class="btn btn-outline-success" title="Execute this command in the Shell Working Dir">
						<i class="fas fa-bolt"></i>
					<!--<span class="arrow arrow-right" style="border-left-color:green;"></span>-->
					</button>
				</form>
			</div>
			</div>

			<!-- commands suite -->
			<div class="card">
				<div class="card-header">
					<strong>Shell commands suite</strong>
				</div>
				<div class="card-body">
					<ul class="list-group">
					<?php foreach ($groups as $group => $cmds): ?>
						<a data-toggle="collapse" data-target="#sub-<?=$group?>" onclick="clicked(this,'<?=$group?>');">
							
							<li class="list-group-item list-group-item-info d-flex justify-content-between">
								<span>
									<span class="arrow arrow-down"></span>&nbsp;
									<strong><?=$group?></strong>
								</span>
								<span class="badge badge-info"><?= sizeof($cmds) ?></span>
							</li>
						</a>

						<div class="collapse<?=$visible[$group] ? ' show' : ''?>" id="sub-<?=$group?>">
						<ul class="list-group">
						<?php foreach ($cmds as $name => $def): ?>
							<li class="d-flex justify-content-between">
								<span class="btn" title="<?= $def['desc'] ?>"><?= $def['cmd']; ?></span>
								<span>
									<a class="btn btn-outline-success" href="<?=url('shell/copy/'.$group.'/'.$name)?>" title="Copy this command to exec panel">
										<i class="fas fa-edit"></i>
									</a>
									<a class="btn btn-outline-success" href="<?=url('shell/cmd/'.$group.'/'.$name)?>" title="Execute this command in the Shell Working Dir">
										<i class="fas fa-bolt"></i>
									</a>
								</span>
							</li>
						<?php endforeach; ?>
						</ul>
						</div>
					<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

// Shell command groups accordion toggling clicks sinc with application
function clicked(elt, group) {
	// Check style.display for UL after clicked group LI elt
	const style = getComputedStyle(elt.nextElementSibling);
	const visible = style.display === 'none'	// true/false -> visible/hidden

	var url = document.URL + '/visi/' + group + '/' + visible;
console.log(group, elt.nextElementSibling.style.display, style.display, visible, url);

	// Ajax.get - Inform server on group collapse changing
	$.get(url);
//	ajaxGet(url, function(responseText){
//console.log('Ajax finished with response: ' + responseText);
//	});
}

// Only pure javascript!!!
// Make async ajax call with GET method
// compatible with IE7+, Firefox, Chrome, Opera, Safari
function ajaxGet(url, callback) {
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status != 200)
			alert('Ajax errror: ' + (this.status ? this.statusText : 'Unknown error'));
		return;
	}
	xhr.open('GET', url, true);
	xhr.send();

	// по окончании запроса доступны:
	// status, statusText
	// responseText, responseXML (при content-type: text/xml)
	// получить результат из this.responseText или this.responseXML
//	alert('Ajax completed' + xhr.responseText);
	callback(xhr.responseText);
}
</script>

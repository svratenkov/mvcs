<style type="text/css">
.col3_wrapper{
/*	font-family: Courier, monospace;*/
	border-left: 36px solid transparent;		/* $left-width */
	border-right: 42px solid transparent;		/* $right-width */
/*	clear:both;*/
}
.col3_center{
	float: left;
	width: 100%;
	margin-right: -100%;
}
.col3_left{
	float: left;
	width: 36px;								/* $left-width */
	margin-left: -36px;							/* $left-width */
/*	position: relative;*/
	
}
.col3_right{
	float: right;
	width: 42px;								/* $right-width */
	margin-right: -42px;						/* $right-width */
}
.swd-form {
}
.swd-label {}
.swd-input {
	width: 100%;
}
.swd-button {}
</style>

<div class="container-fluid">
	<div class="row">
		<!-- left dir??? panel -->
<!--	<div class="col-xs-2"></div>-->

		<!-- middle output panel -->
		<div class="col-xs-8">
			<pre style="color:white;background-color:black;margin-top:0.5em;">
				<?= $output; ?>
			</pre>
		</div>

		<!-- right command panel -->
		<div class="col-xs-4 bg-success">

			<!-- SWD -->
			<br/>
			<strong>Shell Working Dir</strong>
			<form class="swd-form" method="post" action="{{url('shell/swd')}}">
				<div class="col3_wrapper clearfix">
					<div class="col3_center">
						<div class="col3_content">
							<!--Здесь основной контент, грузится первым...-->
							<input type="text" class="swd-input" title="{{$swd}}" id="swd" name="swd" value="{{$swd}}">
						</div>
					</div>
					<div class="col3_left">
						<!--Здесь левая колонка (на бордюре)...-->
						<label class="swd-label">SWD:</label>
					</div>
					<div class="col3_right">
						<!--Здесь правая колонка (на бордюре)...-->
						<button type="submit" class="swd-button">Go!</button>
					</div>
				</div>
			</form>

			<!-- commands tree -->
			<br/>
			<strong>Shell commands</strong>
			<nav>
				<ul class="nav">
				@foreach ($groups as $group => $cmds)
					<li>
						<button class="list-group-item list-group-item-info" id="btn-{{$group}}" data-toggle="collapse"
								data-target="#sub-{{$group}}" aria-expanded="true">
							<strong>{{ $group }}</strong> <span class="caret"></span>
						</button>
					</li>
					<ul class="nav collapse in" id="sub-{{$group}}" role="menu" aria-labelledby="btn-{{$group}}" aria-expanded="true">
					@foreach ($cmds as $name => $def)
						<li><a class="list-group-item" href="{{url('shell/cmd/'.$group.'/'.$name)}}" title="{{$def['desc']}}">{{$def['cmd']}}</a></li>
					@endforeach
					</ul>
				@endforeach
				</ul>
			</nav>
		</div>
	</div>
</div>

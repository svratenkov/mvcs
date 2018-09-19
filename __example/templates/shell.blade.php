<div class="container-fluid">
	<!-- output panel -->
	<div class="row">
		<div class="col-xs-8">
		<!--@ snippet('blackboard')-->
			@include('blackboard')
		</div>

		<!-- command panel -->
		<div class="col-xs-4 panel-group">
			<!-- SWD -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Shell Working Dir</strong>
				</div>
				<div class="panel-body">
					<form class="form flex-between" method="post" action="{{url('shell/swd')}}">
						<input type="text" class="form-control" title="{{$swd}}" name="swd" value="{{$swd}}">
						<button type="submit" class="btn btn-default" style="float: right;" title="Set this dir as Shell Working Dir">
							<span class="arrow arrow-right" style="border-left-color:green;"></span>
						</button>
					</form>
				</div>
			</div>

			<!-- Current command -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Execute shell command</strong>
				</div>
				<div class="panel-body">
					<form class="form flex-between" method="post" action="{{url('shell/exec')}}">
						<input type="text" class="form-control" title="{{$cmd}}" name="cmd" value="{{$cmd}}">
						<button type="submit" class="btn btn-default" style="float: right;" title="Execute this command in the Shell Working Dir">
							<span class="arrow arrow-right" style="border-left-color:green;"></span>
						</button>
					</form>
				</div>
			</div>

			<!-- commands suite -->
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Shell commands suite</strong></div>
				<div class="panel-body">
					<nav>
						<ul class="nav">
						@foreach ($groups as $group => $cmds)
							<li>
								<button class="list-group-item list-group-item-info" data-toggle="collapse" data-target="#sub-{{$group}}">
									<span class="caret"></span>&nbsp;
									<strong>{{$group}}</strong>
									<span class="badge">{{sizeof($cmds)}}</span>
								</button>
							</li>
							<ul class="nav collapse in" id="sub-{{$group}}">
							@foreach ($cmds as $name => $def)
								<li>
								<span class="flex-between">
									<span class="form-control" title="{{$def['desc']}}">{{$def['cmd']}}</span>
									<a class="btn btn-default" href="{{url('shell/copy/'.$group.'/'.$name)}}" title="Copy this command to exec panel">
										<span class="glyphicon glyphicon-edit" style="color:green;"></span>
									</a>
								</span>
								</li>
							@endforeach
							</ul>
						@endforeach
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>

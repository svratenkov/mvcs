<div class="container-fluid">
<br/>

<?php if ($alert_no_projects) { ?>
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
<?php } ?>

	<div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title">ScssWeb - Scss Compiler & Watcher wtitten in PHP</h2>
			</div>
			<div class="panel-body">

				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">About ScssWeb</h3>
					</div>
					<div class="panel-body">
						<p>
							<b><code>ScssWeb</code></b> - SCSS compiler & watcher wtitten in PHP.<br/>
							<b><code>ScssWeb</code></b> is:
							<ul>
								<li>fast due to effective file caching</li>
								<li>light, yet powerful. It can do all things that applications like Scout, Koala, ... can</li>
								<li>fully configurable</li>
								<li>cross-platformed as it runs on your local web server</li>
								<li>written as simple and ascetic as possible to give you real possibility to modify it as you need</li>
							</ul>
						</p>
					</div>
				</div>

				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Installation</h3>
					</div>
					<div class="panel-body">
						<p>
							<b><code>ScssWeb</code></b> source can be found at <code>GitHub</code>: <a href="https://github.com/svratenkov/scssweb">https://github.com/svratenkov/scssweb</a>.
							Download <b><code>ScssWeb</code></b> source to any new directory in your localhost Document root.<br/>
						</p>
						<p>
							Technically speeking, <b><code>ScssWeb</code></b> is a GUI for the third-party SCSS compiler <a href="https://github.com/leafo/scssphp">leafo/scssphp</a> package.
							To resolve this dependency you need <code>Composer</code> installed on your computer.
							If you already have <code>Composer</code> installed, skip step 1.
						</p>

						<strong>Step 1: Install Composer</strong>

						<p>
							To install <code>Composer</code> please follow instructions on <a href="https://getcomposer.org/doc/00-intro.md">Composer Getting Started page</a>.
						</p>

						<strong>Step 2: Install ScssWeb</strong>

						<p>
							Having <code>Composer</code> installed run your shell console, go to <b><code>ScssWeb</code></b> directory and run this command:
							<pre>composer install</pre>
							<code>Composer</code> will download the newest version of <a href="https://github.com/leafo/scssphp">leafo/scssphp</a> package
							and create class autoloader for <b><code>ScssWeb</code></b> application.
						</p>

						<strong>Step 3: Run ScssWeb</strong>

						<p>
							You are ready to test <b><code>ScssWeb</code></b> application!
							<b><code>ScssWeb</code></b> supports both classic URL style with <code>index.php?query</code> or
							SEO-frendly style with query segments only.
						</p>
						<p>
							Go to your browser and enter URL to <b><code>ScssWeb</code></b>, for example:<br/>
							with <code>index.php?query</code>: <a href="http://localhost/path/to/scssweb/index.php">http://localhost/path/to/scssweb/index.php</a><br/>
							with <code>.htaccess</code> redirecting: <a href="http://localhost/path/to/scssweb/">http://localhost/path/to/scssweb/</a><br/>
							<br/>
							You will see <b><code>ScssWeb</code></b> home page.
						</p>
						<p>
							If you have any problems please ask any questions in the 
							<a href="https://github.com/svratenkov/scssweb/issues">ScssWeb issues page</a>.
						</p>
					</div>
				</div>

				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Overview</h3>
					</div>
					<div class="panel-body">
						<p>
							<b><code>ScssWeb</code></b> compiles source SCSS file and all it's imports into output SCS file.
							It makes this rationally - only those files are recompiled, which were changed since the last compilation.<br/>
						</p>
						<p>
							Any pair of source SCSS file and output SCS file is referred to as a <code>project</code>.
							All <code>projects</code> are defined in the <code>projects.php</code> config file.
							You may use <code>projects.example.php</code> as starting point for your <code>projects.php</code> config.
						</p>
						<p>
							By editing the <code>projects.php</code> config file you may alter or remove any existent <code>project</code>,
							or add new <code>project</code> to <b><code>ScssWeb</code></b>.
						</p>
						<p>
							Here is a list of <b><code>ScssWeb</code></b> functionality.
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Function & Button</th>
										<th>Function description</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Home</td>
										<td><b><code>ScssWeb</code></b> Help - this page</td>
									</tr>
									<tr>
										<td>Compile</td>
										<td>Compiles modified SCSS files of the active <code>project</code>, if any</td>
									</tr>
									<tr>
										<td>Clear</td>
										<td>Clears compiler output</td>
									</tr>
									<tr>
										<td>Watch</td>
										<td>Starts watching session which continuously recompiles any modified SCSS files of the active <code>project</code></td>
									</tr>
									<tr>
										<td>Stop</td>
										<td>Stops watching session</td>
									</tr>
									<tr>
										<td>Project buttons</td>
										<td>Activates selected <code>project</code> and shows it's details</td>
									</tr>
									<tr>
										<td>ClearCache</td>
										<td>Clears cache dir for the active <code>project</code></td>
									</tr>
								</tbody>
							</table>
						</p>
					</div>
				</div>

				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">License</h3>
					</div>
					<div class="panel-body">
						<p>
							<b><code>ScssWeb</code></b> is open-sourced software licensed under the <a href="http://opensource.org/licenses/MIT">MIT license</a>.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

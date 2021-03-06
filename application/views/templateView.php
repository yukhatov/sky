<html >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
	</head>
	<body>
		<div id="wrapper">
			<div id="container">
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<a class="navbar-brand" href="index.php?route=user/index">Main page</a>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

							<ul class="nav navbar-nav navbar-right">
								<li><a href="index.php?route=register/index">Register</a></li>
								<?php
									if (isset($data['is_logged_in'])) {
										echo '<li><a href="index.php?route=user/logout">Logout</a></li>';
									} else {
										echo '<li><a href="index.php?route=login/index">Login</a></li>';
									}
								?>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			</div>
		</div>
		<div class="container" id="wrapper">
			<div id="header">

			</div>
			<div id="page">
				<div id="content">
					<div class="box">
						<?php include 'application/views/'.$contentView; ?>
					</div>
					<br class="clearfix" />
				</div>
				<br class="clearfix" />
			</div>
		</div>
	</body>
</html>
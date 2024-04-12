<header class="header">
	<div class="header-inner">
		<img src="images/logo.png">
	</div>
	<div class="header-inner navs">
		<a href="index.php">
			<span class="nav-item">Home</span>
		</a>
		<a href="#">
			<span class="nav-item">Events</span>
		</a>
		<?php
			if (!isset($_SESSION['username'])){
				echo '
				<a href="registration.php">
					<span class="nav-item">Sign-Up</span>
				</a>
				<a href="login.php">
					<span class="nav-item">Login</span>
				</a>
				';
			} else {
				echo '
				<a href="#">
					<span class="nav-item">Profile</span>
				</a>
				<a href="logout.php">
					<span class="nav-item">Logout</span>
				</a>
				';
			}
		?>
	</div>
</header>

<hr class="under-header">
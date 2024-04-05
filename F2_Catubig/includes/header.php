<header>
	<div class="logo">
	    <img src="images/logo.png">
	</div>
	<div class="nav">
	    <span class="nav-item">
		<a href="registration.php">
		    Sign Up
		</a>
	    </span>
	    <span class="nav-item">
			<?php
				if (!isset($_SESSION['username'])){
					echo '
					<a href="login.php">
						Log In
					</a>
					';
				} else {
					echo '
					<a href="logout.php">
						Log Out
					</a>
					';
				}
			?>
	    </span>
	    <span class="nav-item">
		<a href="index.php">
		    Home
		</a>
	    </span>
	</div>
</header>
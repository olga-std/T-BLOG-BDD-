<header>
	<div class="logo">
		<a href="<?php echo BASE_URL . '/index.php' ?>" class="header_logo">
			<img src="assets/imgtblog/header_logo.png">
		</a>
	</div>
	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav">
		<li><a href="<?php echo BASE_URL . '/index.php' ?>"><i class="fas fa-home"></i></a></li>	
		<?php if (isset($_SESSION['id'])): ?> 
			<li>
				<a href="<?php echo BASE_URL . '/tblog_search.php?u_id=' . $_SESSION['id'] . '&name=' . $_SESSION['username']?>">Mio Blog</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?>
					<i class="fa fa-chevron-down" style="font-size: .8em;"></i>
				</a>
				<ul>
					<li>
						<?php if($_SESSION['admin']): ?>
							<a href="<?php echo BASE_URL . '/dashboard/access/admin.php' ?>">Impostazioni</a>
						<?php else: ?>
							<a href="<?php echo BASE_URL . '/dashboard/access/user.php' ?>">Impostazioni</a>
						<?php endif; ?>
					</li>
					<li><i><a href="<?php echo BASE_URL . '/tblog_logout.php' ?>" class="logout">Logout</a></i></li>
				</ul>
			</li>
		<?php else: ?>
			<li><a href="<?php echo BASE_URL . '/tblog_register.php' ?> ">Registrati</a></li>
			<li><a href="<?php echo BASE_URL . '/tblog_login.php' ?>">Login</a></li>
		<?php endif; ?>
	</ul>
</header>


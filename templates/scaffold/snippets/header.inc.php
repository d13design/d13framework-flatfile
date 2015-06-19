<html>
	<head>
		<?php html_meta(); ?>
		<?php html_css('styles.css'); ?>
	</head>
	<body>
		<header id="header">
			<h1>
				<a href="<?php echo SITE_URL; ?>" title="<?php echo SITE_NAME; ?> home"><?php echo SITE_NAME; ?></a>
			</h1>
			<nav>
				<?php menu(); ?>
			</nav>
		</header>
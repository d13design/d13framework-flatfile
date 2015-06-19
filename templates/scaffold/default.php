<?php require_once('snippets/header.inc.php'); ?>
	<section id="banner">
		<h3>Welcome to this website</h3>
		<p><?php echo SITE_DESCRIPTION; ?></p>
	</section>
	<section id="content">
		<?php echo $document['content']; ?>
	</section>
<?php require_once('snippets/footer.inc.php'); ?>
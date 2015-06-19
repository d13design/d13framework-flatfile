<?php require_once('snippets/header.inc.php'); ?>
	<section id="content">
		<header>
			<h2><?php echo $document['meta']['title']; ?></h2>
			<p><?php echo $document['meta']['description']; ?></p>
		</header>
		<hr>
		<?php echo $document['content']; ?>
	</section>
<?php require_once('snippets/footer.inc.php'); ?>
<?php require_once('snippets/header.inc.php'); ?>
	<section id="content">
		<header>
			<h2><?php echo $document['meta']['title']; ?></h2>
		</header>
		<hr>
		<?php echo $document['content']; ?>
		<hr>
		<?php list_children(); ?>
	</section>
<?php require_once('snippets/footer.inc.php'); ?>
<?php require_once('snippets/header.inc.php'); ?>

		<section id="banner">
			<div class="overlay">
				<h2><?php echo $document['meta']['headline']; ?></h2>
				<p><?php echo $document['meta']['tagline']; ?></p>
			</div>
		</section>

		<div class="container align-center">
			<?php echo $document['content']; ?>
		</div>
	
<?php require_once('snippets/footer.inc.php'); ?>
<div class="debug">
	<style>
		.debug{
			background:#e7e7f8;
			border-top:1px solid #000000;
			padding:5px;
		}
		.debug div{
			background:#f7eebe;
			padding:5px;
			margin:0px 0px 5px 0px;
			border:1px solid #ded4b1;
			font-family: 'Verdana', Verdana, Arial, Helvetica, sans-serif;
			font-size:11px;
		}
	</style>
	<div class="debug"><strong>$path</strong> &ldquo;<?php echo $path; ?>&rdquo;</div>
	<div class="debug"><strong>$_SERVER['REQUEST_URI']</strong> <?php echo $_SERVER['REQUEST_URI']; ?></div>
	<div class="debug"><strong>$route</strong> <?php print_r($route); ?></div>
	<div class="debug"><strong>$qs</strong> <?php print_r($qs); ?></div>
	<div class="debug"><strong>$file</strong> /content<?php echo $file; ?>.md</div>
	<div class="debug"><strong>$document['meta']</strong> <?php print_r($document['meta']); ?></div>
	<div class="debug"><strong>$document['content']</strong> <?php echo htmlspecialchars($document['content'],ENT_QUOTES); ?></div>
	<div class="debug"><strong>Time to generate page</strong> <?php
		$time=explode(" ",microtime());
		$time=$time[1]+$time[0];
		$endtime=$time;
		$totaltime=($endtime-$begintime);
		echo $totaltime;
		?> seconds
	</div>
</div>
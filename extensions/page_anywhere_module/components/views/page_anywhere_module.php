<?php

foreach ($placedPages as $page) {
	?>
	<div class="page-anywhere-module">
		<h3><?php echo $page['title']; ?></h3>
		<div class="page-anywhere-content">
			<?php echo $page['content']; ?>
		</div>
	</div>
<?php
} ?>
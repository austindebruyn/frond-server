<h1><?php echo $name; ?></h1>

<div id='file-list'>
	<p>
		There are some files waiting for you.
	</p>
	<ul>
	<?foreach ($filesList as $file) { ?>
	<li>
		<a href=<? echo '"'.$file->download_link.'"'; ?> ><? echo $file->name; ?></a>
		<span class='filesize'>(<? echo $file->filesize; ?>)</span>
	</li>
	<? } ?>
	</ul>
</div>
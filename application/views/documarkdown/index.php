<!DOCTYPE html>
<html>
	<head>
		<title>PHP DocuMarkdown</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/documarkdown.css" media="all, handheld" />
	</head>
	<body id="text">
		<header>
			<h1>PHP DocuMarkdown</h1>
		</header>
		<nav>
			<h2>Models</h2>
			<ol>
			<?php 
				foreach($controller_documentation_output->file_list as $cont_filename) {
					echo '<li><a href="#' . $cont_filename . '">' . $cont_filename . '</a></li>';
				}
			?>
			</ol>
			<h2>Controllers</h2>
			<ol>
			<?php 
				foreach($model_documentation_output->file_list as $model_filename) {
					echo '<li><a href="#' . str_replace('_','',$model_filename) . '">' . $model_filename . '</a></li>';
				}
			?>
			</ol>
		</nav>
		<section id="content">
			<h2>Models</h2>
			<hr />
			<?php 
				foreach($model_documentation_output->documentation as $model_doc) {
					echo $model_doc;
				}
			?>
			<h2>Controllers</h2>
			<hr />
			<?php 
				foreach($controller_documentation_output->documentation as $cont_doc) {
					echo $cont_doc;
				}
			?>
		</section>
		<footer>
			Alex McRoberts &copy; 2011
		</footer>
	</body>
</html>
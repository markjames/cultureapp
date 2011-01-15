<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]> <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:og="http://ogp.me/ns#" xmlns:egms="http://www.esd.org.uk/standards/egms/3.0/egms-schema#" xmlns:ipsv="http://www.esd.org.uk/standards/ipsv/2.00/ipsv-schema#" xmlns:dv="http://rdf.data-vocabulary.org/#" typeof="v:Event">
	<?php include dirname(__file__) . "/../includes/meta.php"; ?>
</head>
<body class="page-index template-index section-none environment-dev">

	<div id="container">

		<?php include dirname(__file__) . "/../includes/header.php"; ?>
		
		<div id="page-content" class="alt">

			<?php include dirname(__file__) . '/../includes/navigation.php' ?>

			<div id="primary-content" role="main">

				<div id="unit-postcode-search" title="Postcode Search" class="unit" role="region">

					<form method="post" name="culture-search">
						<div class="field field-first field-100">
							<label for="postcode">Postcode: </label><input type="text" name="postcode" id="postcode" class="text" />
						</div>
						<input type="submit" name="command" value="Search" class="button" />
					</form>
					
					<?php if(isset($results)): ?>
						<h2>Your Location Data</h2>
						<ul>
							<li>Postcode: <?php echo $results->postcode; ?></li>
							<li>Lat: <?php echo $results->loc['lat']; ?></li>
							<li>Long: <?php echo $results->loc['long']; ?></li>
						</ul>
					<?php endif; ?>

				</div><!-- /#unit-sample-content -->

			</div><!-- /#primary-content -->

			<div id="secondary-content" role="complementary">
				<div id="canvas"></div>
			</div><!-- /#secondary-content -->
		</div><!-- /#page-content -->

		<footer id="footer" role="contentinfo">
			<p><a href="http://twitter.com/markjames">@markjames</a> &amp; <a href="http://twitter.com/andrewlowther">@andrewlowther</a> at Culture Hack Day 2011 (<a href="http://twitter.com/culturehackday">@culturehackday</a>) &mdash; Code: <a href="https://github.com/markjames/cultureapp">githubcom/markjames/cultureapp</a></p>
		</footer><!-- /#footer -->

	</div><!-- /#container -->

	<?php include dirname(__file__) . '/../includes/footer.php'; ?>

</body>
</html>
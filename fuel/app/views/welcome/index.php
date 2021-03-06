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

			<?php include dirname(__file__) . "/../includes/tools.php"; ?>

			<div id="luvvie-alarm" width="940px"><span></span>
				<div id="bigtext" style="width: 940px">
				    <div></div>
				</div>
			</div>
			
			<div id="primary-content" class="" role="main">

				<div id="calculating" class="tk-bravia">Calculating&hellip;</div>

				<div id="unit-scores" class="unit" role="region">

					<h2 id="score">0</h2>

					<ol>
						<li class="genre category exhibit"><strong>Museums/Exhibits</strong> <span>0</span></li>
						<li class="genre category dance"><strong>Dance</strong> <span>0</span></li>
						<li class="genre category opera"><strong>Opera</strong> <span>0</span></li>
						<li class="genre category classical"><strong>Classical</strong> <span>0</span></li>
						<li class="genre category music"><strong>Music</strong> <span>0</span></li>
						<li class="genre category folk-and-world"><strong>Folk and world</strong> <span>0</span></li>
						<li class="genre category jazz-and-blues"><strong>Jazz and blues</strong> <span>0</span></li>
						<li class="genre category rock-and-pop"><strong>Rock and pop</strong> <span>0</span></li>
						<li class="genre category theatre"><strong>Theatre</strong> <span>0</span></li>
						<li class="genre category film"><strong>Film</strong> <span>0</span></li>
						<li class="genre category comedy"><strong>Comedy</strong> <span>0</span></li>
						<li class="genre category special-event"><strong>Special Events</strong> <span>0</span></li>
					</ol>

				</div><!-- /#unit-sample-content -->

			</div><!-- /#primary-content -->

			<div id="secondary-content" role="complementary">
				<div id="canvas"><canvas id="vis"></canvas></div>
			</div><!-- /#secondary-content -->
		</div><!-- /#page-content -->

		<footer id="footer" role="contentinfo">
			<p><a href="http://twitter.com/markjames">@markjames</a> &amp; <a href="http://twitter.com/andrewlowther">@andrewlowther</a> at Culture Hack Day 2011 (<a href="http://twitter.com/culturehackday">@culturehackday</a>) &mdash; Code: <a href="https://github.com/markjames/cultureapp">githubcom/markjames/cultureapp</a></p>
		</footer><!-- /#footer -->

	</div><!-- /#container -->

	<?php include dirname(__file__) . "/../includes/footer.php"; ?>

</body>
</html>
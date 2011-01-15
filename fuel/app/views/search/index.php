<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Culture Hack Day - Search</title>
	<style type="text/css">
		body { background-color: #F2F2F2; margin: 45px 0 0 0; font-family: ‘Palatino Linotype’, ‘Book Antiqua’, Palatino, serif; font-size: 18px }
		#wrapper { width: 740px; margin: 0 auto; }
		h1 { color: #333333; font: normal normal normal 62px/1em Impact, Charcoal, sans-serif; margin: 0 0 15px 0; }
		pre { padding: 15px; background-color: #FFF; border: 1px solid #CCC; font-size: 16px;}
		#footer p { font-size: 14px; text-align: right; }
		a { color: #000; }
	</style>
</head>
<body>
	<div id="wrapper">
		<h1>Culture App</h1>
		
		<div id="content">
			<form method="post" name="culture-search">
				<div class="field field-first field-100">
					<label for="postcode">Postcode: </label><input type="text" name="postcode" id="postcode" class="text" />
				</div>
				<input type="submit" name="command" value="Search" class="button" />
			</form>
		</div>
		<div id="footer">
			<p>
				Executed in {exec_time}s using {mem_usage}mb of memory.
			</p>
		</div>
	</div>
</body>
</html>
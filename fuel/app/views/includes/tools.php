<div id="group-tools" class="group">

	<section id="unit-postcode-search" class="unit">

		<form method="post" name="culture-search">
			<div class="field field-first field-100">
				<label for="postcode">Postcode: </label>
				<input type="text" name="postcode" id="postcode" class="text"<?php if(isset($_GET['search'])): ?> value="<?php echo htmlentities($_GET['search'], ENT_QUOTES, "UTF-8") ?>"<?php endif; ?>>
			</div>
			<button id="search-button">Go</button>
		</form>
		
	</section>

	<section id="unit-timeline" class="unit">

		<p>Enter a postcode (Birmingham only until we chase more data - try B1 3AP)<br>The app will how cultured your postcode is for different genres.</p>
	</section>

</div>
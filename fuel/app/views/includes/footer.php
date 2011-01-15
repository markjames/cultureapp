<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="assets/scripts/jquery.metadata.js"></script>
<script src="assets/scripts/jquery.address-1.3.1.min.js"></script>

<!-- Drawing -->
<script src="assets/scripts/raphael/raphael-min.js"></script>
<script src="assets/scripts/raphael/raphael-graphs.js"></script>

<!-- Graph layout -->
<!-- http://arborjs.org/ -->

<!-- Site scripts -->
<script src="assets/scripts/site/site.js"></script>

<!--[if lt IE 7 ]>
<script src="assets/scripts/dd_belatedpng.js?"></script>
<script>DD_belatedPNG.fix('');</script>
<![endif]-->

<script type="text/javascript">
	$(function(){
		$('#search-button').click(function(){
			$('#primary-content').addClass('calculating');
			$.post('/search', {
				"command": true,
				"postcode": $('#postcode').val()
			},
			function(response) {
				for(var i in response) {
					if($('li.' + i).length) {
						$('li.' + i).find('span').html(response[i]);
					}
				}
				
				$('#score').html(response.total);
				
				$('#primary-content').removeClass('calculating');
			}, "json");
			
			return false;
		});
	});
</script>
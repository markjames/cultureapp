<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="assets/scripts/jquery.metadata.js"></script>
<script src="assets/scripts/jquery.address-1.3.1.min.js"></script>

<!-- Drawing -->
<script src="assets/scripts/raphael/raphael-min.js"></script>
<script src="assets/scripts/raphael/raphael-graphs.js"></script>

<!-- Graph layout -->
<script src="assets/scripts/arbor/arbor.js"></script>
<script src="assets/scripts/arbor/arbor-tween.js"></script>
<script src="assets/scripts/arbor/arbor-graphics.js"></script>

<!-- Site scripts -->
<script src="assets/scripts/site/site.js"></script>
<script src="assets/scripts/site/Renderer.js"></script>

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
					if(i != 'venues_list' && $('li.' + i).length) {
						$('li.' + i).find('span').html(response[i]);
					}
				}
				
				$('#score').html(response.total);
				$('#primary-content').removeClass('calculating');
				
				var graft_objects = {
					nodes: {"CultureScore": {color: "red", shape: "dot", alpha: 1}}
				};
				
				var sys = arbor.ParticleSystem();
				sys.renderer = Renderer('#vis');
				
				var venue_objects = response.venues_list;
				for(var k in venue_objects) {
					sys.addNode(venue_objects[k].title);
				}
				
				sys.graft(graft_objects);
				
			}, "json");
			
			return false;
		});
	});
</script>
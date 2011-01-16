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
				
				var sys = arbor.ParticleSystem();
				sys.parameters({stiffness:900, repulsion:2000, gravity:true, dt:0.015})
				sys.renderer = Renderer('#vis');
				
				var venue_objects = response.venues_list;
				
				var old_node = sys.getNode('YOU');
				if(old_node) {
					sys.pruneNode(old_node);
				}
				sys.addNode('YOU', {color: "black", shape: "dot", alpha: 1, link: "/"});
				for(var k in venue_objects) {
					var venue_object = venue_objects[k];
					for(var j in venue_object) {
						var node_obj = sys.addNode(venue_object[j].title, {color: "#31B5C5", alpha: 1, link: '#'});
						sys.addEdge(node_obj, 'YOU', {length: j});
					}
				}
				
			}, "json");
			
			return false;
		});
	});
</script>
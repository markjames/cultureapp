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

<!-- Big text -->
<script src="assets/scripts/bigtext.js"></script>

<!-- Site scripts -->
<script src="assets/scripts/site/site.js"></script>
<script src="assets/scripts/site/Renderer.js"></script>

<!--[if lt IE 7 ]>
<script src="assets/scripts/dd_belatedpng.js?"></script>
<script>DD_belatedPNG.fix('');</script>
<![endif]-->

<script type="text/javascript">
	$(function(){
		
		// $('#luvvie-alarm').bigtext();
		
		window.onpopstate = function(event) {
			if( event.state && event.state.postcode ) {
				$('#postcode').val( event.state.postcode );
				getPostcodeSearch();
			}
		}
		
		function getPostcodeSearch() {
			$('#primary-content').addClass('calculating');
			
			var pcode = $('#postcode').val();
			<?php if(isset($_GET['search'])): ?>
			if(pcode == '') {
				pcode = '<?php echo htmlentities($_GET['search'], ENT_QUOTES, "UTF-8"); ?>';
			}
			<?php endif; ?>
			
			// Change Browser URL
			if( window.history && window.history.pushState ) {
				window.history.pushState({postcode: pcode}, "CultureScore: " + pcode, "/?search=" + pcode);
			}
			
			$.post('/search', {
				"command": true,
				"postcode": pcode
			},
			function(response) {
				for(var i in response) {
					if(i != 'venues_list' && $('li.' + i).length) {
						$('li.' + i).find('span').html(response[i]);
					}
				}
				
				$('#luvvie-alarm').children('p').html(response.luvvie_name);
				
				// Drop in a tweet link
				var twittermsg = 'My Culture Score is ' +response.total+ '! http://cultureapp.dyndns.org/ %23chd11';
				$('#tweetlink').attr('href','http://twitter.com/home?status='+twittermsg);
				$('#tweetlink').text(twittermsg).parent().fadeIn();
				
				var mylist = $('#unit-scores ol');
				var listitems = mylist.children('li').get();
				listitems.sort(function(a, b) {
					var compA = 1 * $(a).find('span:first').text().toUpperCase();
					var compB = 1 * $(b).find('span:first').text().toUpperCase();
					return (compB < compA) ? -1 : (compA > compB) ? 1 : 0;
				})
				$.each(listitems, function(idx, itm) { mylist.append(itm); });
				
				$('#score').html(response.total);
				$('#primary-content').removeClass('calculating');
				
				var sys = arbor.ParticleSystem();
				sys.parameters({stiffness:900, repulsion:2000, gravity:true, dt:0.015})
				sys.renderer = Renderer('#vis');
				
				var venue_objects = response.venues_list;

				var old_node = sys.getNode('YOU');

				var genre_colours = {"default": "#b2b19d", "exhibit": "#AF2E7D","dance": "#D11418","opera": "#DE007D","classical": "#E05D00","music": "#244BD4","folk-and-world": "#1689AF","jazz-and-blues": "#316EAF","rock-and-pop": "#0057C6","theatre": "#9700F0","film": "#57837D","comedy": "#EAB300","special-event": "#004902"};
				var old_node = sys.getNode('YOU');

				if(old_node) {
					sys.pruneNode(old_node);
				}
				sys.addNode('YOU', {color: "black", shape: "dot", alpha: 1, link: "/"});
				for(var k in venue_objects) {
					var venue_object = venue_objects[k];
					for(var j in venue_object) {
						
 						var active_genre = "default";
						var top_genre_score = 0;
						if(typeof venue_object[j].genre != 'undefined') {
							var genres = venue_object[j].genre;
							for(var l in genres) {
								if( top_genre_score < genres[l] ) {
									top_genre_score = genres[l];
									active_genre = l;
								}
							}
						}
						
						var node_obj = sys.addNode(venue_object[j].title, {color: genre_colours[active_genre], alpha: 1, link: '#'});
						sys.addEdge(node_obj, 'YOU', {length: j});

					}
				}
				
			}, "json");
			
			return false;
		}
		
		$('#search-button').bind('click', getPostcodeSearch);
		
		<?php if(isset($_GET['search'])): ?>
		$('#search-button').trigger('click');
		<?php endif; ?>
	});
</script>
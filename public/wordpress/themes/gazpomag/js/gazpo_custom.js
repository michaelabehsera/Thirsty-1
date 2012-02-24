jQuery(document).ready(function($){	
	$('ul.tabs').each(function() {
		$(this).find('li').each(function(i) {
			$(this).click(function(){
				$(this).addClass('current').siblings().removeClass('current')
					.parents('div.widget_posts').find('div.post_box').hide().end().find('div.post_box:eq('+i+')').fadeIn(150);
			});
		});
	});	
	
	
});

jQuery(document).ready(function($){
$("#featured").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
		$("#featured").hover(
			function() {
				$("#featured").tabs("rotate",0,true);
			},
			function() {
				$("#featured").tabs("rotate",5000,true);
			}
		);
});

/* digg button */
(function() {
		var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
		s.type = 'text/javascript';
		s.async = true;
		s.src = 'http://widgets.digg.com/buttons.js';
		s1.parentNode.insertBefore(s, s1);
		})();
		
/* google+ */	
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
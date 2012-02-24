/* <![CDATA[ */
jQuery(document).ready(function(){
	jQuery('ul.commentlist .comment, ul.commentlist .pingback, ul.commentlist .trackback, #respond').after('<div class="comment-body-bottom"></div>');
	jQuery('#respond').before('<div class="commentform-body-top"></div>');
	jQuery('.topmenu ul li:first-child ul.sub-menu, .topmenu ul li:first-child ul.children').append('<div class="sub-menu-bottom"></div>');
	//FancyBox Integration
	jQuery('#single_posts .post_mid .post_content_main a').has('img').addClass('hasimg');
	jQuery("a.hasimg").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	400, 
		'speedOut'		:	200, 
		'overlayShow'	:	true
	});
		
		//Sidebar Widgets list Animation	
		jQuery('#sidebar .widgets ul li ul li ').hover(function(){
			jQuery(this).stop().animate({"marginLeft":"10px"},150);
		}, function() {
			jQuery(this).stop().animate({"marginLeft":"0px"},150);
		});
		
		//Do Not Animate The widgets(Popular, Random, Featured)
		jQuery('#sidebar .widgets ul .widget-popular-posts ul li, #sidebar .widgets ul .widget-random-posts ul li').hover(function(){
			jQuery(this).stop().animate({"marginLeft":"0px"},150);
		}, function() {
			jQuery(this).stop().animate({"marginLeft":"0px"},150);
		});
		
		//MENU ANIMATION
		jQuery('#topmenu ul >li').css({"paddingLeft":"9px"});
		 jQuery('#topmenu ul >li').not('ul li').css({"paddingLeft":"9px", "paddingBottom":"4px"});
		 jQuery('#topmenu ul li .tier_fix li').css({"paddingBottom":"0px"});
		 jQuery('#topmenu ul > li > ul:parent').css({"opacity":"0","marginTop":"20px", "paddingTop":"20px", "display":"none"});
		 jQuery('#topmenu ul > li > ul > li > ul').css({"marginTop":"0px", "paddingTop":"0px"});
		 jQuery('#topmenu ul >li > ul li ul').css ({"marginTop":"0px"});
		 jQuery('#topmenu ul >li > ul').find(">:first-child").css({"marginTop":"4px"});
		 jQuery('#topmenu ul >li > ul').addClass('ul_hover');
		 jQuery('#topmenu ul >li > ul').append('<div class="submenu_bottom" />');
	 
		jQuery('#topmenu ul li').hoverIntent(function(){
		jQuery(this).find('ul.ul_hover').show().animate({"opacity":"1","marginTop":"0px"})
		}, function(){
		jQuery(this).find('ul.ul_hover').animate({"opacity":"0","marginTop":"20px"}).hide(200);
		});
		
		jQuery('#topmenu ul> li').hover(function(){
		jQuery(this).addClass('hover');
		}, function(){
		jQuery(this).removeClass('hover');
	});
	
	//SOCIAL SHARE LINKS ANIMATION
		jQuery('.fb_hover, .twitt_hover, .stumble_hover, .delicious_hover, .gbuzz_hover').hover(function(){
		jQuery(this).stop().animate({"opacity":"0"},400);
	}, function(){
		jQuery(this).stop().animate({"opacity":"1"},400);
		});
	
	
	//OPTIONS PAGE
	jQuery('.amp_section:eq(0)').attr('id', 'tab-1');
	jQuery('.amp_section:eq(1)').attr('id', 'tab-2');
	jQuery('.amp_section:eq(2)').attr('id', 'tab-3');
	jQuery('.amp_section:eq(3)').attr('id', 'tab-4');	
	jQuery('.amp_section:eq(4)').attr('id', 'tab-5');
	jQuery('.amp_section:eq(5)').attr('id', 'tab-6');
	jQuery('.amp_section:eq(6)').attr('id', 'tab-7');
	jQuery('.amp_section:eq(7)').attr('id', 'tab-8');
	jQuery('.amp_section:eq(8)').attr('id', 'tab-9');
	jQuery('.upgrade-table tr').find('td:eq(0)').addClass('tdo');
	
	jQuery('.sub-menu').has('.submenu_bottom').addClass('tier_fix');
			
	jQuery(document).ready(function(){
	jQuery('#tabs .amp_section').hide();
	jQuery('#tabs .amp_section:first').show();
	jQuery('#tabs ul li:first').addClass('active');
	jQuery('#tabs ul li a').click(function(){ 
	jQuery('#tabs ul li').removeClass('active');
	jQuery(this).parent().addClass('active'); 
	var currentTab = jQuery(this).attr('href'); 
	jQuery('#tabs .amp_section').hide();
	jQuery(currentTab).fadeIn();
	return false;
	});
	});
});
/* ]]> */
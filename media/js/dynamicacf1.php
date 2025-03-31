window._site.forumUser = "";
$(document).ready( function () {
	window._site.comments( $('div.content div.comments'), [] );
} );window._site.page = "examples\/index.html";

$(document).ready( function () {
	window._site.dynamicLoaded();
} );

window._site.csrfToken = 'd1da56e2d0871fb5d1427b02514023bb3fd6a723175d1682';


function dtAds() {
	var loaded = false;
	var headerAd = true;

	if (window.ethicalads) {
		ethicalads.wait.then(function (placements) {
			if (headerAd) {
				$('div.fw-header').addClass('ad');
			}

			if (! placements.length) {
				$('div.ad').html('<div class="ad-backup"><a href="/purchase">Please consider supporting DataTables by joining us as a supporter or white listing this site in your ad-blocker.</a></div>');
			}
		});
	}
	else {
		$('div.ad').html('<div class="ad-backup"><a href="/purchase">Please consider supporting DataTables by joining us as a supporter or white listing this site in your ad-blocker.</a></div>');
	}

	var run = function () {
		if (! loaded && $(window).width() >= 860) {
			if (window.ethicalads) {
				ethicalads.load();
				loaded = true;
			}
		}
	}

	if ($('div.page-nav').length && $('div.page-nav').is(':visible')) {
		$('div.nav-ad').children()
			.attr('id', 'ad-fixed-nav')
			.prependTo('div.page-nav');
		headerAd = false;
	}
	else if ($('div.fw-sidebar').length) {
		$('div.nav-ad').children()
			.attr('id', 'ad-forum-nav')
			.prependTo('div.fw-sidebar div.sidebar');
		headerAd = false;
		return; // disable
	}
	else {
		$('div.nav-ad').children()
			.attr('id', 'ad-header');
	}

	$(window).on('resize', function (){
		run();
	});

	// Will run immediately if already loaded
	$(document).ready(function() {
		run();
	});
}



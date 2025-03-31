window._site.forumUser = "";
$(document).ready( function () {
	window._site.comments( $('div.content div.comments'), [{"id":"3396","username":"tvandame","comment":"<p>If your looking to add DataTables to your Electron application just do the following.<\/p>\n\n<p>1) In your renderer.js file in the root of your project add the following.<\/p>\n\n<pre><code class=\"multiline language-js\">\/\/ This file is required by the index.html file and will\n\/\/ be executed in the renderer process for that window.\n\/\/ All of the Node.js APIs are available in this process.\nwindow.$ = window.jquery = require('.\/node_modules\/jquery');\nwindow.dt = require('.\/node_modules\/datatables.net')();\nwindow.$('#table_id').DataTable();\n<\/code><\/pre>\n\n<p>2) In your index.html file in the root of your project add the following.<\/p>\n\n<pre><code class=\"multiline language-html\">    &lt;table id=\"table_id\" class=\"display\"&gt;\n        &lt;thead&gt;\n            &lt;tr&gt;\n                &lt;th&gt;Column 1&lt;\/th&gt;\n                &lt;th&gt;Column 2&lt;\/th&gt;\n            &lt;\/tr&gt;\n        &lt;\/thead&gt;\n        &lt;tbody&gt;\n            &lt;tr&gt;\n                &lt;td&gt;Row 1 Data 1&lt;\/td&gt;\n                &lt;td&gt;Row 1 Data 2&lt;\/td&gt;\n            &lt;\/tr&gt;\n            &lt;tr&gt;\n                &lt;td&gt;Row 2 Data 1&lt;\/td&gt;\n                &lt;td&gt;Row 2 Data 2&lt;\/td&gt;\n            &lt;\/tr&gt;\n        &lt;\/tbody&gt;\n    &lt;\/table&gt; \n<\/code><\/pre>\n","created":"12:44, Mon 28th May 2018","parent":null,"version":"1.10.16","children":[]}] );
} );window._site.page = "manual\/installation";

$(document).ready( function () {
	window._site.dynamicLoaded();
} );

window._site.csrfToken = 'ce199f917bcd80cfaf3e97eaeec01fba8002049454b13de9';


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



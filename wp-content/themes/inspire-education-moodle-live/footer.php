	<section id="footer-wrap" class="clearfix wrapper">
		<footer role="contentinfo" class="footer container clearfix">
			<div id="foot-contact" class="vcard clearfix">
				<div class="org"><strong>Inspire Education Pty Ltd</strong></div>
				<a class="email" href="mailto:enquiries@inspireeducation.net.au">enquiries@inspireeducation.net.au</a>
				<div class="adr">
					<div class="street-address">Level 19, 288 Edward Street</div>
					<span class="locality">Brisbane</span>, <span class="region">Queensland</span>, <span class="postal-code">4000</span> <span class="country-name">Australia</span> </div>
					<div class="tel">1800 506 509</div>
					<div class="tel">+61 7 3036 0726 (For overseas callers)</div>
					<div class="postal">Postal Address:  GPO Box 1180, Brisbane, QLD 4001</div>
				</div>
				<div id="foot-nav">
					<ul>
						<li><a class="home" href="https://www.inspireeducation.net.au/">Home</a> </li>
						<li><a class="courses" href="/?page_id=41">Courses</a></li>
						<li><a title="shop" href="/shop">Enrol/Shop</a></li>
						<li class="page_item page-item-2"><a title="About Us" href="/about-us/">About Us</a></li>
						<li class="page_item page-item-4"><a title="News" href="https://www.inspireeducation.net.au/blog">News</a></li>
						<li class="page_item page-item-5"><a title="FAQ" href="/faq/">FAQ</a></li>
						<li class="page_item page-item-7"><a title="Career Search" href="/search/">Career Search</a></li>
						<li class="page_item page-item-9"><a title="Blog" href="/blog/">Blog</a></li>
						<li class=""><a title="links" href="https://www.inspireeducation.net.au/courses">Links</a></li>
					</ul>
					<p>
						<strong>Inspire Education Pty Ltd</strong> &copy; 2009 All Rights reserved | <a href="<?php echo home_url(); ?>/?page_id=191" title="privacy policy">Privacy Policy</a><br />
						<strong>ACN:</strong> 134 907 289 <strong>ABN:</strong> 78 134 907 289 <strong>RTO ID:</strong> 32067
					</p>
					<a class="q400-tab" target="_blank" title="Queensland 400" rel="nofollow">Queensland 400</a>&nbsp;&nbsp;&nbsp; <a class="velg-tab" href="http://www.velgtraining.com/" target="_blank" title="Velg" rel="nofollow">Velg</a>
				</div>
			</div>
		</footer>
	</section>
	<div id="response">
		<h2>Whoops!!</h2>
		<h4>Could you please amend the form? We&#8217;ve highlighted the problem(s) for you...</h4>
	<div>
</div>

	<?php
		$yes_please_pages = array('page-course-sub-button-left-new-autoform-short.php','page-course-sub-button-left-new-autoform-short-DipWHS.php','page-course-sub-button-left-new-autoform-short-TESOL.php','page-course-sub-button-left-new-autoform-short-HR.php','page-course-sub-button-left-new-autoform-short-EdSupport.php','page-course-sub-button-left-new-autoform-short-Disability.php','page-course-sub-button-left-new-autoform-short-DipVET.php','page-course-sub-button-left-new-autoform-short-DipTDD.php','page-course-sub-button-left-new-autoform-short-DipPGM.php','page-course-sub-button-left-new-autoform-short-DipECE.php','page-course-sub-button-left-new-autoform-short-DipAccounting.php','page-course-sub-button-left-new-autoform-short-CertIVPGM.php','page-course-sub-button-left-new-autoform-short-BusinessAdmin.php','page-course-sub-button-left-new-autoform-short-Bookkeeping.php','page-course-sub-button-left-new-autoform-short-Ageing.php','newlandingpage.php','newlandingpage-1.php','newlandingpage-2.php','newlandingpage-3.php','page-course-sub-button-left-new-autoform-short-Accounting.php','page-course-sub-button-left-new-autoform-short-HomeCare.php', 'page-course-sub-button-left-new-autoform-short-CertIVWHS.php', 'page-course-sub-button-left-new-autoform-short-CertIIIECE - Copy.php', 'page-course-sub-button-left-new-autoform-short-CertIIIECE - Copy 2.php', 'page-course-sub-button-left-new-autoform-short-Cert3Guarantee.php');

		wp_reset_query();
		wp_footer();
	?>

  <script type="text/javascript">
    $( window ).on('load', function() {
      var $radios = $('input:radio[name=payment_method]');
      $radios.filter('[value=paypal_pro_payflow]').prop('checked', true);
    })
  </script>

	<script type="text/javascript">
		document.write(unescape("%3Cscript src='" + document.location.protocol + "//munchkin.marketo.net/munchkin.js' type='text/javascript'%3E%3C/script%3E"));
		if (typeof Munchkin != "undefined") { Munchkin.init('136-WWT-341'); }
	</script>

	<script type="text/javascript" src="https://d31qbv1cthcecs.cloudfront.net/atrk.js"></script>
	<script type="text/javascript">_atrk_opts = { atrk_acct: "2mQzf1agkf00wk", domain:"inspireeducation.net.au"}; atrk ();</script>
	<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=2mQzf1agkf00wk" style="display:none" height="1" width="1" alt="" /></noscript>

	<?php if (is_page_template($yes_please_pages)) { ?>
			<script type="text/javascript" language="javascript">
				function clickme(){
					if(document.getElementById("yesplease")!=null||document.getElementById("yesplease")!=""){
						document.getElementById("yesplease").click();
					}
				}
				window.onload=function() { setTimeout(clickme, 3000); };
			</script>
	<?php } ?>

	<?php if ( is_page_template('page-thankyou.php') ) { ?>
		<script type="text/javascript"> if (!window.mstag) mstag = {loadTag : function(){},time : (new Date()).getTime()};</script> <script id="mstag_tops" type="text/javascript" src="//flex.msn.com/mstag/site/1cde42f8-5b0e-45da-9a1d-d30d7874d61e/mstag.js"></script> <script type="text/javascript"> mstag.loadTag("analytics", {dedup:"1",domainId:"3073624",type:"1",revenue:"",actionid:"265056"})</script> <noscript> <iframe src="//flex.msn.com/mstag/tag/1cde42f8-5b0e-45da-9a1d-d30d7874d61e/analytics.html?dedup=1&domainId=3073624&type=1&revenue=&actionid=265056" frameborder="0" scrolling="no" width="1" height="1" style="visibility:hidden;display:none"> </iframe> </noscript>
	<?php } ?>
    <?php include('analytics-scripts.php') ?>
</body>

</html>

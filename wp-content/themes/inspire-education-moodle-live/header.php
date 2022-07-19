<!DOCTYPE html>
<html lang="en-AU" class="no-js">
<head>
<link href='https://ajax.googleapis.com' rel='preconnect'>
<link href='https://d31qbv1cthcecs.cloudfront.net' rel='preconnect'>
<link href='https://amplify.outbrain.com' rel='preconnect'>
<link href='https://connect.facebook.net' rel='preconnect'>
<link rel="icon" href="/icons/inspire.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
<link rel="apple-touch-icon-precomposed" href="/icons/apple-touch-icon-precomposed.png">
<link rel="apple-touch-icon " sizes="72x72" href="/icons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon " sizes="114x114" href="/icons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon " sizes="144x144" href="/icons/apple-touch-icon-144x144.png">
<link rel="shortcut icon" href="/icons/inspire.ico" type="image/x-icon">
<link rel="author" href="https://plus.google.com/u/0/114900496384675158622" />
<link href="https://plus.google.com/u/0/+inspireeducation" rel="publisher"/>
<meta charset="utf-8">

<?php if ( is_front_page()) { ?>
	<title>
		<?php bloginfo('name'); ?>
	</title>
<?php } else { ?>
	<title>
		<?php wp_title(); ?>
	</title>
<?php } ?>

<meta name="author" content="Inspire Education">
<meta name="HandheldFriendly" content="True">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">

<?php
if ( is_page_template('page-thankyou.php') ) { ?>
<script language="JavaScript" type="text/javascript">
<!-- Yahoo! Search Marketing Australia & NZ -->
window.ysm_customData = new Object();
window.ysm_customData.conversion = "transId=,currency=,amount=";
var ysm_accountid  = "1DRVQME8A9NG69HC2QQG7FLISQK";
document.write("<SCR "IPT language='JavaScript' type='text/javascript' "
+ "SRC=// "srv1.wa.marketingsolutions.yahoo.com "/script/ScriptServlet "?aid= ysm_accountid
+ "></SCR "IPT>");
// -->

</script>
<?php }
 ?>

<!-- PingBacks -->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php // Canonical URL's
	global $post;
	$postid = get_the_ID();
	$url = get_post_meta($postid, 'canonical-url', true);
	if ($url) {
		echo "<link rel='canonical' href='$url' />";
	}
?>

<?php include('analytics-no-script.php') ?>

<?php
wp_head();

if (is_page_template( 'page-thankyou.php' )) { ?>

  <!-- Twitter Tracking code -->
  <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
  <script type="text/javascript">
  twttr.conversion.trackPid('l56ae');</script>
  <noscript>
  <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l56ae&p_id=Twitter" />
  <img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=l56ae&p_id=Twitter" /></noscript>

<?php }
  $anatop = get_post_meta($postid, 'analytics-top', true);
	if ($anatop) { echo $anatop; }
?>

<script data-obct type="text/javascript">
  /** DO NOT MODIFY THIS CODE**/
  !function(_window, _document) {
    var OB_ADV_ID='0074c8d6dabfce52e4e9c33264fab413d4';
    if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;}
    var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = _document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document);
obApi('track', 'PAGE_VIEW');
</script>

</head>
<body <?php body_class(); ?>>

<a class="hidden" href="#content" title="skip to content">Skip to Content</a>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=205378971932";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php
  if (is_product()) {
    $schem = 'itemscope itemtype="http://schema.org/Product"';
  } else {
    $schem = null;
  }
?>

<div id="container">
    <div class="clearfix" id="head-wrap">

    <div class='custom-header-container'>
      <div class='custom-header '>
        <div id="contact-links">
					<a href='tel:1800506509'><span class='fas fa-phone-alt blue100'></span> <span class='fw-900'>1800 506 509</span></a><a href='mailto:enquiries@inspireeducation.net.au'><span class='fas fa-envelope blue100'></span><span class='fw-300'>enquiries@inspireeducation.net.au</span></a>
        	<a href='#' id='marketoinspireform'><span class='fw-900'>CONTACT US TODAY!</span></a>
				</div>

				<div id="login-area">
					<a href="http://inspireeducation.edu.au/learning/" target="_blank" title="student login" rel="nofollow">Student Login Area</a>
				</div>
      </div>
    </div>

		<div id="header-mobile" lass="wrapper clearfix">
			<a href="https://www.inspireeducation.net.au" class='logo'> <img width="" height="" alt="Inspire Education Pty Ltd" class=" lazyloaded" src="https://www.inspireeducation.net.au/assets/uploads/2020/12/insipre-logo.svg"></a>
			<a href="tel:1800506509"><span class="fas fa-phone-alt blue100"></span> <span class="fw-900">1800 506 509</span></a>
			<a href="mailto:enquiries@inspireeducation.net.au"><span class="fas fa-envelope blue100"></span><span class="fw-300">enquiries@inspireeducation.net.au</span></a>
			<a href="<?php echo get_site_url();?>/shop">Enrol Now/Shop</a>
			<a href="<?php echo get_site_url();?>/cart" target="_blank">Cart(<?php echo WC()->cart->get_cart_contents_count() ?>)</a>
		</div>

      <div id="header" role="banner" class="wrapper clearfix">

      	<header id="head-inner" class="container">

              <a id="brand"   itemprop="brand" itemscope itemtype="http://schema.org/Brand"  href="<?php echo home_url(); ?>/" title="<?php bloginfo('name'); ?>">
              	<?php bloginfo('name'); ?>
              </a>


            <nav class="clearfix" id="main-nav">
              <ul id="nav" class="clearfix">
                <!-- Edited for Redirects -->
                <li><a href="<?php echo "https://www.inspireeducation.net.au"; ?>/" title="<?php bloginfo('name'); ?>">home</a></li>
                <li id="link-course"
                <?php
                  $post = is_singular() ? get_queried_object() : false;
                  if ( ! empty($post) && is_a($post, 'WP_Post') ) {
                    if ('41' == $post->post_parent) { ?>
                      class="current_page_item"<?php
                    }
                  }
                  if (is_page('41') || is_course('41')) { ?>
                    class="current_page_item"<?php
                  }  ?> >
                <a href="https://www.inspireeducation.net.au/courses/" title="courses">courses</a>


                <?php wp_nav_menu_no_ul(); ?>
              </ul>
            </nav>

        </header>

      </div>
      <?php if (is_home()) {?>
      <section id="call-to-action" class="container">
        <div id="welcome-note" class="span-16">
          <h3>Welcome to Inspire Education&#8230;</h3>
          <?php query_posts('p=87'); ?>
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <h1>
            <?php the_title(); ?>
          </h1>
          <strong>
          <?php the_content(); ?>
          </strong>
          <?php endwhile; endif; wp_reset_query();  ?>
          <a class="q400-tab" target="_blank" title="Queensland 400">Queensland 400</a> <a class="velg-tab" href="http://www.velgtraining.com/" target="_blank" title="Velg" rel="nofollow">Velg</a> </div>
        <div id="home-social">
          <!-- Place this tag where you want the +1 button to render -->
          <div class="g-plusone" data-href="http://inspireeducation.net.au"></div>
          <iframe id="fb-head" src="http://www.facebook.com/plugins/like.php?app_id=114195062012320&amp;href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FInspire-Education%2F336613458093&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
        </div>
      </section>
      <section class="clearfix wrapper" id="course-list">
        <div class="section sec-highlight clearfix container">
          <h2><span>Choose from A Range of Nationally Recognised Certificate and Diploma Courses</span></h2>
          <?php print_coursecats(41); ?>

        </div>
      </section>
      <?php }?>
    </div>

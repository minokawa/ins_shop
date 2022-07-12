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

<div <?php // echo $schem; ?> id="container">
    <div class="clearfix" id="head-wrap">

    <div class='custom-header-container just-center ff-museo w-100p white'>
      <div class='custom-header flex '>
        <div><a href='tel:1800506509'><span class='fas fa-phone-alt blue100'></span> <span class='fw-900'>1800 506 509</span></a></div>
        <div><a href='mailto:enquiries@inspireeducation.net.au'><span class='fas fa-envelope blue100'></span><span class='fw-300'>enquiries@inspireeducation.net.au</span></a>
        </div>
        <div><a href='#' id='marketoinspireform'><span class='fw-900'>CONTACT US TODAY!</span></a></div>
      </div>
    </div>

      <div id="header" role="banner" class="wrapper clearfix">
      	<header id="head-inner" class="container">
            <div itemprop="brand" itemscope itemtype="http://schema.org/Brand" id="brand">
              <!--[if (gt IE 9)|!(IE)]><!-->
              <a href="<?php echo home_url(); ?>/" title="<?php bloginfo('name'); ?>">
              <?php bloginfo('name'); ?>
              </a>
              <!--<![endif]-->
            </div>
            <p class="telephone">Call: 1800 506 509</p>
            <nav class="clearfix" id="main-nav">
              <ul id="nav" class="clearfix">
                <!-- Edited for Redirects -->
                <li><a href="<?php /*echo home_url();*/ echo "https://www.inspireeducation.net.au"; ?>/" title="<?php bloginfo('name'); ?>">home</a></li>
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

                  <div class="sub" style="opacity: 0; display: none; width: 3080px;">
                       <div id="equalize">
                          <div class="wrap-nav-courses" style="clear: left;">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/aged-care-disability-courses/" style="line-height: 120%;">Aged Care Courses and Disability Care Courses</a></h3>
                                <ul>
                                   <li class="page_item page-item-65140"><a href="https://www.inspireeducation.net.au/courses/aged-care-disability-courses/certificate-iii-in-individual-support-ageing-course/">Certificate III in Individual Support (Ageing)</a></li>
                                   <li class="page_item page-item-68193"><a href="https://www.inspireeducation.net.au/courses/aged-care-disability-courses/certificate-iii-in-individual-support-disability-course/">Certificate III in Individual Support (Disability)</a></li>
                                   <li class="page_item page-item-68203"><a href="https://www.inspireeducation.net.au/courses/aged-care-disability-courses/certificate-iii-in-individual-support-home-care/">Certificate III in Individual Support (Home and Community)</a></li>
                                   <li class="page_item page-item-97068"><a href="https://www.inspireeducation.net.au/courses/aged-care-disability-courses/certificate-iv-ageing-support/">Certificate IV in Ageing Support</a></li>
                                   <li class="page_item page-item-134861"><a href="https://www.inspireeducation.net.au/courses/aged-care-disability-courses/certificate-iv-disability/">Certificate IV in Disability</a></li>
                                   <p>
                                <h3><a href="https://www.inspireeducation.net.au/courses/community-care-courses-and-health-administration/" style="line-height: 120%;">Community Care Courses and Health Administration</a></h3>
									<li class="page_item page-item-136914"><a href="https://www.inspireeducation.net.au/courses/community-care-courses-and-health-administration/certificate-iv-health-administration/">Certificate IV in Health Administration</a></li>
                                   <li class="page_item page-item-81272"><a href="https://www.inspireeducation.net.au/courses/aged-care-community-services-courses/diploma-community-services-case-management/">Diploma of Community Services</a></li>
                                    <li><a href="https://www.inspireeducation.net.au/courses/community-care-courses-and-health-administration/covid-19-infection-control-training/">COVID-19 Infection Control Training</a></li>
                                </ul>
                             </div>
                          </div>
                          <div class="wrap-nav-courses">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/bookkeeping-accounting-courses/" style="line-height: 120%;">Accounting and Bookkeeping Courses</a></h3>
                                <ul>
                                    <li class="page_item page-item-3765"><a href="https://www.inspireeducation.net.au/courses/accounting-and-bookkeeping-courses/certificate-iii-in-accounts-administration/">Certificate III In Accounts Administration</a></li>
                                    <li class="page_item page-item-3765"><a href="https://www.inspireeducation.net.au/courses/bookkeeping-accounting-courses/certificate-iv-in-accounting-and-bookkeeping/">Certificate IV In Accounting And Bookkeeping</a></li>
                                   <li class="page_item page-item-3505"><a href="https://www.inspireeducation.net.au/courses/accounting-and-bookkeeping-courses/diploma-of-accounting/">Diploma of Accounting</a></li>
                                   <p>
                                <h3><a href="https://www.inspireeducation.net.au/courses/marketing-and-communication-courses/" style="line-height: 120%;">Marketing and Communication Courses</a></h3>
									<li class="page_item page-item-234157"><a href="https://www.inspireeducation.net.au/courses/marketing-and-communication-courses/certificate-iv-in-marketing-and-communication/">Certificate IV in Marketing and Communication</a></li>
                                </ul>
                             </div>
                          </div>
                          <div class="wrap-nav-courses">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/business-administration-and-hr-courses/" style="line-height: 120%;">Business Administration and HR Courses</a></h3>
                                <ul>
                                   <li class="page_item page-item-136357"><a href="https://www.inspireeducation.net.au/courses/business-administration-and-hr-courses/certificate-iii-business-administration/">Certificate III in Business Administration</a></li>
                                   <li class="page_item page-item-132303"><a href="https://www.inspireeducation.net.au/courses/business-administration-and-hr-courses/certificate-iv-business/">Certificate IV in Business</a></li>
                                   <li class="page_item page-item-24593"><a href="https://www.inspireeducation.net.au/courses/business-administration-and-hr-courses/certificate-iv-business-administration/">Certificate IV in Business Administration</a></li>
                                   <li class="page_item page-item-229"><a href="https://www.inspireeducation.net.au/courses/business-administration-and-hr-courses/human-resources-training-course-cert-iv/">Certificate IV in Human Resources</a></li>
                                   <li class="page_item page-item-234155"><a href="https://www.inspireeducation.net.au/courses/business-administration-and-hr-courses/certificate-iv-in-new-small-business/">Certificate IV in New Small Business</a></li>
                                   <li class="page_item page-item-234161"><a href="https://www.inspireeducation.net.au/courses/business-administration-and-hr-courses/diploma-of-business/">Diploma of Business</a></li>
                                   <li class="page_item page-item-234163"><a href="https://www.inspireeducation.net.au/courses/business-administration-and-hr-courses/diploma-of-business-administration/">Diploma of Business Administration</a></li>
                                </ul>
                             </div>
                          </div>
                          <div class="wrap-nav-courses" style="clear: left;">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/child-care-courses/" style="line-height: 120%;">Child Care Courses</a> </h3>
                                <ul>
                                   <li class="page_item page-item-16261"><a href="https://www.inspireeducation.net.au/courses/child-care-courses/certificate-iii-in-early-childhood-education-and-care/">Certificate III in Early Childhood Education and Care</a></li>
                                   <li class="page_item page-item-16660"><a href="https://www.inspireeducation.net.au/courses/child-care-courses/diploma-of-early-childhood-education-care/">Diploma of Early Childhood Education and Care</a></li>
                                  <p>
									<h3> <a href="https://www.inspireeducation.net.au/courses/teachers-aide-courses-education-support-/certificate-iii-in-education-support/" style="line-height: 120%;">Teacher's Aide Courses And Education Support</a></h3>
								   <li class="page_item page-item-61977"><a href="https://www.inspireeducation.net.au/courses/education-support-teachers-aide-courses/certificate-iii-in-education-support/">Certificate III in Education Support</a></li>
                                   <li class="page_item page-item-258"><a href="https://www.inspireeducation.net.au/courses/education-support-teachers-aide-courses/certificate-iv-tesol-courses/">Certificate IV in TESOL</a></li>

                                </ul>
                             </div>
                          </div>
                          <div class="wrap-nav-courses">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/fitness-personal-trainer-courses/" style="line-height: 120%;">Fitness and Personal Trainer Courses</a></h3>
                                <ul>
                                   <li class="page_item page-item-126888"><a href="https://www.inspireeducation.net.au/courses/fitness-personal-trainer-courses/personal-trainer-course-sprint-package/">Personal Trainer Course - Sprint Package</a></li>
                                   <li class="page_item page-item-126825"><a href="https://www.inspireeducation.net.au/courses/fitness-personal-trainer-courses/certificate-iii-fitness/">SIS30315 Certificate III in Fitness</a></li>
                                   <li class="page_item page-item-126870"><a href="https://www.inspireeducation.net.au/courses/fitness-personal-trainer-courses/certificate-iv-fitness/">SIS40215 Certificate IV in Fitness</a></li>
                                </ul>
                             </div>
                          </div>
                          <div class="wrap-nav-courses">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/leadership-management-courses/" style="line-height: 120%;">Leadership and Management Courses</a></h3>
                                <ul>
                                   <li class="page_item page-item-19460"><a href="https://www.inspireeducation.net.au/courses/leadership-management-courses/certificate-iv-leadership-management">Certificate IV in Leadership and Management</a></li>
                                   <li class="page_item page-item-137581"><a href="https://www.inspireeducation.net.au/courses/leadership-management-courses/certificate-iv-retail-management/">Certificate IV in Retail Management</a></li>
                                   <li class="page_item page-item-136540"><a href="https://www.inspireeducation.net.au/courses/leadership-management-courses/certificate-iv-small-business-management/">Certificate IV in Small Business Management</a></li>
                                   <li class="page_item page-item-136733"><a href="https://www.inspireeducation.net.au/courses/leadership-management-courses/diploma-of-leadership-and-management">Diploma of Leadership and Management</a></li>
                                   <li class="page_item page-item-137672"><a href="https://www.inspireeducation.net.au/courses/leadership-management-courses/graduate-certificate-management-learning/">Graduate Certificate in Management</a></li>
                                   <li class="page_item page-item-138206"><a href="https://www.inspireeducation.net.au/courses/leadership-management-courses/graduate-diploma-strategic-leadership/">Graduate Diploma of Strategic Leadership</a></li>
                                </ul>
                             </div>
                          </div>
                           <div class="wrap-nav-courses">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/project-management-courses/" style="line-height: 120%;">Project Management Courses</a></h3>
                                <ul>
                                   <li class="page_item page-item-19460"><a href="https://www.inspireeducation.net.au/courses/project-management-courses/certificate-iv-in-project-management/">Certificate IV in Project Management Practice</a></li>
                                   <li class="page_item page-item-18740"><a href="https://www.inspireeducation.net.au/courses/project-management-courses/diploma-of-project-management/">Diploma of Project Management</a></li>
                                </ul>
                                <p>
														<h3><a href="https://www.inspireeducation.net.au/courses/occupational-health-and-safety-training-courses/" style="line-height: 120%;">OH&amp;S Courses | Work Health and Safety Courses</a></h3>
                                <ul>
                                   <li class="page_item page-item-7816"><a href="https://www.inspireeducation.net.au/courses/occupational-health-and-safety-training-courses/cert-iv-in-work-health-and-safety-whs-ohs-course/">Certificate IV in Work Health and Safety</a></li>
                                   <li class="page_item page-item-16238"><a href="https://www.inspireeducation.net.au/courses/occupational-health-and-safety-training-courses/diploma-work-health-and-safety/">Diploma of Work Health and Safety</a></li>
                                </ul>
                             </div>
                          </div>
                            <div class="wrap-nav-courses">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/" style="line-height: 120%;">Training and Assessment Courses</a></h3>
                                <ul>
                                    <li><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/certificate-iv-in-training-and-assessment/">Certificate IV in Training and Assessment</a></li>
                                   <li class="page_item page-item-4636"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/cert-iv-tae-fast-track-for-teachers/">Cert IV Training and Assessment for Teachers and Trainers</a></li>
									<li class="page_item page-item-25748"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/diploma-of-training-design-and-development/">Diploma of Training Design and Development</a></li>
                                   <li class="page_item page-item-28048"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/diploma-of-vocational-education-and-training/">Diploma of Vocational Education and Training</a></li>
                                </ul>
                             </div>
                          </div>
<div class="wrap-nav-courses">
                             <div class="nav-courses">
                                <h3><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/" style="line-height: 120%;">Cert IV TAE Upgrade and Units</a></h3>
                                <ul>
									<li class="page_item page-item-122633"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/tae40110-to-tae40116-upgrade/">TAE40110 to TAE40116 Upgrade</a></li>
                                   <li class="page_item page-item-2038"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/taa-to-tae-upgrade/">TAA to TAE Upgrade</a></li>
                                   <li class="page_item page-item-2043"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/bsz-to-tae-upgrade/">BSZ to TAE Upgrade</a></li>
                                   <li class="page_item page-item-17540"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/taelln411-address-adult-language-literacy-numeracy-skills/">TAELLN411 Address Adult Language, Literacy and Numeracy Skills</a></li>
                                   <li class="page_item page-item-140180"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/taess00011-assessor-skill-set/">TAESS00011 Assessor Skill Set</a></li>
                                   <li class="page_item page-item-140180"><a href="https://www.inspireeducation.net.au/courses/training-and-assessment-courses/taeass502-design-and-develop-assessment-tools/">TAEASS502 Design And Develop Assessment Tools</a></li>
                                </ul>
                             </div>
                          </div>
                       </div>
                    </div>
                  </li>
                <?php wp_nav_menu_no_ul(); ?>
              </ul>
            </nav>
            <div id="login-area"> <a href="http://inspireeducation.edu.au/learning/" target="_blank" title="student login" rel="nofollow">Student Login</a> </div>

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

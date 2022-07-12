<div id="sidebar" class="span-8 last">
  <div class="section">
    <h4>Blog</h4>
    <ul class="content-list">
      <?php query_posts('cat=3&showposts=2'); ?>
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <li <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <h3> <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
          <?php the_title(); ?>
          </a> </h3>
        <p class="quiet">
          <?php the_time('F j, Y') ?>
        </p>
        <?php the_excerpt(); ?>
      </li>
      <?php endwhile; endif; ?>
    </ul>
  </div>
  <div class="section">
    <h4>Social Networks</h4>
    <h3>Facebook</h3>
    <p>Why not become a fan of our work on Facebook?!</p>
    
    <script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US"></script><script type="text/javascript">FB.init("aaa5abfa35a0baad9c6de81bf9351a17");</script><fb:fan profile_id="336613458093" stream="0" connections="0" logobar="1" width="240" height="70"></fb:fan><p class="small"><a href="http://www.facebook.com/pages/Inspire-Educationion/336613458093">Inspire Education</a> on Facebook</p>
    <hr />
    <div id="twitter-wrap" class="clearfix">
    <h3>Twitter <span>Follow Us</span></h3>
    <p>We're also on Twitter, follow us for the latest updates!</p>
    <a href="https://twitter.com/inspireed" class="twitter-follow-button" data-show-count="true" data-lang="en" screen_name="@inspireed" >Follow @inspireed</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    <hr/>
    <h3>Instagram</h3>
    <p>Check us out on Instagram!</p>
    <style>.ig-b- { display: inline; }
.ig-b- img { visibility: hidden; }
.ig-b-:hover { background-position: 0 -60px; } .ig-b-:active { background-position: 0 -120px; }
.ig-b-16 { width: 16px; height: 16px; background: url(//badges.instagram.com/static/images/ig-badge-sprite-16.png) no-repeat 0 0; }
@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
.ig-b-16 { background-image: url(//badges.instagram.com/static/images/ig-badge-sprite-16@2x.png); background-size: 60px 178px; } }</style>
<a href="https://www.instagram.com/inspireeducation/?ref=badge" class="ig-b- ig-b-16"><img src="//badges.instagram.com/static/images/ig-badge-16.png" alt="Instagram" />  <b>Follow Us on Instagram</b></a>





   <!-- <script src="http://widgets.twimg.com/j/2/widget.js"></script>
    <script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 2,
  interval: 6000,
  width: 'auto',
  height: 270,
  theme: {
    shell: {
      background: '#ffffff',
      color: '#4a5153'
    },
    tweets: {
      background: '#ffff',
      color: '#4a5153',
      links: '#1993d5'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    hashtags: true,
    timestamp: true,
    avatars: false,
    behavior: 'all'
  }
}).render().setUser('inspireed').start();
</script>-->
</div>
  </div>
</div>

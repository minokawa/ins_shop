<?php get_header(); ?>

<div id="content-wrap" class="clearfix">
  <div id="page" class="article container">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div class="bread-crumbs">
	<?php if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	} ?>
	</div>
	<div itemscope itemtype="http://schema.org/Article" class="single-con">
	
	<div class="header mrgnhd">
     
      <?php
  $post = $wp_query->post;
  if (in_category('4')) { ?>
      <h3 class='course-cat'>Inspire Education's blog</h3>
      <?php } elseif (in_category('3')) { ?>
      <h3 class='course-cat'>Inspire Education's news</h3>
      <?php }
  else{ ?>
      <h3 class='course-cat'></h3>
      <?php }
?>
      <h1 itemprop="headline" class="page-title">
        <?php the_title(); ?>
      </h1>
      <p class="meta"><span class="comment_total">
        <?php comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'comments-link', 'Comments are off for this post'); ?>
        </span> &nbsp;&nbsp;Posted: <span itemprop="datePublished" content="<?php echo get_the_time('Y-m-d'); ?>">
        <?php the_time('d/m/y') ?>
        </span> &nbsp;&nbsp;by 
        <span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name">
        <?php the_author() ?>
        </span></span></p>
	<?php // if( function_exists( do_sociable() ) ){ do_sociable(); } ?>
	<div class="clearfix"></div>
	<div class="head-img">
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { 
    $thumb_id = get_post_thumbnail_id();
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, array(600,900), true);
    $thumb_url = $thumb_url_array[0]; ?>

    <img itemprop="image" src="<?php echo $thumb_url; ?>" class="ez-fr wp-post-image" alt="<?php the_title(); ?>">

    <?php } else { ?>
    <?php  if(is_single('22592')) { } else { ?><img itemprop="image" width="268" height="363" title="blog-image" alt="blog-image" class="ez-fr wp-post-image" src="http://inspireeducation.net.au/wp-content/uploads/2010/05/blog-image.png">
      <?php }} ?>
	  </div>
    </div>
    <!--<div id="post-<?php the_ID(); ?>" class="span-16 section">-->
    <div id="post-<?php the_ID(); ?>" class="article-list span-16 sing-con">
      <?php the_content(); ?>	  	   
      <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
      <?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
      <iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>;layout=standard&amp;show_faces=false&amp;width=450&amp;action=recommend&amp;font=arial&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
    <!--</div>--><!--span-16 section-->
    <!-- #primary .widget-area -->
    <div id="comment-area" class="span-16 section">
      <?php if ( comments_open() && pings_open() ) {
				// Both Comments and Pings are open ?>
      <p>You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.</p>
      <?php } elseif ( !comments_open() && pings_open() ) {
				// Only Pings are Open ?>
      <p>Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.</p>
      <?php } elseif ( comments_open() && !pings_open() ) {
				// Comments are open, Pings are not ?>
      <p>You can skip to the end and leave a response. Pinging is currently not allowed.</p>
      <?php } elseif ( !comments_open() && !pings_open() ) {
				// Neither Comments, nor Pings are open ?>
      <p>Both comments and pings are currently closed.</p>
      <?php } edit_post_link('Edit this entry','','.'); ?>
      <?php comments_template(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
	
	</div><!--span-16 section-->
	</div>		
	<div class="sidebar-1d">
	<?php	
	dynamic_sidebar(1);
	related_posts(); ?>
	</div>
	<?php get_sidebar();
	 ?>
  </div><!-- .single-con -->
</div>
<?php get_footer(); ?>

<?php 
/*
Template Name: Shop
*/
get_header(); ?>
<div id="content-wrap" class="clearfix">
  <div id="post" class="container">
    <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { the_post_thumbnail(array(320,900), array("class" => "ez-fr  wp-post-image")); } else { ?>
    <img width="268" height="363" title="blog-image" alt="blog-image" class="ez-fr wp-post-image" src="http://inspireeducation.net.au/wp-content/uploads/2010/05/blog-image.png">
    <?php } ?>
    <div class="span-16 section">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div class="post" id="post-<?php the_ID(); ?>">
        <h2 class="page-title">
          <?php the_title(); ?>
        </h2>
        <p class="very-large">Your course information is already on its way to you <strong>BUT</strong> Don't Go <strong>YET!</strong></p>
        <p class="very-large">Click the <strong>"Like"</strong> link below and become a fan of Inspire Education on Facebook to receive<br />
          <strong><a target="_blank" href="http://www.facebook.com/pages/Brisbane-Australia/Inspire-Education/336613458093" title="Inspire on facebook">exclusive Facebook-only course discounts and competitions! (It's FREE!)</a></strong> </p>
    <div id="social-thankyou">
	    <div class="fb-like clearfix" data-href="http://www.facebook.com/pages/Inspire-Education/336613458093" data-send="false" data-width="100%" data-show-faces="true" data-font="tahoma"></div>
    	</div>
        <hr />
		
		<?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>
    
        <?php wp_link_pages(array('before' => '<p>Pages: ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
      </div>
      <?php endwhile; endif; ?>
      <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
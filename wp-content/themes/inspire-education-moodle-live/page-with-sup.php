<?php get_header(); ?>
<div id="content-wrap" class="clearfix wrapper">
  <div id="page" class="clearfix container">
    <div id="page-supp-intro" class="section span-16">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div class="post" id="post-<?php the_ID(); ?>">
        <h2 class="page-title">
          <?php the_title(); ?>
        </h2>
        <?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>
        <?php wp_link_pages(array('before' => '<p>Pages: ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
      </div>
      <?php endwhile; endif; ?>
      <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
    </div>
    <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { the_post_thumbnail(array(320,900), array("class" => "ez-fr  wp-post-image")); } else { ?>
    <img width="268" height="363" title="blog-image" alt="blog-image" class="ez-fr wp-post-image" src="http://inspireeducation.net.au/wp-content/uploads/2010/05/blog-image.png">
    <?php } ?>
    <?php include (TEMPLATEPATH . '/page-supp.php'); ?>
  </div>
</div>
<?php get_footer(); ?>
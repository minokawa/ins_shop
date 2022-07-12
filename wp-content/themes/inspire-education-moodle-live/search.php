<?php get_header(); ?>

<div id="content-wrap" class="clearfix">
  <div id="page" class="container">
    <div class="header">
      <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { the_post_thumbnail(array(320,900), array("class" => "ez-fr  wp-post-image")); } else { ?>
      <img width="268" height="363" title="blog-image" alt="blog-image" class="ez-fr wp-post-image" src="http://beta.inspireeducation.net.au/wp-content/uploads/2010/05/blog-image.png">
      <?php } ?>
      <h3 class='course-cat'>Search Inspire Education</h3>
      <h2 class="page-title">Have a look at your results!</h2>
      <div class="article-list span-16">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div <?php post_class() ?>>
          <h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
            <?php the_title(); ?>
            </a></h2>
          <?php the_excerpt('<p>Read the rest of this page &raquo;</p>'); ?>
          <p>
            <?php the_tags('Tags: ', ', ', '<br />'); ?>
          </p>
        </div>
        <?php endwhile; ?>
      </div>
      <?php next_posts_link('&laquo; Older Entries') ?>
      <?php previous_posts_link('Newer Entries &raquo;') ?>
      <?php else : ?>
      <h2>No posts found. Try a different search?</h2>
      <?php get_search_form(); ?>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>

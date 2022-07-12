<?php get_header(); ?>
<div id="content-wrap" class="clearfix">
  <div id="page" class="container">
    <div class="span-16 section" id="page-404">
      <div class="post">
      <h2 class="course-cat">404 error - page not found</h2>
        <h2 class="page-title">
          Ahh, we seem to have a problem...
        </h2>
        <p>Basically, the page your looking for isn't here. This could be down to a number of things, but it's most likely because you've followed a dead link. As we've just upgraded our website links to the old site will no longer work. Sorry about that.</p>
        <p>Maybe try searching for the page your after using the form below?</p>
        <?php get_search_form(); ?>
      </div>
    </div>
    <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { the_post_thumbnail(array(320,900), array("class" => "ez-fr  wp-post-image")); } else { ?>
    <img width="268" height="363" title="blog-image" alt="blog-image" class="ez-fr wp-post-image" src="http://beta.inspireeducation.net.au/wp-content/uploads/2010/05/blog-image.png">
    <?php } ?>
    <?php include (TEMPLATEPATH . '/page-supp.php'); ?>
  </div>
</div>
<?php get_footer(); ?>
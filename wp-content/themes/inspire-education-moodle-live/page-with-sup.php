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

    <?php include (TEMPLATEPATH . '/page-supp.php'); ?>
  </div>
</div>
<?php get_footer(); ?>

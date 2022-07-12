<?php get_header(); ?>
<div id="content-wrap" class="clearfix">
	<div id="content-blog">
  <div id="page" class="container">
  <div class="bread-crumbs">
	<?php if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	} ?>
	</div>

    <div class="header"> <!--<img width="268" height="363" title="blog-image" alt="blog-image" class="ez-fr wp-post-image" src="http://beta.inspireeducation.net.au/wp-content/uploads/2010/05/blog-image.png">-->
      <h3 class='course-cat'><?php single_cat_title(); ?></h3>
	  <div class="banner-img">
		<?php
		//first get the current category ID
		$cat_id = get_query_var('cat');
		$option_name = 'image_url_' . $cat_id;
		$image_url = get_option( $option_name );
		if($image_url != '') : ?>
			<img src="<?php echo $image_url; ?>" style="float:left; margin-right: 10px;" />
		<?php endif; ?>
	  </div>
      <?php if (have_posts()) : ?>
      <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
      <?php /* If this is a category archive */ if ( is_category() ) { ?>
      <h1 class="page-title"><?php if ( is_category('3') || is_category('6') ) { ?>The Inspire Ed <?php } ?><? single_cat_title(); ?></h1>
      <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
      <h2 class="page-title">Posts Tagged &#8216;
        <?php single_tag_title(); ?>
        &#8217;</h2>
      <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
      <h2 class="page-title">Archive for
        <?php the_time('F jS, Y'); ?>
      </h2>
      <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
      <h2 class="page-title">Archive for
        <?php the_time('F, Y'); ?>
      </h2>
      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
      <h2 class="page-title">Archive for
        <?php the_time('Y'); ?>
      </h2>
      <?php /* If this is an author archive */ } elseif (is_author()) { ?>
      <h2 class="page-title">Author Archive</h2>
      <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
        <h2 class="page-title">Blog Archives</h2>
        <?php } ?>
    </div>
	<div class="single-con">
    <div class="article-list span-16" id="blog_anc">
      <?php while (have_posts()) : the_post(); ?>
      <div id="post-<?php the_ID(); ?>" class="article ">
        <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'inspire' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
          <?php the_title(); ?>
          </a></h2>
        <p class="meta"><span class="comment_total">
          <?php comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'comments-link', 'Comments are off for this post'); ?>
          </span> &nbsp;&nbsp;Posted: <span>
          <?php the_time('d/m/y') ?>
          </span> &nbsp;&nbsp;by <span>
          <?php the_author() ?>
          </span></p>
		<?php // if( function_exists( do_sociable() ) ){ do_sociable(); } ?>
        <?php //the_content(); ?>
		<?php //Get the first image of every post
			/* $files = get_children('post_parent='.get_the_ID().'&post_type=attachment&post_mime_type=image');
			  if($files) :
				$keys = array_reverse(array_keys($files));
				$j=0;
				$num = $keys[$j];
				$image=wp_get_attachment_image($num, 'full', false);
				echo $image;
			  endif; */

			if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				the_post_thumbnail();
			}
		?>
        <?php the_excerpt(); ?>
		<?php //related_posts();?>
		<?php //global $withcomments; $withcomments = 1; comments_template(); ?>
      </div>
      <?php endwhile; ?>
      <?php if (next_posts_link() || previous_posts_link()): ?>
      <div class="next-link"><?php next_posts_link('&laquo; Older Entries') ?></div>

      <div class="prev-link"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
      <?php endif ?>
      <?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2>No posts found.</h2>");
		}
		get_search_form();

	endif;
?>
    </div>
	</div><!-- .single-con -->
	<div class="sidebar-1d">
	<?php dynamic_sidebar(1);?>
	<?php get_sidebar(); ?>
  </div>
  </div>
</div>
<?php get_footer(); ?>

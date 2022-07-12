<?php get_header(); ?>

<div id="content-wrap" class="clearfix wrapper">
  <div id="page" class="clearfix article container">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="header span-16">
    <div class="breadcrumbs">

          <h2 class="page-title">Nationally-Accredited Courses</h2>
          <?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>
        </div>
&nbsp;
            <div class="footer">
            <?php wp_link_pages(array('before' => '<p>Pages: ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            <?php endwhile; endif; ?>
            <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
            </div>
        </div>
        <div id="courseWrapper" class="course-index-form">
          <div id="course-contact">
            <form method="post" name="General Enquiry" action="mailto:enquiries@inspireeducation.net.au" ENCTYPE="text/plain" onSubmit="return valid(this)style=height: 332px" class="" id="course-contact-form" >
              <fieldset>
                <p class="full"> Please call <strong>1800 506 509</strong> OR <strong>fill out the form below</strong> and we'll get back to you within 1 business day.</p>
                <input type="hidden" name="subject" value="Inspire General Enquiry">
                <input type="hidden" name="redirect" value="education.net.au/thank-you/">
                <p>
                  <label for="firstname" class="inlined">Your name</label>
                  <input type="text" name="name" value="" id="name" tabindex="1" class="text">
                </p>
                <p>
                  <label for="email" class="inlined">Email</label>
                  <input type="text" value="" id="email" name="email" tabindex="4" class="text">
                </p>
                <p class="full">
                  <label for="Comments" class="inlined">Your comments?</label>
                  <textarea cols="20" rows="5" name="Comments" tabindex="8" class="text"></textarea>
                </p>
                <input name="Submit1" type="submit" class="submit" value="Send your enquiry now!">
              </fieldset>
            </form>
          </div>
        </div>
  </div>
</div>
<?php include (TEMPLATEPATH . '/footer.php');

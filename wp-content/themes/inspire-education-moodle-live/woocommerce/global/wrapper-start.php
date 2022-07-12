<?php
/**
 * Content wrappers
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit;?>

<div id="content-wrap" class="clearfix"><div id="post" class="page-shop container article">

<?php if (!is_shop()) { return ' ';} ?>

<div class="reveal-modal modal" id="cart-modal-shop" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content products-modal">
			<a href="#" class="close" data-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></a>
      <h2 class="loading_products">Loading Courses...</h2>
			<h2 class="modal_title" style="display:none">Please select your course from one of the <span id="course-count"></span> options below</h2>
			<ul id="product-courses" class="products"></ul>
		</div>
	</div>
</div>

<?php do_action('inspire_generate_products_modal') ?>

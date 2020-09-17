<?php
/**
 * The template for displaying a list of all the books in a series in the BLFA plugin
 *
 * @link https://www.pluviotech.com
 * @package BookListForAuthors
 */
 use Inc\Util\DatabaseUtil;
 require_once('blfa-util.php');

 wp_enqueue_style( 'blfa-seriespage-css', plugin_dir_url( dirname( __FILE__, 2 ) ) . 'css/seriespage.css');

 function findSeries($slug, $list) {
	 $series = null;
	 foreach ($list as $id => $value) {
		 if ($value['blfa_series_slug'] == $slug) {
			 $series = $value;
		 }
   }

	return $series;
 }

 function getSeriesLayoutClasses($blfa_options) {
	 $layout = $blfa_options['blfa_series_page_layout'];
	 $layout_classes = 'blfa-' . $layout . '-layout';

	 if ($layout == 'list') {
		 	$layout_classes = $layout_classes . ' blfa-' . $blfa_options['blfa_series_list_layout'] . '-list-layout';
	 }

	 return $layout_classes;
 }

 function getCoverHtml($book, $size, $odd_toggle, $blfa_options) {
   $cover_html = wp_get_attachment_image($book->cover, getCoverSize($blfa_options[$size]), array("class" => ($odd_toggle ? 'left' : 'right')));

   if ($blfa_options['blfa_bookpage_include_page']) {
     $cover_html = '<a href="' . get_site_url() . '/books/' . $book->slug . '">' . $cover_html . '</a>';
   }

   return $cover_html;
 }

 $dbUtil = new DatabaseUtil();
 $blfa_options = get_option('blfa_plugin_settings');
 $retailers = get_option('blfa_plugin_retailers');
 $series_list = get_option('blfa_plugin_series');
 $series_slug = get_query_var('blfa_series');
 $on_top = getCoverContainerLocation($blfa_options['blfa_series_page_layout'], $blfa_options['blfa_series_list_layout']);

 $series = findSeries($series_slug, $series_list);

 if ($series != null) {
	 $books = $dbUtil->getSeriesBooks($series['blfa_series_id']);
 }

  if ($blfa_options['blfa_series_page_layout'] == 'featured') {
     $featured_book = $dbUtil->getFeaturedBook($series['blfa_series_id'], $blfa_options['blfa_series_featured_book'], $blfa_options['blfa_series_featured_by_me'], $blfa_options['blfa_settings_author'])[0];
     $books = removeFromArray($books, $featured_book->id);
  }

get_header();
?>

<section id="primary" class="content-area">
	<main id="main" class="site-main">
		<div class="main-content clear-fix">
				<div class="main-container">
					<article id="series-page" class="series page type-page <?php echo getSeriesLayoutClasses($blfa_options); ?>">
						<?php
						if ($series == null) { ?>
							<div class="post-content">
								Series not found. <a href="<?php echo site_url() . '/books';?>">See all books.</a>
							</div>
						<?php } else { ?>
							<header class="post-header">
								<h1 class="page-title"><?php echo $series['blfa_series_title'];?></h1>
								<?php if ($series['blfa_shared_series']) { ?>
									<h4 class="blfa-shared-series">(Shared)</h4>
								<?php } ?>
							</header>
							<div class="post-content">
								<div class="blfa-series-container">
									<?php
                    $odd_toggle = true;
                    if ($blfa_options['blfa_series_page_layout'] == 'featured') { ?>
                      <div class="blfa-featured-book-container">
                        <div class="blfa-featured-title-container">
                        <?php
                          if ($blfa_options['blfa_series_include_number'] && $blfa_options['blfa_series_number_top'] && $featured_book->book_order > -1) { ?>
                            <p class="blfa-featured-book-number">Book <?php echo $featured_book->book_order; ?></p>
                        <?php } ?>
                        <?php
                          if ($blfa_options['blfa_series_include_title']) { ?>
                            <p class="blfa-featured-book-title"><?php echo $featured_book->title; ?></p>
                        <?php } ?>
                        <?php
                          if ($blfa_options['blfa_series_include_number'] && !$blfa_options['blfa_series_number_top'] && $featured_book->book_order > -1) { ?>
                            <p class="blfa-featured-book-number">Book <?php echo $featured_book->book_order; ?></p>
                        <?php } ?>
                        </div>

                        <div class="blfa-featured-cover-container">
                          <?php echo getCoverHtml($featured_book, 'blfa_series_featured_cover_size', $odd_toggle, $blfa_options); ?>
                        </div>

                        <?php
                          if($blfa_options['blfa_series_include_author']) {
                        ?>
                          <p class="blfa-featured-author"><?php echo $featured_book->author; ?></p>
                        <?php } ?>
                        <div class="blfa-featured-description-container">
                          <?php
                            if ($blfa_options['blfa_series_include_desc']) { ?>
                              <?php echo nl2p($featured_book->description); ?>
                          <?php } ?>
                        </div>
                        <?php
                          if ($blfa_options['blfa_series_include_buy_button']) { ?>
                            <p class="blfa-featured-button-container">
                              <?php echo getRetailerButton($featured_book, $retailers); ?>
                            </p>
                        <?php } ?>
  										</div>
                  <?php }

                    foreach ($books as $book) { ?>
  										<div class="blfa-book-container">
                        <?php if ($on_top) { ?>
                          <div class="blfa-cover-container">
                            <?php echo getCoverHtml($book, 'blfa_series_cover_size', $odd_toggle, $blfa_options); ?>
                          </div>
                        <?php } ?>

                        <div class="blfa-title-container">
                        <?php
                          if ($blfa_options['blfa_series_include_number'] && $blfa_options['blfa_series_number_top'] && $book->book_order > -1) { ?>
                            <p class="blfa-book-number">Book <?php echo $book->book_order; ?></p>
                        <?php } ?>
                        <?php
                          if ($blfa_options['blfa_series_include_title']) { ?>
                            <p class="blfa-book-title"><?php echo $book->title; ?></p>
                        <?php } ?>
                        <?php
                          if ($blfa_options['blfa_series_include_number'] && !$blfa_options['blfa_series_number_top'] && $book->book_order > -1) { ?>
                            <p class="blfa-book-number">Book <?php echo $book->book_order; ?></p>
                        <?php } ?>
                        </div>

                        <?php if (!$on_top) { ?>
                          <div class="blfa-cover-container">
                            <div class="blfa-cover-container">
                              <?php echo getCoverHtml($book, 'blfa_series_cover_size', $odd_toggle, $blfa_options); ?>
                            </div>
    											</div>
                        <?php } ?>

                        <?php
                          if($blfa_options['blfa_series_include_author']) {
                        ?>
                          <p class="blfa-author"><?php echo $book->author; ?></p>
                        <?php } ?>
                        <div class="blfa-description-container">
                          <?php
                            if ($blfa_options['blfa_series_include_desc']) { ?>
                              <?php echo nl2p($book->description); ?>
                          <?php } ?>
                        </div>
                        <?php
                          if ($blfa_options['blfa_series_include_buy_button']) { ?>
                            <p class="blfa-button-container">
                              <?php echo getRetailerButton($book, $retailers); ?>
                            </p>
                        <?php } ?>
  										</div>
								<?php
                    $odd_toggle = !$odd_toggle;
                  } ?>
								</div>
							</div>
						<?php } ?>
					</article>
				</div>
			</div>
		</main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();

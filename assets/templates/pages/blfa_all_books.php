<?php
/**
 * The template for displaying a list of all books in the BLFA plugin
 *
 * @link https://www.pluviotech.com
 * @package BookListForAuthors
 */
  use Inc\Util\DatabaseUtil;
  require_once('blfa-util.php');

  wp_enqueue_style( 'blfa-allbooks-css', plugin_dir_url( dirname( __FILE__, 2 ) ) . 'css/allbooks.css');

  function getLayoutClasses($blfa_options) {
 	 $layout = $blfa_options['blfa_allbooks_page_layout'];
 	 $layout_classes = 'blfa-' . $layout . '-layout';

 	 if ($layout == 'list') {
 		 	$layout_classes = $layout_classes . ' blfa-' . $blfa_options['blfa_allbooks_list_layout'] . '-list-layout';
 	 }

 	 return $layout_classes;
  }

  function getSeriesHtml($series_id, $blfa_options, $series_list) {
    $series = $series_list[$series_id];
    $series_html = '<h2 class="title">' . $series['blfa_series_title'] . ($series['blfa_shared_series'] ? ' (Shared) ' : ''). '</h2>';

    if ($blfa_options['blfa_seriespage_include_page']) {
      $series_html = '<a href="' . get_site_url() . '/books/' . $series['blfa_series_slug'] . '">' . $series_html . '</a>';
    }

    return $series_html;
  }

  function getCoverHtml($book, $odd_toggle, $blfa_options) {
    $cover_html = wp_get_attachment_image($book->cover, getCoverSize($blfa_options['blfa_allbooks_cover_size']), array("class" => ($odd_toggle ? 'left' : 'right')));

    if ($blfa_options['blfa_bookpage_include_page']) {
      $cover_html = '<a href="' . get_site_url() . '/books/' . $book->slug . '">' . $cover_html . '</a>';
    }

    return $cover_html;
  }

  $dbUtil = new DatabaseUtil();
  $blfa_options = get_option('blfa_plugin_settings');
  $retailers = get_option('blfa_plugin_retailers');
  $series_list = get_option('blfa_plugin_series');
  $on_top = getCoverContainerLocation($blfa_options['blfa_allbooks_page_layout'], $blfa_options['blfa_allbooks_list_layout']);

	$catalog = array();
	//Get all the books that are stand alone and add them to the array
  $sa_books = $dbUtil->getStandAloneBooks();

  if ($sa_books != null && count($sa_books) > 0) {
	   $catalog['Stand Alone Books'] = $dbUtil->getStandAloneBooks();
  }

	//Loop through the series, get the books from the DB and add them to an array of arrays
	foreach ($series_list as $series) {
    echo "Series 1";
    $series_books = $dbUtil->getSeriesBooks($series['blfa_series_id']);

    if ($series_books != null && count($series_books) > 0) {
      echo "Series 2";
		  $catalog[$series['blfa_series_id']] = $series_books;
    }
	}

  echo count($catalog);

 get_header();
 ?>

 <section id="primary" class="content-area">
 	<main id="main" class="site-main">
 		<div class="main-content clear-fix">
 				<div class="main-container">
 					<article id="allbooks-page" class="allbooks page type-page <?php echo getLayoutClasses($blfa_options); ?>">
 						<?php
 						if ($catalog == null || count($catalog) < 1) { ?>
 							<div class="post-content">
 								No Books Found.

                	<?php foreach ($series_list as $series) {
                    echo $series['blfa_series_id'] . '<br />';
                  }?>
 							</div>
 						<?php } else { ?>
 							<header class="post-header">
 								<h1 class="page-title">Books</h1>
 							</header>
 							<div class="post-content">
								<?php foreach ($catalog as $category => $books) { ?>
	 								<div class="blfa-category-container">
                    <?php
                       if ($category == 'Stand Alone Books') {
                         echo '<h2 class="title">' . $category . '</h2>';
                       } else {
                         echo getSeriesHtml($category, $blfa_options, $series_list);
                       }

	                     $odd_toggle = true;

	                     foreach ($books as $book) { ?>
	   										<div class="blfa-book-container">
	                         <?php if ($on_top) { ?>
	                           <div class="blfa-cover-container">
                               <?php echo getCoverHtml($book, $odd_toggle, $blfa_options); ?>
	     											 </div>
	                         <?php } ?>

	                         <div class="blfa-title-container">
	                         <?php
	                           if ($blfa_options['blfa_allbooks_include_number'] && $blfa_options['blfa_allbooks_number_top'] && $book->book_order > -1) { ?>
	                             <p class="blfa-book-number">Book <?php echo $book->book_order; ?></p>
	                         <?php } ?>
	                         <?php
	                           if ($blfa_options['blfa_allbooks_include_title']) { ?>
	                             <p class="blfa-book-title"><?php echo $book->title; ?></p>
	                         <?php } ?>
	                         <?php
	                           if ($blfa_options['blfa_allbooks_include_number'] && !$blfa_options['blfa_allbooks_number_top'] && $book->book_order > -1) { ?>
	                             <p class="blfa-book-number">Book <?php echo $book->book_order; ?></p>
	                         <?php } ?>
	                         </div>

	                         <?php if (!$on_top) { ?>
	                           <div class="blfa-cover-container">
	     												<?php echo getCoverHtml($book, $odd_toggle, $blfa_options); ?>
	                           </div>
	                         <?php } ?>

	                         <?php
	                           if($blfa_options['blfa_allbooks_include_author']) {
	                         ?>
	                           <p class="blfa-author"><?php echo $book->author; ?></p>
	                         <?php } ?>
	                         <div class="blfa-description-container">
	                           <?php
	                             if ($blfa_options['blfa_allbooks_include_desc']) { ?>
	                               <?php echo nl2p($book->description); ?>
	                           <?php } ?>
	                         </div>
	                         <?php
	                           if ($blfa_options['blfa_allbooks_include_buy_button']) { ?>
	                             <p class="blfa-button-container">
	                               <?php echo getRetailerButton($book, $retailers); ?>
	                             </p>
	                         <?php } ?>
	   										</div>
	 								<?php
	                     $odd_toggle = !$odd_toggle;
	                   } ?>
	 								</div>
	 						<?php } ?>
							</div>
						<?php } ?>
 					</article>
 				</div>
 			</div>
 		</main><!-- #main -->
 </section><!-- #primary -->

 <?php
 get_footer();

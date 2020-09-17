<?php
/**
 * The template for displaying a single book in the BLFA plugin
 *
 * @link https://www.pluviotech.com
 * @package BookListForAuthors
 */
use Inc\Util\DatabaseUtil;
require_once('blfa-util.php');

wp_enqueue_style( 'blfa-bookpage-css', plugin_dir_url( dirname( __FILE__, 2 ) ) . 'css/bookpage.css');

$dbUtil = new DatabaseUtil();
$book = $dbUtil->getBookBySlug(get_query_var('blfa_book'))[0];
$blfa_options = get_option('blfa_plugin_settings');
$retailers = get_option('blfa_plugin_retailers');
$series_list = get_option('blfa_plugin_series');

function getRetailerButtons($book, $retailers) {
  $buttons = '';

  $links = decodeArray($book->book_links);

  foreach ($links as $retailer_id => $link) {
    $retailer = $retailers[$retailer_id];
    $buttons = $buttons . '<a class="blfa-retailer-button" href="' . $link . $retailer['blfa_affiliate_tag'] . '" target="_blank">' . getRetailerLinkInternalHTML($retailer)  . '</a>';
  }

  return $buttons;
}

function getCoverHtml($book, $blfa_options, $retailers) {
  $cover_html = wp_get_attachment_image($book->cover, getCoverSize($blfa_options['blfa_bookpage_cover_size']));

  if($blfa_options['blfa_bookpage_link_cover']) {
    $cover_html = '<a href="' . getDefaultRetailerLink($book, $retailers) . '" target="_blank">' . $cover_html . '</a>';
  }

  return $cover_html;
}

function getAuthorHtml($book, $blfa_options) {
  $author_html = $book->author;

  if($blfa_options['blfa_bookpage_link_author'] == 'always' || ($blfa_options['blfa_bookpage_link_author'] == 'not-me' && $book->author != $blfa_options['blfa_settings_author'])) {
    $author_html = '<a href="' . $book->author_url . '" target="_blank">' . $author_html . '</a>';
  }

  return $author_html;
}

function getSeriesHtml($book, $series_list, $blfa_options) {
  $series_html = '<h3 class="blfa-title">' . $series_list[$book->series]['blfa_series_title'] . '</h3>';

  if ($blfa_options['blfa_seriespage_include_page']) {
    $series_html = '<a href="' . get_site_url() . '/books/' . $series_list[$book->series]['blfa_series_slug'] . '">' . $series_html . '</a>';
  }

  return $series_html;
}

get_header();
?>
<section id="primary" class="content-area">
	<main id="main" class="site-main">
    <div class="main-content clear-fix">
        <div class="main-container">
          <article id="book-page" class="book page type-page blfa-<?php echo $blfa_options['blfa_bookpage_page_layout']; ?>-layout">
            <?php
            if ($book == null || $book->hide) { ?>
              <div class="post-content">
                Book not found. <a href="<?php echo site_url() . '/books';?>">See all books.</a>
              </div>
            <?php } else { ?>
              <header class="post-header">
                <h1 class="page-title"><?php echo $book->title;?></h1>
                <h4 class="blfa-subtitle"><?php echo $book->subtitle;?></h4>
              </header>
              <div class="post-content">
                <div class="blfa-cover-container">
                  <div class="blfa-cover">
                    <?php
                      echo getCoverHtml($book, $blfa_options, $retailers);
                     ?>
                     <?php
                      if ($blfa_options['blfa_bookpage_buy_button_location'] == 'below-cover') { ?>
                        <div class="blfa-button-container">
                          <div class="blfa-buttons">
                          <?php echo getRetailerButtons($book, $retailers); ?>
                          </div>
                        </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="blfa-description-container">
                  <?php
                    if ($blfa_options['blfa_bookpage_include_number'] && $blfa_options['blfa_bookpage_number_top'] && $book->book_order > -1) { ?>
                      <h3 class="blfa-book-number">Book <?php echo $book->book_order; ?></h3>
                  <?php  } ?>

                  <?php
                    if ($blfa_options['blfa_bookpage_include_series']) {
                      echo getSeriesHtml($book, $series_list, $blfa_options);
                    }
                  ?>

                  <?php
                    if ($blfa_options['blfa_bookpage_include_number'] && !$blfa_options['blfa_bookpage_number_top'] && $book->book_order > -1) { ?>
                      <h3 class="blfa-book-number">Book <?php echo $book->book_order; ?></h3>
                  <?php  } ?>

                  <?php
                    if($blfa_options['blfa_bookpage_include_author']) {
                  ?>
                    <h4 class="blfa-author"><?php echo getAuthorHtml($book, $blfa_options); ?></h4>
                  <?php
                    }
                  ?>

                  <?php echo nl2p($book->description); ?>

                  <?php
                   if ($blfa_options['blfa_bookpage_buy_button_location'] == 'below-desc') { ?>
                     <div class="blfa-button-container">
                       <div class="blfa-buttons">
                       <?php echo getRetailerButtons($book, $retailers); ?>
                       </div>
                     </div>
                 <?php } ?>
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
?>

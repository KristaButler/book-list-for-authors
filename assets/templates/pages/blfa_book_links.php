<?php
/**
 * The template for displaying a list of all books in the BLFA plugin
 *
 * @link https://www.pluviotech.com
 * @package BookListForAuthors
 */
  use Inc\Util\DatabaseUtil;
  require_once('blfa-util.php');

  wp_enqueue_style( 'blfa-booklink-css', plugin_dir_url( dirname( __FILE__, 2 ) ) . 'css/booklinks.css');

  $dbUtil = new DatabaseUtil();
  $blfa_options = get_option('blfa_plugin_settings');
  $retailers = get_option('blfa_plugin_retailers');
  $series_list = get_option('blfa_plugin_series');

  $catalog = array();
  //Get all the books that are stand alone and add them to the array
  $catalog['Stand Alone Books'] = $dbUtil->getStandAloneBooks();

  //Loop through the series, get the books from the DB and add them to an array of arrays
  foreach ($series_list as $series) {
    $catalog[$series['blfa_series_id']] = $dbUtil->getSeriesBooks($series['blfa_series_id']);
  }

  $split = floor(count($catalog) / 4); //Split to 4 columns

  function getSeriesHtml($series_id, $blfa_options, $series_list) {
    $series = $series_list[$series_id];
    $series_html = '<div class="blfa-links-title">' . $series['blfa_series_title'] . ($series['blfa_shared_series'] ? ' (Shared) ' : ''). '</div>';

    if ($blfa_options['blfa_seriespage_include_page']) {
      $series_html = '<a href="' . get_site_url() . '/books/' . $series['blfa_series_slug'] . '">' . $series_html . '</a>';
    }

    return $series_html;
  }

  function getBookHtml($book, $blfa_options, $retailers) {
    $book_html = $book->title;

    if ($blfa_options['blfa_bookpage_include_page']) {
      $book_html = '<a href="' . get_site_url() . '/books/' . $book->slug . '">' . $book_html . '</a>';
    } else {
      $book_html = '<a href="' . getDefaultRetailerLink($book, $retailers) . '" target="_blank">' . $book_html . '</a>';
    }

    return '<div class="blfa-book-link">' . $book_html . '</div>';
  }

get_header();
?>

<section id="primary" class="content-area">
 <main id="main" class="site-main">
   <div class="main-content clear-fix">
       <div class="main-container">
         <article id="book-links-page" class="booklinks page type-page">
           <header class="post-header">
             <!-- Intentionally Left Blank -->
           </header>
           <div class="post-content">
             <div class="blfa-links-container">
               <div class="blfa-column">
             <?php
               $count = 0;
               foreach ($catalog as $category => $books) {
                 if ($count == $split) {
                   $count = 0;
              ?>
                </div>
                <div class="blfa-column">
              <?php
            } else {
              $count = $count + 1;
            }
              ?>
               <div class="blfa-category-container">
                 <div class="blfa-book-container">
                   <?php
                    if ($category == 'Stand Alone Books') {
                      echo '<div class="blfa-links-title">' . $category . '</div>';
                    } else {
                      echo getSeriesHtml($category, $blfa_options, $series_list);
                    }

                    foreach ($books as $book) {
                      echo getBookHtml($book, $blfa_options, $retailers);
                    } ?>
                 </div>
               </div>
             <?php } ?>
              </div>
            </div>
           </div>
         </article>
       </div>
   </div>
 </main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();

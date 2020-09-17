<?php
/*Pagination: https://stackoverflow.com/questions/5322266/add-pagination-in-wordpress-admin-in-my-own-customized-plugin */
  use Inc\Util\DatabaseUtil;

  wp_enqueue_style( 'blfa-bookadmin-css', plugin_dir_url( dirname( __FILE__, 1 ) ) . 'css/book-admin.css');

  $asset_path = plugin_dir_url( dirname( __FILE__, 1) );
  $book_id = $_GET["book"];
  $data = array();
  $default_cover_img = $asset_path . 'img/no-cover-img.png';
?>
  <span style="display: none;" id="default_cover_img"><?php echo $default_cover_img; ?></span>
<div>
  <?php
  global $wpdb;
  echo $wpdb->last_error; ?>
  <br />
  <?php echo $wpdb->last_result;?>
</div>
<div class="wrap blfa-book-list-container">
  <?php
    if(isset($book_id)) {
      if($book_id == "new") {
?>
  <h2>Add Book</h2>
<?php
  } else {
    $dbUtil = new DatabaseUtil();
    $data = $dbUtil->getBook($book_id);
?>
<h2>Update Book</h2>
<?php } ?>
  <?php settings_errors(); ?>

  <div class="blfa-spinner" style="display: none;"><img src="<?php echo $asset_path; ?>img/blfa-spinner.gif" alt="loading"/></div>
  <div class="spacer">
    &nbsp;
  </div>

  <div id="blfa-admin-content">
    <a href="?page=blfa_plugin_books" class="page-title-action spinner-button" id="back-button" name="back-button">Back</a>
    <form id="blfa-update-book-form" method="post" action="options.php">
      <?php
        wp_nonce_field("blfa_cu_book", "blfa_cu_book_nonce");
        settings_fields('blfa_plugin_book');
        do_settings_sections('blfa_plugin_book');

        $list = get_option('blfa_plugin_retailers');

        if (count($list) > 0) {
        ?>
        <h3>Retailer Links</h3>
        <div><i>Leave blank to to omit.</i></div>
        <table class="blfa_plugin_retailers">
        <?php
          foreach($list as $id => $item) {
            //Don't display the default retailer listing
            if ($id != 'default_retailer') {
              $name = $item['blfa_retailer_name'];

              echo '<tr class="blfa_retailer">'
                . '<td>' . $name . '</td>'
                . '<td><input type="text" value="" id="' . $id . '" name="'
                . $id . '" class="retailer_link"/></td></tr>';
            }
          }
        ?>
        </table>
        <?php
        }

        submit_button();

        if($book_id == "new") {
      ?>
        <input id="blfa-clear-button" type="button" class="button button-secondary" value="Clear"/>
      <?php } else { ?>
        <script>
          jQuery( document ).ready(function() {
            loadBookData(<?php echo json_encode($data) ?>);
          });
        </script>
      <?php } ?>
    </form>
  </div>
<?php



    } else {

  ?>
    <h2>Book List</h2>
    <?php
      $dbUtil = new DatabaseUtil();
      $book_list = $dbUtil->getAllBooks();
      $series_list = get_option('blfa_plugin_series');

      function getPageLink($book, $series_list) {
        $page_link = get_site_url() . '/books' ;

        if (isset($book->series) && $book->series != null) {
          $series = $series_list[$book->series];

          $page_link = $page_link . '/' . $series['blfa_series_slug'];
        }

        return $page_link . '/' . $book->slug;
        return $series_list[$book->series];
      }

      settings_errors();
    ?>
    <div class="blfa-spinner" style="display: none;"><img src="<?php echo $asset_path; ?>img/blfa-spinner.gif" alt="loading"/></div>
    <div class="spacer">
      &nbsp;
    </div>
    <div id="blfa-admin-content">
      <a href="?page=blfa_plugin_books&book=new" class="page-title-action spinner-button" id="add-book-button-upper" name="add-book-button">Add Book</a>
      <div class="spacer">
        &nbsp;
      </div>
      <div>
        <a href="<?php echo get_site_url() . '/books'?>">View All Books Page</a>
      </div>
      <div class="spacer">
        &nbsp;
      </div>
      <div class="blfa-book-list">
        <?php
          if ($book_list) {
        ?>
        <div id="pager" class="pager">
          <form>
            <img src="<?php echo $asset_path; ?>img/beginning-nav.png" class="first"/>
            <img src="<?php echo $asset_path; ?>img/left-nav.png" class="prev"/>
            <!-- the "pagedisplay" can be any element, including an input -->
            <span class="pagedisplay" data-pager-output-filtered="{startRow:input} &ndash; {endRow} / {filteredRows} of {totalRows} total books"></span>
            <img src="<?php echo $asset_path; ?>img/right-nav.png" class="next"/>
            <img src="<?php echo $asset_path; ?>/img/end-nav.png" class="last"/>
            <select class="pagesize">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="40">40</option>
              <option value="all">All Rows</option>
            </select>
          </form>
        </div>
        <table id="blfa-book-list" class="wp-list-table widefat fixed striped blfa-book-list-table">
          <thead>
            <tr>
              <th width="5%" class="manage-column blfa-cover-column filter-false sorter-false">Cover</th>
              <th width="14%" class="manage-column column-primary">Title</th>
              <th width="15%" class="manage-column">Subtitle</th>
              <th width="10%" class="manage-column">Series</th>
              <th width="9%" class="manage-column">Order/#</th>
              <th width="10%" class="manage-column filter-false">Pub. Date</th>
              <th width="10%" class="manage-column">Author</th>
              <th width="8%" class="manage-column filter-false">Hide?</th>
              <th width="10%" class="manage-column">URL Slug</th>
              <th width="8%" class="manage-column blfa-actions-column filter-false sorter-false">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php
            foreach ($book_list as $book) {
              ?>
              <tr id="<?php echo $book->id; ?>">
                <td>
                  <?php echo  wp_get_attachment_image($book->cover, 'blfa-cover-thumbnail');?>
                  <span style="display: none;"><?php echo $book->cover;?></span>
                </td>
                <td>
                  <?php echo $book->title; ?>
                  <span style="display: none;"><?php echo $book->id;?></span>
                </td>
                <td>
                  <?php echo $book->subtitle; ?>
                </td>
                <td>
                  <?php echo $series_list[$book->series]['blfa_series_title']; ?>
                </td>
                <td>
                  <?php if ($book->book_order > -1) {echo $book->book_order;} ?>
                </td>
                <td>
                  <?php echo $book->publication_date; ?>
                </td>
                <td>
                  <a href="<?php echo $book->author_url; ?>"><?php echo $book->author; ?></a>
                </td>
                <td>
                  <?php if ($book->hide) {?>
                    <span class="blfa-check-mark">&check;</span>
                  <?php } ?>
                </td>
                <td>
                  <?php echo $book->slug; ?>
                </td>
                <td class="blfa-actions">
                  <a class="blfa-link" href="<?php echo getPageLink($book, $series_list); ?>">View Page</a><br />
                  <a class="blfa-edit" href="?page=blfa_plugin_books&book=<?php echo $book->id; ?>">Edit</a><br />
                  <a class="blfa-delete" href="#<?php echo $book->id; ?>">Delete</a>
                </td>
              </tr>
          <?php
            }
          ?>
          </tbody>
        </table>
        <div id="pager" class="pager">
          <form>
            <img src="<?php echo $asset_path; ?>img/beginning-nav.png" class="first"/>
            <img src="<?php echo $asset_path; ?>img/left-nav.png" class="prev"/>
            <!-- the "pagedisplay" can be any element, including an input -->
            <span class="pagedisplay" data-pager-output-filtered="{startRow:input} &ndash; {endRow} / {filteredRows} of {totalRows} total books"></span>
            <img src="<?php echo $asset_path; ?>img/right-nav.png" class="next"/>
            <img src="<?php echo $asset_path; ?>/img/end-nav.png" class="last"/>
            <select class="pagesize">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="40">40</option>
              <option value="all">All Rows</option>
            </select>
          </form>
        </div>
        <div class="spacer">
          &nbsp;
        </div>
        <a href="?page=blfa_plugin_books&book=new" class="page-title-action spinner-button" id="add-book-button-lower" name="add-book-button">Add Book</a>
      <?php } else { ?>
        <h2>
          You haven't added any books yet.
        </h2>
      <?php } ?>
        <form id="blfa-delete-book-form" method="post" action="options.php">
          <!-- Hidden Delete form -->
          <?php
            wp_nonce_field("blfa_cu_book", "blfa_cu_book_nonce");
            settings_fields('blfa_plugin_book');
          ?>
          <input id="blfa_book_id" name="blfa_plugin_book[blfa_book_id]" type="hidden" value="" />
        </form>
      </div>
    </div>
<?php } ?>
</div>

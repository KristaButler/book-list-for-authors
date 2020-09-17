var wp_media_frame;

function wpMediaUpload(event, target) {
  //Adapted from: https://codex.wordpress.org/Javascript_Reference/wp.media
  event.preventDefault();

  //If the media frame already exists, reopen it.
  if (!wp_media_frame) {
    //Create a new media frame
    wp_media_frame = wp.media({
      title: 'Select or Upload Cover Image',
      button: {
        text: 'Select Cover'
      },
      multiple: false //multiple files cannot be selected
    });

    //When an image is selected in the media frame...
    wp_media_frame.on('select', function(event) {
      // Get media attachment details from the frame state
        var attachment = wp_media_frame.state().get('selection').first().toJSON();

        // Send the attachment URL to our custom image input field.
        jQuery('#' + target + '-img').attr("src", attachment.url);

        // Send the attachment id to our hidden input
        jQuery('#' + target).attr("value", attachment.id);

        // Hide the add image link
        jQuery('#' + target + '-upload-link').hide();

        // Unhide the remove image link
        jQuery('#' + target + '-remove-link').show();
    });
  }

  wp_media_frame.open();
}

function wpMediaRemove(event, target, defaultImg) {
  // DELETE IMAGE LINK
  event.preventDefault();

  // Clear out the preview image
  jQuery('#' + target + '-img').attr("src", defaultImg);

  // Un-hide the add image link
  jQuery('#' + target + '-upload-link').show();

  // Hide the delete image link
  jQuery('#' + target + '-remove-link').hide();

  // Delete the image id from the hidden input
  jQuery('#' + target).attr("value", '');
}

function showSpinner() {
  jQuery('.blfa-spinner').show();
  jQuery('#blfa-admin-content').hide();
}

function loadBookData(json) {
  var data = json[0];

  if (parseInt(data['book_order']) < 0) {
    data['book_order'] = "";
  }

  if (parseInt(data['hide']) == 1) {
      jQuery('#blfa_book_hide').prop('checked', true);
  }

  jQuery('#blfa_book_id').attr('value', data['id']);
  jQuery('#blfa_book_title').attr('value', data['title']);
  jQuery('#blfa_book_subtitle').attr('value', data['subtitle']);
  jQuery('#blfa_book_desc').attr('value', data['description']);
  jQuery('#blfa_book_order').attr('value', data['book_order']);
  jQuery('#blfa_book_pubdate').attr('value', data['publication_date']);
  jQuery('#blfa_book_author').attr('value', data['author']);
  jQuery('#blfa_book_author_link').attr('value', data['author_url']);
  jQuery('#blfa_book_series').attr('value', data['series']);
  jQuery('#blfa_book_cover').attr('value', data['cover']);

  //Adapted from: https://wordpress.stackexchange.com/questions/181000/get-attachment-image-info-in-js
  wp.media.attachment(data['cover']).fetch().then(function (cover) {
    // preloading finished
    // after this you can use your attachment normally
    jQuery('#blfa_book_cover-img').attr('src', wp.media.attachment(data['cover']).get('url'));
  });

  //Copy retailer links into the approriate inputs.
  var links = JSON.parse(data['book_links']);

  jQuery.each(links, function(id, link) {
    jQuery('#' + id).val(link);
  });
}

function deleteBook(id) {
  if (window.confirm("Are you sure you want to delete this book? This action cannot be undone.")) {
    jQuery("#blfa_book_id").attr("value", "delete" + id);
    jQuery("#blfa-delete-book-form").submit();
  }
}

function clearInputFields() {
  jQuery('#blfa_book_title').attr('value', '');
  jQuery('#blfa_book_subtitle').attr('value', '');
  jQuery('#blfa_book_desc').attr('value', '');
  jQuery('#blfa_book_order').attr('value', '');
  jQuery('#blfa_book_pubdate').attr('value', '');
  jQuery('#blfa_book_author').attr('value', '');
  jQuery('#blfa_book_author_link').attr('value', '');
  jQuery('#blfa_book_series .default-selection').prop('selected', true);
  jQuery('#blfa_book_hide').prop('checked', false);

  jQuery('#blfa_book_links').attr('value', '');
  jQuery('.retailer_link').attr('value', '');

  jQuery('#blfa_book_cover').attr('value', '');
  jQuery('#blfa_book_cover-img').attr('src', jQuery('#default_cover_img').html());
  jQuery('#blfa_book_cover-upload-link').show();
  jQuery('#blfa_book_cover-remove-link').hide();
}

jQuery( document ).ready(function() {
  jQuery("#blfa-update-book-form").submit(function() {
    showSpinner();
    var list = "";
    var firstElement = true;

    jQuery('.retailer_link').each(function(index, element) {
      if (!firstElement) {
        list = list + ','
      } else {
          firstElement = false;
      }

      list = list + jQuery(element).attr('id') + '|' + jQuery(element).attr('value');
    });

    jQuery('#blfa_book_links').attr('value', list);
    return;
  });

  jQuery(".spinner-button").click(function(event) {
    showSpinner();
  });

  jQuery(".blfa-delete").each(function(index, element) {
    jQuery(element).click(function (event) {
      event.preventDefault();
      deleteBook(jQuery(element).attr("href").replace('#', ''));
    });
  });

  // The "Upload" link
  jQuery('#blfa_book_cover-upload-link').click(function(event) {
    wpMediaUpload(event, 'blfa_book_cover');
  });

  // The "Remove" link
  jQuery('#blfa_book_cover-remove-link').click(function(event) {
    var default_img = jQuery('#default_cover_img').html();
    wpMediaRemove(event, 'blfa_book_cover', default_img);
  });

  jQuery("#blfa-clear-button").click(function() {
    clearInputFields();
  });

  jQuery("#blfa_book_author-me").click(function(event) {
    jQuery('#blfa_book_author').attr('value', me.author);
  });

  jQuery("#blfa_book_author_link-me").click(function(event) {
    jQuery('#blfa_book_author_link').attr('value', me.website);
  });

  var pagerOptions = {
    container: jQuery(".pager"),
    output: '{startRow} - {endRow} / {filteredRows}',
    fixedHeight: true,
    removeRows: false,
    cssGoto: '.gotoPage'
  };
  jQuery("#blfa-book-list").tablesorter({
    widgets: ["filter"],
    dateFormat : "mm/dd/yyyy",
    filter_childRows : false,
    filter_childByColumn : false,
    filter_childWithSibs : true,
    filter_columnFilters : true,
    filter_columnAnyMatch: true,
    filter_cellFilter : '',
    filter_cssFilter : '', // or []
    filter_defaultFilter : {},
    filter_excludeFilter : {},
    filter_external : '',
    filter_filteredRow : 'filtered',
    filter_filterLabel : 'Filter "{{label}}" column by...',
    filter_formatter : null,
    filter_functions : null,
    filter_hideEmpty : true,
    filter_hideFilters : true,
    filter_ignoreCase : true,
    filter_liveSearch : true,
    filter_matchType : { 'input': 'exact', 'select': 'exact' },
    filter_onlyAvail : 'filter-onlyAvail',
    filter_placeholder : { search : '', select : '' },
    filter_reset : 'button.reset',
    filter_resetOnEsc : true,
    filter_saveFilters : true,
    filter_searchDelay : 300,
    filter_searchFiltered: true,
    filter_selectSource  : null,
    filter_serversideFiltering : false,
    filter_startsWith : false,
    filter_useParsedData : false,
    filter_defaultAttrib : 'data-value',
    filter_selectSourceSeparator : '|',
  }).tablesorterPager(pagerOptions);
});

function allowShow(element) {
  var allow = true;

  if (jQuery(element).hasClass('stay-hidden')) {
    allow = false;
  }

  return allow;
}

function showFields(selector, stayHidden) {
  jQuery(selector).each(function (index, element) {
    if (stayHidden || allowShow(element)) {
      jQuery(element).show();

      if (stayHidden) {
        jQuery(selector).removeClass('stay-hidden');
      }
    }
  });
}

function hideFields(selector, stayHidden) {
  jQuery(selector).hide();

  if (stayHidden) {
    jQuery(selector).addClass('stay-hidden');
  }
}

function toggleFieldsOnCheckbox(key, selector, stayHidden) {
  setTimeout(function() {
    var switchField = jQuery('#' + key);

    if (switchField.prop('checked')) {
      showFields(selector, stayHidden);
    } else {
      hideFields(selector, stayHidden);
    }
  }, 300);
}

function toggleFieldsOnChoice(key, check, selector, stayHidden) {
  setTimeout(function() {
    var value = jQuery('input.' + key + ':checked').attr('value');
    if(check == value) {
      showFields(selector, stayHidden);
    } else {
      hideFields(selector, stayHidden);
    }
  }, 300);
}

function refresh(showSelector, hideSelector) {
  if (hideSelector) {
    jQuery(hideSelector).hide();
  }

  if (showSelector) {
    jQuery(showSelector).show();
  }
}

function refreshIf(showSelector, hideSelector, check) {
  //Note: checked property seems to be returning opposite for my radio/img buttons so the logic in this function is a little funky.
  if(!jQuery(check).prop('checked')) {
    refresh(showSelector, hideSelector);
  } else {
    //Switch show hides
    refresh(hideSelector, showSelector);
  }
}

function listLayoutPicked(selector, centered, left, right, alternate, grid, featured) {
  var selected = jQuery(selector + ":checked").attr('value');
  var allString = grid + ", " + centered + ", " + left + ", " + right + ", " + alternate;

  if(featured) {
    allString = allString + ", " + featured;
  }

  //hide all
  refresh('', allString);

  //show selected
  switch(selected) {
    case 'centered':
      refresh(centered, '');
      break;
    case 'left':
      refresh(left, '');
      // code block
      break;
    case 'right':
      refresh(right, '');
      // code block
      break;
    case 'alternate':
      refresh(alternate, '');
      break;
    case 'featured':
      refresh(featured, '');
      break;
  }
}

function showBookNumberPicked(top, bottom, checkShow, checkPosition) {
  //Note: checked property seems to be returning oposite
  if(!jQuery(checkShow).prop('checked')) {
    //check on top
    refreshIf(bottom, top, checkPosition);
  } else {
    //hide both
    refresh('', top + ", " + bottom);
  }
}

function bookPageLayoutPicked() {
  var picked = jQuery('.blfa_bookpage_page_layout:checked').attr('value');

  jQuery('#book-page-preview-box').removeClass('bp-layout-centered bp-layout-left bp-layout-right');

  switch(picked) {
    case 'center':
      jQuery('#book-page-preview-box').addClass('bp-layout-centered');
      break;
    case 'left':
      jQuery('#book-page-preview-box').addClass('bp-layout-left');
      break;
    case 'right':
      jQuery('#book-page-preview-box').addClass('bp-layout-right');
      break;
  }
}

function setInitialStateAllBooksPreviewBox() {
  var layout = jQuery('.blfa_allbooks_page_layout:checked').attr('value');
  var coverSize = jQuery('.blfa_allbooks_cover_size:checked').attr('value');

  if (layout == 'list') {
    layout = jQuery('.blfa_allbooks_list_layout:checked').attr('value');
  }

  switch(layout) {
    case 'grid':
      refresh('#ab-grid', '#ab-list-c, #ab-list-l, #ab-list-r, #ab-list-a');
      break;
    case 'centered':
      refresh('#ab-list-c', '#ab-grid, #ab-list-l, #ab-list-r, #ab-list-a');
      break;
    case 'left':
      refresh('#ab-list-l', '#ab-grid, #ab-list-c, #ab-list-r, #ab-list-a');
      break;
    case 'right':
      refresh('#ab-list-r', '#ab-grid, #ab-list-c, #ab-list-l, #ab-list-a');
      break;
    case 'alternate':
      refresh('#ab-list-a', '#ab-grid, #ab-list-c, #ab-list-l, #ab-list-r');
      break;
  }

  switch(coverSize) {
    case 'small':
      refresh('.ab-small-cover', '.ab-medium-cover, .ab-large-cover');
      break;
    case 'medium':
      refresh('.ab-medium-cover', '.ab-small-cover, .ab-large-cover');
      break;
    case 'large':
      refresh('.ab-large-cover', '.ab-small-cover, .ab-medium-cover');
      break;
  }

  if (jQuery('#blfa_allbooks_include_number').prop('checked')) {
    refreshIf('.ab-book-number', '.ab-book-number-top', '#blfa_allbooks_number_top');
  } else {
    refresh('', '.ab-book-number, .ab-book-number-top');
  }

  refreshIf('', '.ab-book-title', '#blfa_allbooks_include_title');
  refreshIf('', '.ab-author', '#blfa_allbooks_include_author');
  refreshIf('', '.ab-description', '#blfa_allbooks_include_desc');
  refreshIf('', '.ab-buy-button', '#blfa_allbooks_include_buy_button');
}

function setInitialStateSeriesPagePreviewBox() {
  var layout = jQuery('.blfa_series_page_layout:checked').attr('value');
  var coverSize = jQuery('.blfa_series_cover_size:checked').attr('value');
  var fCoverSize = jQuery('.blfa_series_featured_cover_size:checked').attr('value');

  if (layout == 'list') {
    layout = jQuery('.blfa_series_list_layout:checked').attr('value');
  }

  switch(layout) {
    case 'grid':
      refresh('#sp-grid', '#sp-list-c, #sp-list-l, #sp-list-r, #sp-list-a, #sp-featured');
      break;
    case 'featured':
      refresh('#sp-featured', '#sp-grid, #sp-list-c, #sp-list-l, #sp-list-r, #sp-list-a');
      break;
    case 'centered':
      refresh('#sp-list-c', '#sp-grid, #sp-list-l, #sp-list-r, #sp-list-a, #sp-featured');
      break;
    case 'left':
      refresh('#sp-list-l', '#sp-grid, #sp-list-c, #sp-list-r, #sp-list-a, #sp-featured');
      break;
    case 'right':
      refresh('#sp-list-r', '#sp-grid, #sp-list-c, #sp-list-l, #sp-list-a, #sp-featured');
      break;
    case 'alternate':
      refresh('#sp-list-a', '#sp-grid, #sp-list-c, #sp-list-l, #sp-list-r, #sp-featured');
      break;
  }

  switch(coverSize) {
    case 'small':
      refresh('.sp-small-cover', '.sp-medium-cover, .sp-large-cover');
      break;
    case 'medium':
      refresh('.sp-medium-cover', '.sp-small-cover, .sp-large-cover');
      break;
    case 'large':
      refresh('.sp-large-cover', '.sp-small-cover, .sp-medium-cover');
      break;
  }

  switch(fCoverSize) {
    case 'medium':
      refresh('.spf-medium-cover', '.spf-exlarge-cover, .spf-large-cover');
      break;
    case 'large':
      refresh('.spf-large-cover', '.spf-exlarge-cover, .spf-medium-cover');
      break;
    case 'exlarge':
      refresh('.spf-exlarge-cover', '.spf-large-cover, .spf-medium-cover');
      break;
  }

  if (jQuery('#blfa_series_include_number').prop('checked')) {
    refreshIf('.sp-book-number', '.sp-book-number-top', '#blfa_series_number_top');
  } else {
    refresh('', '.sp-book-number, .sp-book-number-top');
  }

  refreshIf('', '.sp-book-title', '#blfa_series_include_title');
  refreshIf('', '.sp-author', '#blfa_series_include_author');
  refreshIf('', '.sp-description', '#blfa_series_include_desc');
  refreshIf('', '.sp-buy-button', '#blfa_series_include_buy_button');
}

function setInitialStateBookPagePreviewBox() {
  var coverSize = jQuery('.blfa_bookpage_cover_size:checked').attr('value');
  bookPageLayoutPicked();

  switch(coverSize) {
    case 'small':
      refresh('.bp-small-cover', '.bp-medium-cover, .bp-large-cover, .bp-exlarge-cover');
      break;
    case 'medium':
      refresh('.bp-medium-cover', '.bp-small-cover, .bp-large-cover, .bp-exlarge-cover');
      break;
    case 'large':
      refresh('.bp-large-cover', '.bp-small-cover, .bp-medium-cover, .bp-exlarge-cover');
      break;
    case 'exlarge':
      refresh('.bp-exlarge-cover', '.bp-small-cover, .bp-medium-cover, .bp-large-cover');
      break;
  }

  refreshIf('.bp-below-desc', '.bp-below-cover', '#blfa_bookpage_buy_button_location_below-cover');
  refreshIf('.bp-below-cover', '.bp-below-desc', '#blfa_bookpage_buy_button_location_below-desc');

  if (jQuery('#blfa_bookpage_include_number').prop('checked')) {
    refreshIf('.bp-book-number', '.bp-book-number-top', '#blfa_bookpage_number_top');
  } else {
    refresh('', '.bp-book-number, .bp-book-number-top');
  }

  refreshIf('', '.bp-author', '#blfa_bookpage_include_author');
  refreshIf('', '.bp-series-title', '#blfa_bookpage_include_series');
}

jQuery( document ).ready(function() {
  //Show/Hide Fields
  //Register Click Function
  jQuery('label[for="blfa_allbooks_include_page"]').click(function() {
    toggleFieldsOnCheckbox('blfa_allbooks_include_page', 'tr.blfa-allbooks, #all-books-preview-box', false);

    //note, I know the logic here looks backwards but it works
    if(!jQuery('#blfa_allbooks_include_page').prop('checked')) {
      toggleFieldsOnCheckbox('blfa_allbooks_include_number', '.blfa_allbooks_number_top', true);
    } else {
      hideFields('.blfa_allbooks_number_top', false);
    }
  });
  //Set Initial State
  toggleFieldsOnCheckbox('blfa_allbooks_include_page', 'tr.blfa-allbooks, #all-books-preview-box', false);

  //Register Click Function
  jQuery('label[for="blfa_seriespage_include_page"]').click(function() {
    toggleFieldsOnCheckbox('blfa_seriespage_include_page', 'tr.blfa-seriespage, #series-page-preview-box', false);

    //note, I know the logic here looks backwards but it works
    if(!jQuery('#blfa_seriespage_include_page').prop('checked')) {
      toggleFieldsOnCheckbox('blfa_series_include_number', '.blfa_series_number_top', true);
      toggleFieldsOnChoice('blfa_series_page_layout', 'list', 'tr.blfa_series_list_layout', true);
      toggleFieldsOnChoice('blfa_series_page_layout', 'featured', 'tr.blfa-featured', true);
    } else {
      hideFields('.blfa_series_number_top, tr.blfa-featured, tr.blfa_series_list_layout', false);
    }
  });
  //Set Initial State
  toggleFieldsOnCheckbox('blfa_seriespage_include_page', 'tr.blfa-seriespage, #series-page-preview-box', false);

  //Register Click Function
  jQuery('label[for="blfa_bookpage_include_page"]').click(function() {
    toggleFieldsOnCheckbox('blfa_bookpage_include_page', 'tr.blfa-bookpage, #book-page-preview-box', false);

    //note, I know the logic here looks backwards but it works
    if(!jQuery('#blfa_bookpage_include_page').prop('checked')) {
      toggleFieldsOnCheckbox('blfa_bookpage_include_number', '.blfa_bookpage_number_top', true);
      toggleFieldsOnCheckbox('blfa_bookpage_include_author', '.blfa_bookpage_link_author', true);
    } else {
      hideFields('.blfa_bookpage_number_top, .blfa_bookpage_link_author', false);
    }
  });
  //Set Initial State
  toggleFieldsOnCheckbox('blfa_bookpage_include_page', 'tr.blfa-bookpage, #book-page-preview-box', false);

  //Register Click Function
  jQuery('label[for="blfa_allbooks_include_number"]').click(function() {
    toggleFieldsOnCheckbox('blfa_allbooks_include_number', '.blfa_allbooks_number_top', true);

    //Preview Box
    showBookNumberPicked('.ab-book-number-top', '.ab-book-number', '#blfa_allbooks_include_number', '#blfa_allbooks_number_top');
  });
  if(jQuery('#blfa_allbooks_include_page').prop('checked')) {
    //Set Initial State, if parent toggle is selected
    toggleFieldsOnCheckbox('blfa_allbooks_include_number', '.blfa_allbooks_number_top', true);
  } else {
     //Else, hide child hideSelector
     hideFields('.blfa_allbooks_number_top', true);
  }

  //Register Click Function
  jQuery('label[for="blfa_series_include_number"]').click(function() {
    toggleFieldsOnCheckbox('blfa_series_include_number', '.blfa_series_number_top', true);

    //Preview Box
    showBookNumberPicked('.sp-book-number-top', '.sp-book-number', '#blfa_series_include_number', '#blfa_series_number_top');
  });
  if(jQuery('#blfa_seriespage_include_page').prop('checked')) {
    //Set Initial State, if parent toggle is selected
    toggleFieldsOnCheckbox('blfa_series_include_number', '.blfa_series_number_top', true);
  } else {
     //Else, hide child hideSelector
     hideFields('.blfa_series_number_top', true);
  }

  //Register Click Function
  jQuery('label[for="blfa_bookpage_include_number"]').click(function() {
    toggleFieldsOnCheckbox('blfa_bookpage_include_number', '.blfa_bookpage_number_top', true);

    //preview box
    showBookNumberPicked('.bp-book-number-top', '.bp-book-number', '#blfa_bookpage_include_number', '#blfa_bookpage_number_top');
  });
  if(jQuery('#blfa_bookpage_include_page').prop('checked')) {
    //Set Initial State, if parent toggle is selected
    toggleFieldsOnCheckbox('blfa_bookpage_include_number', '.blfa_bookpage_number_top', true);
  } else {
     //Else, hide child hideSelector
     hideFields('.blfa_bookpage_number_top', true);
  }

  //Register Click Function
  jQuery('label[for="blfa_bookpage_include_author"]').click(function() {
    toggleFieldsOnCheckbox('blfa_bookpage_include_author', '.blfa_bookpage_link_author', true);
  });
  if(jQuery('#blfa_bookpage_include_page').prop('checked')) {
    //Set Initial State
    toggleFieldsOnCheckbox('blfa_bookpage_include_author', '.blfa_bookpage_link_author', true);
  } else {
     //Else, hide child hideSelector
     hideFields('.blfa_bookpage_number_top', true);
  }

  //Register Click Function
  jQuery('label.blfa_allbooks_page_layout > img').click(function() {
    toggleFieldsOnChoice('blfa_allbooks_page_layout', 'list', 'tr.blfa_allbooks_list_layout', true);
  });
  //Set Initial State
  toggleFieldsOnChoice('blfa_allbooks_page_layout', 'list', 'tr.blfa_allbooks_list_layout', true);

  //Register Click Function
  jQuery('label.blfa_series_page_layout > img').click(function() {
    toggleFieldsOnChoice('blfa_series_page_layout', 'list', 'tr.blfa_series_list_layout', true);

    toggleFieldsOnChoice('blfa_series_page_layout', 'featured', 'tr.blfa-featured', true);
  });
  if(jQuery('#blfa_seriespage_include_page').prop('checked')) {
    //Set Initial State
    toggleFieldsOnChoice('blfa_series_page_layout', 'list', 'tr.blfa_series_list_layout', true);
    toggleFieldsOnChoice('blfa_series_page_layout', 'featured', 'tr.blfa-featured', true);
  } else {
    //Hide featured covers row if series page is not included
    hideFields('tr.blfa-featured', true);
  }
  //Preview Box
  //Register Click Function
  jQuery('#blfa_allbooks_page_layout_grid').click(function() {
    refresh('#ab-grid', '#ab-list-c, #ab-list-l, #ab-list-r, #ab-list-a');
  });

  //Register Click Function
  jQuery('#blfa_allbooks_list_layout_centered').click(function() {
    refresh('#ab-list-c', '#ab-grid, #ab-list-l, #ab-list-r, #ab-list-a');
  });

  //Register Click Function
  jQuery('#blfa_allbooks_list_layout_left').click(function() {
    refresh('#ab-list-l', '#ab-grid, #ab-list-c, #ab-list-r, #ab-list-a');
  });

  //Register Click Function
  jQuery('#blfa_allbooks_list_layout_right').click(function() {
    refresh('#ab-list-r', '#ab-grid, #ab-list-c, #ab-list-l, #ab-list-a');
  });

  //Register Click Function
  jQuery('#blfa_allbooks_list_layout_alternate').click(function() {
    refresh('#ab-list-a', '#ab-grid, #ab-list-c, #ab-list-l, #ab-list-r');
  });

  //Register Click Function
  jQuery('#blfa_allbooks_cover_size_small').click(function() {
    refresh('.ab-small-cover', '.ab-medium-cover, .ab-large-cover');
  });

  //Register Click Function
  jQuery('#blfa_allbooks_cover_size_medium').click(function() {
    refresh('.ab-medium-cover', '.ab-small-cover, .ab-large-cover');
  });

  //Register Click Function
  jQuery('#blfa_allbooks_cover_size_large').click(function() {
    refresh('.ab-large-cover', '.ab-small-cover, .ab-medium-cover');
  });

  //Register Click Function
  jQuery('label[for="blfa_allbooks_number_top"]').click(function () {
    refreshIf('.ab-book-number-top', '.ab-book-number', '#blfa_allbooks_number_top');
  });

  //Register Click Function
  jQuery('label[for="blfa_allbooks_include_title"]').click(function () {
    refreshIf('.ab-book-title', '', '#blfa_allbooks_include_title');
  });

  //Register Click Function
  jQuery('label[for="blfa_allbooks_include_author"]').click(function () {
    refreshIf('.ab-author', '', '#blfa_allbooks_include_author');
  });

  //Register Click Function
  jQuery('label[for="blfa_allbooks_include_desc"]').click(function () {
    refreshIf('.ab-description', '', '#blfa_allbooks_include_desc');
  });

  //Register Click Function
  jQuery('label[for="blfa_allbooks_include_buy_button"]').click(function () {
    refreshIf('.ab-buy-button', '', '#blfa_allbooks_include_buy_button');
  });

  //Register Click Function
  jQuery('#blfa_allbooks_page_layout_list').click(function () {
    listLayoutPicked('.blfa_allbooks_list_layout', '#ab-list-c', '#ab-list-l', '#ab-list-r', '#ab-list-a', '#ab-grid', null);
  });

  /*** SERIES PAGE PREVIEW ***/
  //Register Click Function
  jQuery('#blfa_series_page_layout_grid').click(function() {
    refresh('#sp-grid', '#sp-list-c, #sp-list-l, #sp-list-r, #sp-list-a, #sp-featured');
  });

  //Register Click Function
  jQuery('#blfa_series_page_layout_featured').click(function() {
    refresh('#sp-featured', '#sp-grid, #sp-list-c, #sp-list-l, #sp-list-r, #sp-list-a');
  });

  //Register Click Function
  jQuery('#blfa_series_list_layout_centered').click(function() {
    refresh('#sp-list-c', '#sp-grid, #sp-list-l, #sp-list-r, #sp-list-a, #sp-featured');
  });

  //Register Click Function
  jQuery('#blfa_series_list_layout_left').click(function() {
    refresh('#sp-list-l', '#sp-grid, #sp-list-c, #sp-list-r, #sp-list-a, #sp-featured');
  });

  //Register Click Function
  jQuery('#blfa_series_list_layout_right').click(function() {
    refresh('#sp-list-r', '#sp-grid, #sp-list-c, #sp-list-l, #sp-list-a, #sp-featured');
  });

  //Register Click Function
  jQuery('#blfa_series_list_layout_alternate').click(function() {
    refresh('#sp-list-a', '#sp-grid, #sp-list-c, #sp-list-l, #sp-list-r, #sp-featured');
  });

  //Register Click Function
  jQuery('#blfa_series_cover_size_small').click(function() {
    refresh('.sp-small-cover', '.sp-medium-cover, .sp-large-cover');
  });

  //Register Click Function
  jQuery('#blfa_series_cover_size_medium').click(function() {
    refresh('.sp-medium-cover', '.sp-small-cover, .sp-large-cover');
  });

  //Register Click Function
  jQuery('#blfa_series_cover_size_large').click(function() {
    refresh('.sp-large-cover', '.sp-small-cover, .sp-medium-cover');
  });

  //Register Click Function
  jQuery('label[for="blfa_series_number_top"]').click(function () {
    refreshIf('.sp-book-number-top', '.sp-book-number', '#blfa_series_number_top');
  });

  //Register Click Function
  jQuery('label[for="blfa_series_include_title"]').click(function () {
    refreshIf('.sp-book-title', '', '#blfa_series_include_title');
  });

  //Register Click Function
  jQuery('label[for="blfa_series_include_author"]').click(function () {
    refreshIf('.sp-author', '', '#blfa_series_include_author');
  });

  //Register Click Function
  jQuery('label[for="blfa_series_include_desc"]').click(function () {
    refreshIf('.sp-description', '', '#blfa_series_include_desc');
  });

  //Register Click Function
  jQuery('label[for="blfa_series_include_buy_button"]').click(function () {
    refreshIf('.sp-buy-button', '', '#blfa_series_include_buy_button');
  });

  //Register Click Function
  jQuery('#blfa_series_page_layout_list').click(function () {
    listLayoutPicked('.blfa_series_list_layout', '#sp-list-c', '#sp-list-l', '#sp-list-r', '#sp-list-a', '#sp-grid', '#sp-featured');
  });

  //Register Click Function
  jQuery('#blfa_series_featured_cover_size_medium').click(function() {
    refresh('.spf-medium-cover', '.spf-large-cover, .spf-exlarge-cover');
  });
  //Register Click Function
  jQuery('#blfa_series_featured_cover_size_large').click(function() {
    refresh('.spf-large-cover', '.spf-medium-cover, .spf-exlarge-cover');
  });
  //Register Click Function
  jQuery('#blfa_series_featured_cover_size_exlarge').click(function() {
    refresh('.spf-exlarge-cover', '.spf-medium-cover, .spf-large-cover');
  });

  /********** Book Page Preview Box ****************/
  //Register Click Function
  jQuery('#blfa_bookpage_cover_size_small').click(function() {
    refresh('.bp-small-cover', '.bp-medium-cover, .bp-large-cover', 'bp-exlarge-cover');
  });

  //Register Click Function
  jQuery('#blfa_bookpage_cover_size_medium').click(function() {
    refresh('.bp-medium-cover', '.bp-small-cover, .bp-large-cover', 'bp-exlarge-cover');
  });

  //Register Click Function
  jQuery('#blfa_bookpage_cover_size_large').click(function() {
    refresh('.bp-large-cover', '.bp-small-cover, .bp-medium-cover', 'bp-exlarge-cover');
  });

  //Register Click Function
  jQuery('#blfa_bookpage_cover_size_exlarge').click(function() {
    refresh('.bp-exlarge-cover', '.bp-small-cover, .bp-medium-cover, .bp-large-cover');
  });

  //Register Click Function
  jQuery('label[for="blfa_bookpage_number_top"]').click(function () {
    refreshIf('.bp-book-number-top', '.bp-book-number', '#blfa_bookpage_number_top');
  });

  //Register Click Function
  jQuery('label[for="blfa_bookpage_include_author"]').click(function () {
    refreshIf('.bp-author', '', '#blfa_bookpage_include_author');
  });

  //Register Click Function
  jQuery('label[for="blfa_bookpage_include_series"]').click(function () {
    refreshIf('.bp-series-title', '', '#blfa_bookpage_include_series');
  });

  //Register Click Function
  jQuery('#blfa_bookpage_buy_button_location_below-cover').click(function() {
    refreshIf('.bp-below-desc', '.bp-below-cover', '#blfa_bookpage_buy_button_location_below-cover');
  });

  //Register Click Function
  jQuery('#blfa_bookpage_buy_button_location_below-desc').click(function() {
    refreshIf('.bp-below-cover', '.bp-below-desc', '#blfa_bookpage_buy_button_location_below-desc');
  });

  jQuery('.blfa_bookpage_page_layout').click(function() {
    bookPageLayoutPicked();
  });

  //Add Submit function on form for showSpinner
  jQuery('#blfa-settings-form').submit(function() {
    jQuery('.blfa-spinner').show();
    jQuery('#blfa-admin-content').hide();
  });

  //Set Initial Preview Boxes State
  setInitialStateAllBooksPreviewBox();
  setInitialStateSeriesPagePreviewBox();
  setInitialStateBookPagePreviewBox();

  jQuery('.blfa-spinner').hide();
  jQuery('#blfa-admin-content').show();
});

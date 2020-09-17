var wp_media_frame;

function editRetailer(target) {
  //Copy the values of the selected Retailer into the Add/Edit form
  var name = jQuery(target).find(".blfa-retailer-name").html();
  var tag = jQuery(target).find(".blfa-retailer-tag").html();
  var img_url = jQuery(target).find("td.blfa-retailer-icon img").attr("src");
  var img_id = jQuery(target).find("td.blfa-retailer-icon span").html();
  var is_default = jQuery(target).find(".blfa-check-mark").length > 0;

  jQuery(".blfa-editing").removeClass("blfa-editing");

  jQuery("#blfa_retailer_id").attr("value", target.slice(1));
  jQuery("#blfa_default_retailer").attr("value", is_default);
  jQuery("#blfa_retailer_name").attr("value", name);
  jQuery("#blfa_affiliate_tag").attr("value", tag);
  jQuery("#blfa_retailer_icon-img").attr("src", img_url);
  jQuery("#blfa_retailer_icon").attr("value", img_id);
  jQuery(".blfa-media-img").show();

  jQuery("#blfa-retailers-admin-form h2").html("Edit Retailer");
  jQuery(target).addClass("blfa-editing");
}

function deleteRetailer(target) {
  jQuery(target).addClass("blfa-deleting");

  showSpinner();

  jQuery("#blfa_retailer_id").attr("value", "delete" + target.slice(1));
  jQuery("#submit").click();
}

function setDefaultRetailer(target) {
  showSpinner();

  editRetailer(target);
  jQuery("#blfa_default_retailer").attr("value", true);

  jQuery("#submit").click();
}

function wpMediaUpload(event, target) {
  //Adapted from: https://codex.wordpress.org/Javascript_Reference/wp.media
  event.preventDefault();

  //If the media frame already exists, reopen it.
  if (!wp_media_frame) {
    //Create a new media frame
    wp_media_frame = wp.media({
      title: 'Select or Upload Retailer Icon or Logo',
      button: {
        text: 'Select Image'
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

function clearInputFields() {
  jQuery(".blfa-editing").removeClass("blfa-editing");

  jQuery("#blfa_retailer_icon-img").attr("src", "");
  jQuery("#blfa_retailer_icon").attr("value", "");
  jQuery("#blfa_retailer_name").attr("value", "");
  jQuery("#blfa_affiliate_tag").attr("value", "");

  jQuery("#blfa-retailers-admin-form h2").html("Add New Retailer");

  // Hide the add image link
  jQuery('#' + target + '-upload-link').hide();

  // Unhide the remove image link
  jQuery('#' + target + '-remove-link').show();
}

jQuery( document ).ready(function() {
  jQuery(".blfa-edit").each(function (index, element) {
    jQuery(element).click(function () {
      editRetailer(jQuery(element).attr("href"));
    });
  });

  jQuery(".blfa-delete").each(function(index, element) {
    jQuery(element).click(function () {
      deleteRetailer(jQuery(element).attr("href"));
    });
  });

  jQuery(".blfa-default").each(function (index, element) {
    jQuery(element).click(function () {
      setDefaultRetailer(jQuery(element).attr("href"));
    });
  });

  // The "Upload" link
  jQuery('#blfa_retailer_icon-upload-link').click(function(event) {
    wpMediaUpload(event, 'blfa_retailer_icon');
  });

  // The "Remove" link
  jQuery('#blfa_retailer_icon-remove-link').click(function(event) {
    var default_img = jQuery('#default_retailer_img').html();
    wpMediaRemove(event, 'blfa_retailer_icon', default_img);
  });

  jQuery("#blfa-clear-button").click(function() {
    clearInputFields();
  });

  jQuery("#blfa-retailers-admin-form").submit(function() {
    showSpinner();
  });

  jQuery("#retailers-list-table").tablesorter({
    dateFormat : "mm/dd/yyyy"
  });

  jQuery('.blfa-spinner').hide();
  jQuery('#blfa-admin-content').show();
});

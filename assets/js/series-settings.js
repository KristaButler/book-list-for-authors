function editSeries(target) {
  //Copy the values of the selected series into the Add/Edit form
  var title = jQuery(target).find(".blfa-series-title").html();
  var shared = jQuery(target).find(".blfa-check-mark").length > 0;

  jQuery(".blfa-editing").removeClass("blfa-editing");

  jQuery("#blfa_series_id").attr("value", target.slice(1));
  jQuery("#blfa_series_title").attr("value", title);
  jQuery("#blfa_shared_series").prop("checked", shared);

  jQuery("#blfa-series-admin-form h2").html("Edit Series");
  jQuery(target).addClass("blfa-editing");
}

function deleteSeries(target) {
  jQuery(target).addClass("blfa-deleting");

  showSpinner();

  jQuery("#blfa_series_id").attr("value", "delete" + target.slice(1));
  jQuery("#submit").click();
}

function clearInputFields() {
  jQuery(".blfa-editing").removeClass("blfa-editing");

  jQuery("#blfa_series_id").attr("value", "");
  jQuery("#blfa_series_title").attr("value", "");
  jQuery("#blfa_shared_series").prop("checked", false);

  jQuery("#blfa-series-admin-form h2").html("Add New Series");
}

function showSpinner() {
  jQuery('.blfa-spinner').show();
  jQuery('#blfa-admin-content').hide();
}

jQuery( document ).ready(function() {
  jQuery(".blfa-edit").each(function (index, element) {
    jQuery(element).click(function () {
      editSeries(jQuery(element).attr("href"));
    });
  });

  jQuery(".blfa-delete").each(function(index, element) {
    jQuery(element).click(function () {
      deleteSeries(jQuery(element).attr("href"));
    });
  });

  jQuery("#blfa-clear-button").click(function() {
    clearInputFields();
  });

  jQuery("#blfa-series-admin-form").submit(function() {
    showSpinner();
  });

  jQuery("#series-list-table").tablesorter({
    dateFormat : "mm/dd/yyyy"
  });
});

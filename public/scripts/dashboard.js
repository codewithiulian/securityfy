// Execute script on DOM fully loaded (document ready).
$(function ($) {
  // Initialise the Dashboard.
  initDashboard($);
});

/**
 * Function that initialises the Dashboard. 
 */
function initDashboard($) {
  // Store the url and app roots from the hidden fields.
  let urlRoot = $('#urlRoot').val();
  let appRoot = $('#appRoot').val();
  let requestURL = urlRoot + "/pages/dashboard";

  var requestData = { request: 'dashboard_request_data' };
  var data = {};
  $.get(
    requestURL,
    requestData,
    function (_data, status) {
      data = _data;
      buildTable(data, $, urlRoot);
    });
};

function buildTable(data, $, urlRoot) {
  // Get 2D array from object.
  var items = getTableItems(data, urlRoot);

  var itemsTable = $('#itemsTable').DataTable({
    "data": items, // Load the items into the data table.
    dom: 'Bfrtip',
    buttons: [
      'pageLength', 'excel', 'print', 'colvis'
    ],
    responsive: true,
    "order": [[1, "desc"]] // Order by date descending.
  });

  itemsTable.buttons().container()
    .appendTo('#itemsTable_wrapper .col-md-6:eq(0)');
}

function getTableItems(data, urlRoot) {
  // Parse data into JSON format.
  var parsedData = JSON.parse(data);
  var items = [];
  for (var i = 0; i < parsedData.items.length; i++) {
    var item_raw = parsedData.items[i];
    var title = "<a target='blank' href='" + urlRoot + "/items/show?item=" + item_raw.itemId + "'>" + item_raw.itemTitle + "</a>";
    var item = [
      title,                // Title
      item_raw.itemDate,    // Date
      item_raw.itemType,    // Type
      item_raw.itemAuthor,  // Author
    ];
    items.push(item);
  }
  return items;
}

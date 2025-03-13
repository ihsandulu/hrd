$(document).ready(function () {
  $("#myTable").DataTable();
  $(document).ready(function () {
    var table = $("#example").DataTable({
      columnDefs: [
        {
          visible: false,
          targets: 2,
        },
      ],
      order: [[2, "asc"]],
      displayLength: 25,
      drawCallback: function (settings) {
        var api = this.api();
        var rows = api
          .rows({
            page: "current",
          })
          .nodes();
        var last = null;
        api
          .column(2, {
            page: "current",
          })
          .data()
          .each(function (group, i) {
            if (last !== group) {
              $(rows)
                .eq(i)
                .before(
                  '<tr class="group"><td colspan="5">' + group + "</td></tr>"
                );
              last = group;
            }
          });
      },
    });
    // Order by the grouping
    $("#example tbody").on("click", "tr.group", function () {
      var currentOrder = table.order()[0];
      if (currentOrder[0] === 2 && currentOrder[1] === "asc") {
        table.order([2, "desc"]).draw();
      } else {
        table.order([2, "asc"]).draw();
      }
    });
  });
});
$("#example23").DataTable({
  order: [
    [1, "asc"],
    [2, "asc"],
  ],
  dom: "Bfrtip",
  buttons: [
    "copy",
    "csv",
    {
      extend: "excel",
      exportOptions: {
        columns: ":visible",
        format: {
          body: function (data, row, column, node) {
            return column === 0 ? "" : data.replace(/[\,]/g, "");
          },
        },
      },
    },
    "pdf",
    "print",
  ],
});
$("#example231").DataTable({
  dom: "Bfrtip",
  buttons: ["copy", "csv", "excel", "pdf", "print"],
});

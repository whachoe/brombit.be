/**
 * Created by cjpa on 26/06/2017.
 */
var $ = require('jquery');
require('bootstrap-sass');

$(function() {
  $(document).on('click', 'a.sortable, a.asc, a.desc, ul.pagination li a', function (e) {
    e.preventDefault();
    var clicked = $(this);
    $.get(clicked.attr('href'), [], function (data, status, jqXHR) {
      clicked.closest("div.container-fluid").html(data);
    });
  });

  $("#balances_body").load('/balances');
  $("#participants_body").load('/participants');
  $("#transactions_body").load('/transactions');
});
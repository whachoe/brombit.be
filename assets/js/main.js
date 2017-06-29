/**
 * Created by cjpa on 26/06/2017.
 */
var $ = require('jquery');
require('bootstrap-sass');

function initHandlers(el)
{
  $('a.sortable, ul.pagination li a').on("click", function () {
    $.get($(this).attr('href'), [], function (data, status, jqXHR) {
      $(el).html(data);
      jqXHR.always(function () {
        initHandlers(el);
      });
    });

    return false;
  });
}

$(document).ready(function() {
  $.get('/balances', [], function (data, status, jqXHR) {
    $("#balances_tbody").html(data);
    jqXHR.always(function () {
      initHandlers($("#balances_tbody"));
    });
  });

  $.get('/participants', [], function (data, status, jqXHR) {
    $("#participants_tbody").html(data);
    jqXHR.always(function () {
      initHandlers($("#participants_tbody"));
    });
  });

  $.get('/transactions', [], function (data, status, jqXHR) {
    $("#transactions_body").html(data);
    jqXHR.always(function () {
      initHandlers($("#transactions_body"));
    });
  });

});
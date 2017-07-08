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

  $("#balances_body").load('/balances?sort=b.balanceDate&direction=desc&page=1');
  $("#participants_body").load('/participants');
  $("#transactions_body").load('/transactions?sort=t.transactionDate&direction=desc&page=1');

  $("#calculator_from_value, #calculator_from_currency, #calculator_to_currency").on('change', function () {
    $("#calculator_to_value").val(calculatePrice(
      $("#calculator_from_currency").val(),
      $("#calculator_from_value").val(),
      $("#calculator_to_currency").val(),
      prices));
  });
});

function calculatePrice(fromCurrency, fromValue, toCurrency, pricelist)
{
  return fromValue * pricelist.RAW[fromCurrency][toCurrency]["PRICE"];
}
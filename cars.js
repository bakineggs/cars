$(document).ready(function() {
  $('#cars').tablesorter({ sortList: [ [0,0] ] });
  $('#add h2').remove();
  $('#add').dialog({title: 'Add Car', height: $('#add').height()+60}).dialogClose();
  $('body')
    .append($(document.createElement('h2'))
      .append($(document.createElement('a'))
        .addClass('plus_button')
        .attr('id', 'add_link')
        .html('Add Car')));
  $('#add_link').click(function() {
    $('#add').dialogOpen();
  });
  $('#add_form').submit(function() {
    $('#add_form input[type=submit]').attr('disabled','disabled');
    $.ajax({
      type: 'POST',
      url: 'add.php',
      data: {
        'js': 'true',
        'price': $('#add form input[name=price]').val(),
        'make': $('#add form input[name=make]').val(),
        'model': $('#add form input[name=model]').val(),
        'year': $('#add form input[name=year]').val(),
        'mileage': $('#add form input[name=mileage]').val(),
        'vin': $('#add form input[name=vin]').val(),
        'uri': $('#add form input[name=uri]').val(),
        'dealer': $('#add form input[name=dealer]').val()
      },
      success: function(data) {
        row = $(document.createElement('tr'));
        fillRow(row, data);
        $('#cars tbody').append(row);
        $('#cars tbody tr:last-child').fadeIn();
        $('#add_form input[type=submit]').attr('disabled','');
        $('#add').dialogClose();
        return false;
      }
    });
    return false;
  });
  $.each($('.plus_button'), function(i, el) {
    contents = $(el).html();
    $(el)
      .html('')
      .removeClass('plus_button')
      .addClass('real_plus_button')
      .append($(document.createElement('div'))
        .addClass('top_left')
        .append($(document.createElement('div'))
          .addClass('top_right')
          .append($(document.createElement('div'))
            .addClass('bottom_left')
            .append($(document.createElement('div'))
              .addClass('bottom_right')
              .append($(document.createElement('div'))
                .addClass('plus')
                .html(contents))))));
  });
  $('.delete_form input[type=image]').livequery('mouseover', function() {
    $(this).attr('src','images/delete-hover.png');
  });
  $('.delete_form input[type=image]').livequery('mouseout', function() {
    $(this).attr('src','images/delete.png');
  });
  $('.delete_form').livequery('submit', function() {
    if (confirm('Are you sure you want to remove this car?')) {
      form = $(this);
      $.ajax({
        type: 'POST',
        url: 'delete.php',
        data: {
          'js': 'true',
          'id': form.children('p').children('input[name=id]').val()
        },
        success: function(data) {
          eval('data = '+data);
          if (data['deleted'])
            form.parent().parent().fadeOut();
          return false;
        }
      });
    }
    return false;
  });
  $('#cars .price').livequery(function() { addEditLink(this) });
  $('#cars .make').livequery(function() { addEditLink(this) });
  $('#cars .model').livequery(function() { addEditLink(this) });
  $('#cars .year').livequery(function() { addEditLink(this) });
  $('#cars .mileage').livequery(function() { addEditLink(this) });
  $('#cars .vin').livequery(function() { addEditLink(this) });
  $('#cars .dealer').livequery(function() { addEditLink(this) });
  $('#cars td.edit').livequery(function() { $(this).remove(); });
});
function fillRow(row, data)
{
  eval('data = '+data);
  row.children().remove();
  if (data['carfax'])
    vinrow = $(document.createElement('td')).addClass('vin')
      .append($(document.createElement('a'))
        .attr('href', 'carfax/'+data['vin']+'.html')
        .html(data['vin']));
  else
    vinrow = $(document.createElement('td')).addClass('vin').html(data['vin']);
  row.attr('id', data['id'])
    .append($(document.createElement('td')).addClass('price').html(data['price']))
    .append($(document.createElement('td')).addClass('make').html(data['make']))
    .append($(document.createElement('td')).addClass('model').html(data['model']))
    .append($(document.createElement('td')).addClass('year').html(data['year']))
    .append($(document.createElement('td')).addClass('mileage').html(data['mileage']))
    .append(vinrow)
    .append($(document.createElement('td')).addClass('dealer').append($(document.createElement('a'))
      .attr('href', data['uri'])
      .html(data['dealer'])))
    .append($(document.createElement('td')).addClass('edit')
      .append($(document.createElement('a'))
        .attr('href', 'edit.php?id='+data['id'])
        .append($(document.createElement('img'))
          .attr('src', 'images/edit.png')
          .attr('alt', 'Edit'))))
    .append($(document.createElement('td')).addClass('delete').append($(document.createElement('form'))
      .attr('method', 'post')
      .attr('action', 'delete.php')
      .addClass('delete_form')
      .append($(document.createElement('p'))
        .append($(document.createElement('input'))
          .attr('type', 'hidden')
          .attr('name', 'id')
          .val(data['id']))
        .append($(document.createElement('input'))
          .attr('type', 'image')
          .attr('src', 'images/delete.png')
          .attr('alt', 'Delete')
          .val('Delete')))));
}
function addEditLink(cell)
{
  $(cell).prepend($(document.createElement('img'))
    .attr('src', 'images/edit.png')
    .addClass('edit')
    .click(function() {
      editCell($(cell));
    }));
}
function editCell(cell)
{
  cell.parent().children().children('img.edit').remove();
  tdClass = cell.attr('class');
  switch(tdClass)
  {
    case 'price':
    case 'make':
    case 'model':
    case 'year':
    case 'mileage':
      value = cell.html();
      textbox = $(document.createElement('input'))
        .attr('type', 'text')
        .attr('name', tdClass)
        .val(value);
      cell
        .html('')
        .append(textbox)
        .append($(document.createElement('input'))
          .attr('type', 'button')
          .attr('value', 'Save')
          .click(function() {
            params = {};
            params[textbox.attr('name')] = textbox.val();
            saveRow(cell.parent(), params);
          }));
      break;
    case 'vin':
      children = cell.children();
      value = children.length>0 ? children.html() : cell.html();
      textbox = $(document.createElement('input'))
        .attr('type', 'text')
        .attr('name', tdClass)
        .val(value);
      cell
        .html('')
        .append(textbox)
        .append($(document.createElement('input'))
          .attr('type', 'button')
          .attr('value', 'Save')
          .click(function() {
            params = {};
            params[textbox.attr('name')] = textbox.val();
            saveRow(cell.parent(), params);
          }));
      break;
    case 'dealer':
      uri = cell.children().attr('href');
      dealer = cell.children().html();
      uribox = $(document.createElement('input'))
        .attr('type', 'text')
        .val(uri);
      dealerbox = $(document.createElement('input'))
        .attr('type', 'text')
        .val(dealer);
      cell
        .html('')
        .append($(document.createElement('span')).html('Website: '))
        .append(uribox)
        .append($(document.createElement('br')))
        .append($(document.createElement('span')).html('Dealer: '))
        .append(dealerbox)
        .append($(document.createElement('input'))
          .attr('type', 'button')
          .attr('value', 'Save')
          .click(function() {
            saveRow(cell.parent(), { uri: uribox.val(), dealer: dealerbox.val() });
          }));
      break;
  }
}
function saveRow(row, values)
{
  data = $.extend({
    'js': true,
    'price': row.children('.price').html(),
    'make': row.children('.make').html(),
    'model': row.children('.model').html(),
    'year': row.children('.year').html(),
    'mileage': row.children('.mileage').html(),
    'vin': row.children('.vin').children().length>0 ? row.children('.vin').children().html() : row.children('.vin').html(),
    'dealer': row.children('.dealer').children().html(),
    'uri': row.children('.dealer').children().attr('href')
  },values);
  $.ajax({
    type: 'POST',
    url: 'edit.php?id='+row.attr('id'),
    data: data,
    success: function(data) {
      fillRow(row, data);
    }
  });
}
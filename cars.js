$(document).ready(function() {
  $('#cars').tablesorter();
  $('#add h2').remove();
  $('#add').dialog({title: 'Add Car', height: $('#add').height()+60}).dialogClose();
  $('#add_link_container').css('display', 'block');
  $('#add_link').click(function() {
    $('#add').dialogOpen();
  });
  $('#add_form').submit(function() {
    $('#add_form input[type=submit]').attr('disabled','disabled');
    $.ajax({
      type: 'POST',
      url: 'add.php',
      data: {
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
        row.append($(document.createElement('td')).html(data['price']));
        row.append($(document.createElement('td')).html(data['make']));
        row.append($(document.createElement('td')).html(data['model']));
        row.append($(document.createElement('td')).html(data['year']));
        row.append($(document.createElement('td')).html(data['mileage']));
        if (data['carfax'])
        {
          anchor = $(document.createElement('a'));
          anchor.attr('href', 'carfax/'+data['vin']+'.html');
          anchor.html(data['vin']);
          row.append($(document.createElement('td')).append(anchor));
        }
        else
          row.append($(document.createElement('td')).html(data['vin']));
        anchor = $(document.createElement('a'));
        anchor.attr('href', data['uri']);
        anchor.html(data['dealer']);
        row.append($(document.createElement('td')).append(anchor));
        $('#cars tbody').append(row);
        $('#add_form input[type=submit]').attr('disabled','');
        $('#add').dialogClose();
      }
    });
  });
  $.each($('.plus_button'), function(i, el) {
    contents = $(el).html();
    $(el).html('').removeClass('plus_button').addClass('real_plus_button').append($(document.createElement('span')).addClass('top_right').append($(document.createElement('span')).addClass('bottom_left').append($(document.createElement('span')).addClass('bottom_right').append($(document.createElement('span')).addClass('plus').html(contents)))));
  });
});
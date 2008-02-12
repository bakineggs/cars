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
        eval('data = '+data);
        if (data['carfax'])
          vinrow = $(document.createElement('td'))
            .append($(document.createElement('a'))
              .attr('href', 'carfax/'+data['vin']+'.html')
              .html(data['vin']));
        else
          vinrow = $(document.createElement('td')).html(data['vin']);
        $('#cars tbody').append($(document.createElement('tr'))
          .append($(document.createElement('td')).html(data['price']))
          .append($(document.createElement('td')).html(data['make']))
          .append($(document.createElement('td')).html(data['model']))
          .append($(document.createElement('td')).html(data['year']))
          .append($(document.createElement('td')).html(data['mileage']))
          .append(vinrow)
          .append($(document.createElement('td')).append($(document.createElement('a'))
            .attr('href', data['uri'])
            .html(data['dealer'])))
          .append($(document.createElement('td')).append($(document.createElement('form'))
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
                .attr('src', 'i/dialog-titlebar-close.png')
                .attr('alt', 'Delete')
                .val('Delete'))))));
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
    $(this).attr('src','i/dialog-titlebar-close-hover.png');
  });
  $('.delete_form input[type=image]').livequery('mouseout', function() {
    $(this).attr('src','i/dialog-titlebar-close.png');
  });
  $('.delete_form').livequery('submit', function() {
    if (confirm('Are you sure you want to remove this car?')) {
      form = $(this);
      $.ajax({
        type: 'POST',
        url: 'delete.php',
        data: {
          'js': 'true',
          'id': form.children('input[name=id]').val()
        },
        success: function(data) {
          eval('data = '+data);
          if (data['deleted'])
            form.parent().parent().remove();
          return false;
        }
      });
    }
    return false;
  });
});
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
        form = $(document.createElement('form'));
        form.attr('method', 'post');
        form.attr('action', 'delete.php');
        form.addClass('delete_form');
        input = $(document.createElement('input'));
        input.attr('type', 'hidden');
        input.attr('name', 'id');
        input.val(data['id']);
        form.append(input);
        input = $(document.createElement('input'));
        input.attr('type', 'image');
        input.attr('src', 'i/dialog-titlebar-close.png');
        input.attr('alt', 'Delete');
        input.val('Delete');
        form.append(input);
        row.append($(document.createElement('td')).append(form));
        $('#cars tbody').append(row);
        $('#add_form input[type=submit]').attr('disabled','');
        $('#add').dialogClose();
        return false;
      }
    });
    return false;
  });
  $.each($('.plus_button'), function(i, el) {
    contents = $(el).html();
    $(el).html('').removeClass('plus_button').addClass('real_plus_button').append($(document.createElement('div')).addClass('top_left').append($(document.createElement('div')).addClass('top_right').append($(document.createElement('div')).addClass('bottom_left').append($(document.createElement('div')).addClass('bottom_right').append($(document.createElement('div')).addClass('plus').html(contents))))));
  });
  $('.delete_form input[type=image]').livequery('mouseover', function() {
    $(this).attr('src','i/dialog-titlebar-close-hover.png');
  });
  $('.delete_form input[type=image]').livequery('mouseout', function() {
    $(this).attr('src','i/dialog-titlebar-close.png');
  });
  $('.delete_form').livequery('submit', function() {
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
    return false;
  });
});
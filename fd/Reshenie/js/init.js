var url = 'ajax.php';


function jsCheck(){
    if($('#page-reload').prop('checked')){
        return true;
    }
    return false;
}

function saveNote(){
    $('#save-button').on('click', function(){
        if(!jsCheck()){
            return true;
        }

        var obj = $(this);
        var id = $('#pKey').val();
        var text = $('#text').val();
        data = {
            'text' : text,
            'id': id,
            'action': 'save'
        };
        if(text.trim()) {
            $.post(url, data, function (data) {
                if (id) {
                    $('.note-text').each(function () {
                        if ($(this).attr('data-id') == id) {
                            $(this).html(text);
                        }
                    });
                } else {
                    var string = '';
                    for (var i in data) {
                        string += '<div class="row m-top">' +
                        '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 note-text" data-id="' +
                        data[i]['id'] + '">' + data[i]['text'] + '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: right">' +
                        '<a href="index.php?action=edit&id=' + data[i]['id'] + '" ' +
                        'class="btn btn-primary edit-button" data-id="' + data[i]['id'] + '">Edit</a> ' +
                        '<a href="index.php?action=delete&id=' + data[i]['id'] + '" ' +
                        'class="btn btn-danger delete-button" data-id="' + data[i]['id'] + '">Delete</a>' +
                        '</div></div>';
                    }
                    $('#notes').html(string);
                    deleteNote();
                    editNote();
                }

                $('#text').val('');
                $('#pKey').val('');
            }, 'json');
        }
        return false;
    });
}

function editNote(){
    $('.edit-button').on('click', function(){
        if(!jsCheck()){
            return true;
        }
        $('#text').val($(this).closest('.row').children('.note-text').html().trim());
        $('#pKey').val($(this).attr('data-id'));
        $(document).scrollTop(0);
        return false;
    });
}

function deleteNote(){
    $('.delete-button').on('click', function(){
        if(!jsCheck()){
            return true;
        }

        data = {
            'id':$(this).attr('data-id'),
            'action': 'delete'
        };
        $.post(url, data, function(){}, 'json');
        $(this).closest('.row').remove();
        return false;
    });
}
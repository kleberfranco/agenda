$(function() {
    $('#btn-new-contact').click(function () {
        $.ajax({
            url: 'http://example.com/',
            type: 'POST',
            data: $('#myform').serializeArray(),
            success: function() { alert('PUT completed'); }
        });
    });
});


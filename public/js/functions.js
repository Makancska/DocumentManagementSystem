    function showErrorMessage(message)
    {
        $('#messages').show();
        $('#messages').html(message);
        $('#messages').removeClass('alert-success');
        $('#messages').addClass('alert-danger');

        setTimeout(function() {
            $('#messages').hide();
        }, 5000);
    }

    function showSuccessMessage(message)
    {
        $('#messages').show();
        $('#messages').html(message);
        $('#messages').removeClass('alert-danger');
        $('#messages').addClass('alert-success');

        setTimeout(function() {
            $('#messages').hide();
        }, 5000);
    }
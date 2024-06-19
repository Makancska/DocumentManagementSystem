$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#permission').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: "/permission",
            type: "POST",
            data: {
                category_id: $('#jstree').attr('data-categoryId'),
                can_download: Number($('#permissionDownload').is(':checked')),
                can_upload: Number($('#permissionUpload').is(':checked'))
            },
            success: function() {
                $('#permissionModal').modal('hide');
            }
        });
    });

    $('#permissionModal').on('show.bs.modal', function () {

        var categoryId = $('#jstree').attr('data-categoryId');

        $.ajax({
            url: '/permission/' + categoryId,
            type: 'GET',
            success: function(resp) {
                if (resp.permission !== null) {
                    $('#permissionDownload').prop('checked', resp.permission["can_download"]);
                    $('#permissionUpload').prop('checked', resp.permission["can_upload"]);
                } else {
                    $('#permissionDownload').prop('checked', false);
                    $('#permissionUpload').prop('checked', false);
                }
            },
        });
    });

});

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#save-document').on('click', function(event) {
        event.preventDefault();

        var formData = new FormData();
        formData.append('name', $('#docName').val());
        formData.append('category_id', $('#jstree').attr('data-categoryId'));
        formData.append('file', $('#file')[0].files[0]);

        $.ajax({
            url: "/upload",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(resp) {
                var resp = JSON.parse(resp);
                var list = document.getElementById('file-list');
                var downloadUrl = '/categories/' +  resp.document["category_id"] + '/download/' + resp.document["id"];
                var fileHtml = '<li class="list-group-item"><a href="' + downloadUrl + '">' + resp.document["name"] + '</a></li>';

                $('#docName').val('');
                $('#file').val('');
                $('#fileUploadModal').modal('hide');
                if (list) {
                    $('#file-list').append(fileHtml);
                } else {
                    $('#documentList').html('<ul id="file-list" class="list-group">' + fileHtml + '</ul>');
                }
                showSuccessMessage("Sikeres feltöltés.");
            },
            error: function(resp) {
                $('#docName').val('');
                $('#file').val('');
                $('#fileUploadModal').modal('hide');
                if (resp.status === 403) {
                    showErrorMessage('Nincs feltöltési jogosultságod új fájl feltöltéséhez.');
                } else {
                    showErrorMessage('Hiba történt a fájl feltöltése során.');
                }
            }
        });
    });

});

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#createCatButton').on('click', function() {
        $('#jstree').attr('data-categoryId', null);
    });

    // Create
    $('#save-category').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: "/store",
            type: "POST",
            data: {
                name: $('#name').val(),
                parent_id: $('#jstree').attr('data-categoryId')
            },
            success: function(resp){
                var resp = JSON.parse(resp);
                var nodeId = resp.category["parent_id"] === undefined ? '#' : resp.category["parent_id"];

                $('#name').val('');
                $('#createCategoryModal').modal('hide');

                $('#jstree').jstree(true).create_node(nodeId, {
                    id: resp.category["id"],
                    parent: nodeId,
                    text: resp.category["name"]
                }, 'last', function() {
                    var jstreeInstance = $('#jstree').jstree(true);
                    var parentNode = jstreeInstance.get_node(nodeId);
                    if (parentNode) {
                        $('#jstree').jstree(true).open_node(parentNode);
                    }
                });
                showSuccessMessage('Sikeres létrehozás.');
            },
            error: function(resp) {
                $('#name').val('');
                $('#createCategoryModal').modal('hide');
                if (resp.status === 403) {
                    showErrorMessage('Nincs feltöltési jogosultságod új kategória létrehozásához.')
                } else {
                    showErrorMessage('Hiba történt a kategória létrehozása során.')
                }
            }
        });
    });

    // Rename
    $('#rename-category').on('click', function(event) {
        event.preventDefault();

        var categoryId = $('#jstree').attr('data-categoryId');

        $.ajax({
            url: "/categories/" + categoryId,
            type: "PUT",
            data: {
                name: $('#rename-name').val()
            },
            success: function(resp) {
                var resp = JSON.parse(resp);
                $('#rename-name').val('');
                $('#renameCategoryModal').modal('hide');
                $('#jstree').jstree(true).set_text(categoryId, resp.category["name"]);
                showSuccessMessage('Sikeres létrehozás.');
            },
            error: function() {
                $('#rename-name').val('');
                $('#renameCategoryModal').modal('hide');
                showErrorMessage('Hiba történt az átnevezés során.')
            }
        });
    });

    //Delete
    $('#delete-category').on('click', function(event) {
        event.preventDefault();

        var categoryId = $('#jstree').attr('data-categoryId');

        $.ajax({
            url: "/categories/" + categoryId,
            type: "DELETE",
            success: function(resp){
                $('#deleteCategoryModal').modal('hide');
                $('#documentList').empty();
                $('#jstree').jstree('delete_node', resp.id);
                showSuccessMessage('Sikeres törlés.');
            },
            error: function(resp) {
                $('#deleteCategoryModal').modal('hide');
                if (resp.status === 403) {
                    showErrorMessage('Nincs feltöltési jogosultságod kategória törléséhez.');
                } else {
                    showErrorMessage('Hiba történt a kategória törlése során.');
                }
            }
        });
    });

    // Select folder
    $('#jstree').on('select_node.jstree', function (e, data) {

        $('#catName').html(data.node.text);
        $('#jstree').attr('data-categoryId', data.node.id);

        var categoryId = $('#jstree').attr('data-categoryId');
        var downloadUrl = '/categories/' + categoryId + '/download/';

        $.ajax({
            url: "/getFilesByCategory",
            type: "GET",
            data: { categoryId: categoryId },
            success: function(resp) {
                if (resp.files.length > 0) {
                    var fileHtml = '<ul id="file-list" class="list-group">';
                    $.each(resp.files, function(index, file) {
                        fileHtml += '<li class="list-group-item"><a href="' + downloadUrl + file.id +'">' + file.name + '</a></li>';
                    });
                    fileHtml += '</ul>';

                    $('#documentList').html(fileHtml);
                } else {
                    $('#documentList').html('<p>Nincsenek fájlok ebben a kategóriában.</p>');
                }
            },
            error: function() {
                showErrorMessage('Hiba történt a fájlok betöltése során.');
            }
        });
    });

    // jsTree setting
    $.ajax({
        type: 'GET',
        url: '/categories',
        dataType: 'json',
        success: function(data) {
            $('#jstree').jstree({
                'core': {
                    'data': data.map(function(category) {
                        return {
                            'id': category.id,
                            'parent': category.parent_id ? category.parent_id : '#',
                            'text': category.name
                        };
                    }),
                    'check_callback': true
                },
                'plugins': ['contextmenu'],
                'contextmenu': {
                    'items': function(node) {
                        var items = $.jstree.defaults.contextmenu.items();
                        delete items.ccp;

                        items.create.label = "Új kategória";
                        items.create.action = function() {
                            $('#createCategoryModal').modal('show');
                        };

                        items.rename.label = "Átnevezés";
                        items.rename.action = function() {
                            $('#renameCategoryModal').modal('show');
                            $('#rename-name').val(node.text);
                        };

                        items.remove.label = "Törlés";
                        items.remove.action = function() {
                            $('#deleteCategoryModal').modal('show');
                        };

                        items.upload = {
                            label: "Fájl feltöltése",
                            action: function () {
                                $('#fileUploadModal').modal('show');
                            }
                        };

                        items.permission = {
                            label: "Jogosultságok kezelése",
                            action: function () {
                                $('#permissionModal').modal('show');
                            }
                        };

                        return items;
                    }
                }
            });
        }
    });

});
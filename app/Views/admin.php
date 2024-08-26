<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Админка</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/jquery-ui.min.js"
        integrity="sha512-Ww1y9OuQ2kehgVWSD/3nhgfrb424O3802QYP/A5gPXoM4+rRjiKrjHdGxQKrMGQykmsJ/86oGdHszfcVgUr4hA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css"
        integrity="sha512-8PjjnSP8Bw/WNPxF6wkklW6qlQJdWJc/3w/ZQPvZ/1bjVDkrrSqLe9mfPYrMxtnzsXFPc434+u4FHLnLjXTSsg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/theme.min.css"
        integrity="sha512-XutDejX3PkIxnMh/xEu11qZ9+jn3lh+SrEnbtXny8dhr7Jk+lBkr2ujwco0Bx4LJ500XibluwyXc0kOJ+oY51Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/5.8.8/css/ui.jqgrid.min.css"
        integrity="sha512-32LPQp8XpFZLhafWO1i/8MvAFIVzDCqJ1C1blA1FjbW210TWwe6olae8lIkZHFwJU1oaR481MDX4clGpGKZigg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/5.8.8/js/jquery.jqGrid.min.js"
        integrity="sha512-nmlwuvfrdYvdx/9swS+xg7W5nTXeGLCETjPHuTPhOHynSsOGjIQ30TM539VbdPi+JzO8jvoEc2icbAIZ78Jfxw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/5.8.8/js/i18n/grid.locale-ru.min.js"
        integrity="sha512-jQT+Yi1ouqHnLk+dwT3ytOlneHR2Vjt7FtOBiEhdw287z3ASC650pFY5+6NDujtdB9+129H14nmsF2x13hNJew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="height: 90vh;">
    <h2>
        <a href="/"
            class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Выйти</a>
    </h2>
    <h1>Управление игрушками</h1>

    <div style="height: 500px;">
        <table id="toysTable" style="height: 100%;"></table>
    </div>
    <div id="toysPager"></div>


    <script>
        $(document).ready(function () {
            $('#toysTable').jqGrid({
                url: '/toys',
                editurl: '/toysEdit',
                datatype: 'json',
                mtype: 'GET',
                autowidth: true,
                colNames: ['ID', 'Название', 'Цена', 'Фото', 'Категория'],
                colModel: [
                    {
                        name: 'id', index: 'id', width: 50,
                        searchoptions: {
                            sopt: ['eq', 'ne', 'lt', 'le', 'gt', 'ge']
                        },
                    },
                    {
                        name: 'name_toys', index: 'name_toys', width: 150,
                        searchoptions: {
                            sopt: ['cn', 'bw', 'ew']
                        },
                        editable: true,
                        editrules: {
                            required: true
                        },
                    },
                    {
                        name: 'price', index: 'price', width: 100,
                        searchoptions: {
                            sopt: ['eq', 'ne', 'lt', 'le', 'gt', 'ge']
                        },
                        editable: true,
                        edittype: 'number',
                        editrules: {
                            minValue: 0
                        },
                    },
                    {
                        name: 'photo_url', index: 'photo_url', width: 100, search: false, editable: true,
                        formatter: function (cellvalue) {
                            return `<img src="${cellvalue}" alt="Toy Image" width="50">`;
                        }
                    },
                    {
                        name: 'category', index: 'category', width: 100,
                        formatter: function (cellvalue) {
                            const categories = ['Не указана', 'Девочки', 'Мальчики', 'Малыши', 'Новорожденные'];
                            return categories[cellvalue] || 'Не указана';
                        },
                        editable: true,
                        edittype: 'select',
                        editoptions: {
                            value: "1:Девочки;2:Мальчики;3:Малыши;4:Новорожденные"
                        }
                    }
                ],
                pager: '#toysPager',
                rowNum: 10,
                pgbuttons: true,
                pgtext: "Страница {0} из {1}",
                viewrecords: true,
                caption: 'Игрушки',
                jsonReader: {
                    root: 'data',
                    repeatitems: false
                }
            });

            jQuery('#toysTable').navGrid('#toysPager',
                {
                    edit: true,
                    add: true,
                    del: true,
                    search: true,
                },
                {
                    afterShowForm: function (formId) {
                        $('#FrmGrid_toysTable').attr("enctype", "multipart/form-data");
                        $("#tr_photo_url").html('<td class="CaptionTD">Фото</td><td class="DataTD"><input type="file" id="fileInput" name="fileInput" /></td>');
                    },

                    onclickSubmit: function (options, postdata) {
                        var formData = new FormData();
                        formData.append('file', $('#fileInput')[0].files[0]);
                        formData.append('oper', 'edit');

                        // Добавьте остальные данные формы
                        for (var key in postdata) {
                            if (postdata.hasOwnProperty(key)) {
                                formData.append(key, postdata[key]);
                            }
                        }
                        $.ajax({
                            url: '/toysEdit',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert("Error uploading data: " + errorThrown);
                            }
                        });

                        // Return false to prevent default form submit
                        return false;
                    }

                },
                {
                    afterShowForm: function (formId) {
                        $('#FrmGrid_toysTable').attr("enctype", "multipart/form-data");
                        $("#tr_photo_url").html('<td class="CaptionTD">Фото</td><td class="DataTD"><input type="file" id="fileInput" name="fileInput[]" /></td>');
                    },
                    onclickSubmit: function (options, postdata) {
                        var formData = new FormData();
                        formData.append('file', $('#fileInput')[0].files[0]);
                        formData.append('oper', 'add');

                        // Добавьте остальные данные формы
                        for (var key in postdata) {
                            if (postdata.hasOwnProperty(key)) {
                                formData.append(key, postdata[key]);
                            }
                        }
                        $.ajax({
                            url: '/toysEdit',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert("Error uploading data: " + errorThrown);
                            }
                        });

                        // Return false to prevent default form submit
                        return false;
                    }

                },

                {},
                { multipleSearch: false },
            )
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
        Danh sách thông tin thiếu nhi
    </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>
        table.dataTable tbody>tr.selected td {
            background-color: #0043c8 !important;
        }

        label {
            min-width: 200px;
        }
    </style>
</head>

<body>
    @include('menu')

    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <table class="table text-center" id="category-table" width="100%" border="1">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col ">Mã số</th>
                            <th scope="col">Tên Thánh</th>
                            <th scope="col">Họ</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Chi đoàn</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
</body>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(function() {
        var table = $('#category-table').DataTable({
            processing: true,
            select: true,
            serverSide: true,
            ajax: '{!! route('student.listApi') !!}',
            columns: [{
                    data: 'code'
                },
                {
                    data: 'saint_name',
                },
                {
                    data: 'first_name',
                },
                {
                    data: 'last_name',
                },
                {
                    data: 'class.id',
                    render: function(data, type, row, meta) {
                        console.log();
                        return `
                            <select name="" class="select-class" id=select-class-${meta.row} data-select=${data} data-code="${row.code}" style="width: 100%">
                            </select>
                        `;
                    }
                },
            ],
            "lengthMenu": [
                [-1, 10, 25, 50, 100],
                ["Tất cả", 10, 25, 50, 100]
            ],
            dom: 'Blfrtip',
            order: [
                [0, "asc"]
            ],
            deferRender: true,
            buttons: [{
                    extend: 'print',
                    footer: true,
                    text: 'In',
                    exportOptions: {
                        columns: ':visible :not(.not-export)'
                    },
                    customize: function(win) {
                        // $(win.document.body)
                        //     .css('font-size', '10pt')
                        //     .prepend(
                        //         '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                        //     );
                        $(win.document.body).find('tfoot tr th').addClass('none')
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Xuất file pdf',
                    exportOptions: {
                        columns: ':visible :not(.not-export)'
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    text: 'Xuất file excel',
                    exportOptions: {
                        columns: ':visible :not(.not-export)'
                    },
                },
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: {
                        columns: ':visible :not(.not-export)'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Lọc cột',
                },
            ],
            columnDefs: [{
                className: "not-export",
                searchable: false,
            }, ],
            drawCallback: function(settings) {
                $.ajax({
                    type: "get",
                    url: "{{ route('classes.api') }}",
                    dataType: "json",
                    success: function(response) {
                        let select_class = $('.select-class');

                        for (let index = 0; index < select_class.length; index++) {
                            response.forEach(element => {
                                let selected = "";
                                if ($(select_class[index]).attr(
                                        'data-select') ==
                                    element.id) {
                                    selected = "selected";
                                }
                                let string =
                                    `<option value="${element.id}" ${selected}>${element.name}</option>`
                                $(select_class[index]).append(string);
                            });
                        }
                    }
                });
                $(".select-class").select2({});
                $(".select-class").on('select2:select', function(e) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('student.update') }}/" + $(this).attr(
                            'data-code'),
                        data: {
                            code: $(this).attr('data-code'),
                            classroom_id: $(this).find(':selected').val()
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                        }
                    });

                    // console.log($(this).find(':selected').val(), $(this).attr('data-code'));
                });
            }

        });
        $("#class").select2({
            ajax: {
                url: "{{ route('classes.api') }}",
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data, params) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            },
            placeholder: 'Lọc theo chi đoàn',
            allowClear: true
        });
        $("#class").change(function() {
            let value = $(this).val();
            (value == null) ? table.column(4).search('').draw(): table.column(4).search("(^" + value +
                    "$)", true, false)
                .draw();
            let title = $(this).find(':selected').text().trim();
            document.title = "Chi đoàn " + title;
        })
    });
</script>

@if ($message = Session::get('success'))
    <script>
        alert('{!! $message !!}')
    </script>
@endif
</body>

</html>

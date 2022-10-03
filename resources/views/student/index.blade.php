<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title data-title="Điểm danh Thánh Lễ tính từ ngày {{ $start_date }} - {{ $end_date }}">
        Điểm danh Thánh Lễ tính từ ngày {{ $start_date }} - {{ $end_date }}
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

        /* .none {
            display: none;
        }

        .none:nth-child(1) {
            display: block;
            width: 100%;
        }

        .none:nth-child(2) {
            display: block;
            width: 100%;
        } */
    </style>
</head>

<body>
    @include('menu')

    <div class="container-fluid">
        <div class="row m-3">
            <div class="col-6">
                <form action="{{ route('dayrequired.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="sunday_required">Tổng lễ Chúa Nhật phải đi</label>
                        <input type="number" id="sunday_required" name="sunday_required">
                    </div>
                    <div class="form-group">
                        <label for="not_sunday_required">Tổng lễ Thường phải đi</label>
                        <input type="number" id="not_sunday_required" name="not_sunday_required">
                    </div>
                    <button class="btn bg-primary w-50">Lưu</button>
                </form>
            </div>
            <div class="col-6">
                <p>Tổng lễ Chúa Nhật phải đi: {{ $dayRequired->sunday_required }} ngày</p>
                <p>Tổng lễ thường phải đi: {{ $dayRequired->not_sunday_required }} ngày</p>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-6">
                <form action="{{ route('student.truncate') }}" method="post">
                    @csrf
                    <button class="btn badge-success m-3">Xóa dữ liệu điểm danh</button>
                </form>
            </div>
            <div class="col-6">
                <select class="form-select form-select-lg mb-3 w-100" id="class">
                </select>
            </div>
        </div>
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
                            <th scope="col">Đi Lễ Chúa Nhật</th>
                            <th scope="col">Vắng Lễ Chúa Nhật</th>
                            <th scope="col">Đi Lễ thường</th>
                            <th scope="col">Vắng Lễ thường</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>

<script>
    $(function() {
        var table = $('#category-table').DataTable({
            processing: true,
            select: true,
            serverSide: true,
            ajax: '{!! route('student.api') !!}',
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
                    data: 'class_id',
                },
                {
                    data: 'count_sunday',
                },
                {
                    data: 'off_sunday',
                },
                {
                    data: 'count_not_sunday',
                },
                {
                    data: 'off_not_sunday',
                },
                // {
                //     data: 'status',
                // },
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
                    messageTop: `<p>Điểm danh Thánh Lễ tính từ ngày {{ $start_date }} - {{ $end_date }}</p>
                                <p>Lễ Chúa Nhật phải đi: {{ $dayRequired->sunday_required }} ngày; Lễ thường phải đi: {{ $dayRequired->not_sunday_required }} ngày </p>`,
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
                    messageTop: `Điểm danh Thánh Lễ tính từ ngày {{ $start_date }} - {{ $end_date }}
                                Lễ Chúa Nhật phải đi: {{ $dayRequired->sunday_required }} ngày; Lễ thường phải đi: {{ $dayRequired->not_sunday_required }} ngày`,
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
                orderable: false,
                // "targets": [5, 6]
            }, ],

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

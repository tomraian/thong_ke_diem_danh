<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title data-title="Thống kê điểm danh từ ngày {{ $start_date }} - {{ $end_date }}">
        Thống kê điểm danh từ ngày {{ $start_date }} - {{ $end_date }}
    </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />

    <style>
        table.dataTable tbody>tr.selected td {
            background-color: #0043c8 !important;
        }

    </style>
</head>

<body>
    @include('menu')

    <div class="container-fluid">
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
                            <th scope="col">Lớp</th>
                            <th scope="col">Chúa Nhật</th>
                            <th scope="col">Ngày thường</th>
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
                    data: 'count_not_sunday',
                },
            ],
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            dom: 'Blfrtip',
            order: [
                [0, "asc"]
            ],
            deferRender: true,
            buttons: [{
                    extend: 'print',
                    text: 'In',
                    exportOptions: {
                        columns: ':visible :not(.not-export)'
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Xuất file pdf',
                    exportOptions: {
                        columns: ':visible :not(.not-export)'
                    }
                },
                {
                    extend: 'excel',
                    text: 'Xuất file excel',
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
                "targets": [5, 6]
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
        let data_title = $('title').data('title')
        $("#class").change(function() {
            let value = $(this).val();
            (value == null) ? table.column(4).search('').draw(): table.column(4).search(value).draw();
            let classes = $(this).children().last().text();
            let new_title =
                `${data_title}
Chi đoàn lớp ${classes}`;
            document.title = new_title;
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

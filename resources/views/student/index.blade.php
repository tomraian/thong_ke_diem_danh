<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thống kê điểm danh {{ $start_date }} - {{ $end_date }}</title>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        table.dataTable tbody>tr.selected td {
            background-color: #0043c8 !important;
        }

    </style>
</head>

<body>
    @include('menu')

    <div class="container-fluid">
        <form action="{{ route('student.truncate') }}" method="post">
            @csrf
            <button class="btn badge-success m-3">Xóa dữ liệu điểm danh</button>
        </form>
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
</body>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.js">
</script>
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
                [1, "asc"]
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
            }, ],

        });
    });
</script>
@if ($message = Session::get('success'))
    <script>
        alert('{!! $message !!}')
    </script>
@endif
</body>

</html>

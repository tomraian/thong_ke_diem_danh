<!DOCTYPE html>
<html>

<head>
    <title>Quản lý danh sách lớp</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />

</head>

<body>
    @include('menu')
    <?php
    // $arr = ['A', 'B', 'C'];
    ?>
    {{-- @for ($i = 1; $i <= 4; $i++)
        @foreach ($arr as $item)
            Bao đồng {{ $i }}{{ $item }}
            <br>
        @endforeach
    @endfor --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="card bg-light mt-3">
            <div class="card-header">
                Thêm lớp
            </div>
            <div class="card-body">
                <form action="{{ route('classes.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-success">Thêm</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card bg-light mt-3">
            <div class="card-header">
                Thêm lớp
            </div>
            <div class="card-body">
                <form action="{{ route('classes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="input" name="name" class="form-control">
                    <br>
                    <button class="btn btn-success">Thêm</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card bg-light mt-3">
            <div class="card-header">
                Danh sách các lớp - Có {{ $count }} lớp đang mở
                <span style="float: right">
                    <select name="" id="orderby">
                        <option value="status" @if (Request::get('orderby') == 'status') selected @endif>Sắp xếp theo lớp đang
                            mở</option>
                        <option value="id" @if (Request::get('orderby') == 'id') selected @endif>Sắp xếp theo id
                        </option>
                    </select>
                </span>

            </div>
            <div class="card-body">
                <table border="1" width="100%" style="text-align: center;">
                    <tr>
                        <td>Mã lớp</td>
                        <td>Tên lớp</td>
                        <td>Trạng thái</td>
                        <td>Hành động</td>
                    </tr>
                    @foreach ($classes as $class)
                        <tr>
                            <td>{{ $class->id }}</td>
                            <td>{{ $class->name }}</td>
                            <td>

                                @if ($class->status == 0)
                                    <span class="badge badge-success">Mở</span>
                                @else
                                    <span class="badge badge-danger">Đóng</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('classes.status', $class->id) }}" method="post">
                                    @csrf
                                    @if ($class->status == 1)
                                        <button class="btn btn-success">Mở lớp</button>
                                    @else
                                        <button class="btn btn-danger">Đóng lớp</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <script>
            alert('{!! $message !!}')
        </script>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orderby').change(function(e) {
                let url = '{{ route('classes.importView') }}';
                window.location.href = url + "?orderby=" + $(this).val();
            });
        });
    </script>
</body>

</html>

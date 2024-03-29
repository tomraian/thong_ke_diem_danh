<!DOCTYPE html>
<html>

<head>
    <title>Laravel 5.7 Import Export Excel to database Example - ItSolutionStuff.com</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />

</head>

<body>
    @include('menu')

    <div class="container">
        <div class="card bg-light mt-3">
            <div class="card-header">
                Tải thông tin điểm danh
            </div>
            <div class="card-body">
                <form action="{{ route('attendance.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-success">Thêm</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

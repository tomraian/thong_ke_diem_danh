<!DOCTYPE html>
<html>

<head>
    <title>Quản lý thiếu nhi</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
</head>

<body>
    @include('menu')

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card bg-light mt-3">
            <div class="card-header">
                Thêm thiếu nhi
            </div>
            <div class="card-body">
                <form action="{{ route('student.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-success">Thêm</button>
                </form>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <script>
            alert('{!! $message !!}')
        </script>
    @endif
</body>

</html>

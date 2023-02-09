<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <a class="navbar-brand" href="{{ route('student.index') }}">Trang chủ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('classes.import') }}">Nhập lớp</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.import') }}">Nhập thiếu nhi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('attendance.import') }}">Nhập thông tin điểm danh</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('attendance.index') }}">Thống kê điểm danh</a>
            </li> --}}
        </ul>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('student.list') }}">Danh sách</a>
            </li>
        </ul>
    </div>
</nav>

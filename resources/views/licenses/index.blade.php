<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý bản quyền</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
<h2 class="mb-4">📋 Danh sách bản quyền</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Tên</th>
        <th>ID Máy</th>
        <th>Hạn sử dụng</th>
        <th>Còn lại</th>
    </tr>
    </thead>
    <tbody>
    @foreach($licenses as $license)
        <tr>
            <td>{{ $license->name }}</td>
            <td>{{ $license->machine_id }}</td>
            <td>{{ $license->expires_at }}</td>
            <td>
                @php
                    $days = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($license->expires_at), false);
                @endphp
                {{ $days >= 0 ? "$days ngày" : "Hết hạn" }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<h4 class="mt-5">➕ Thêm bản quyền mới</h4>
<form method="POST" action="{{ route('licenses.store') }}" class="mt-3">
    @csrf
    <div class="mb-3">
        <label for="name">Tên người dùng</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="machine_id">ID máy</label>
        <input type="text" name="machine_id" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="expires_at">Ngày hết hạn</label>
        <input type="date" name="expires_at" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
</form>
</body>
</html>

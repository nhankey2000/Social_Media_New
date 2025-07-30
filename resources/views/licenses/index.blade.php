<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bản quyền</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">📋 Quản lý bản quyền phần mềm</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Danh sách bản quyền -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📊 Danh sách bản quyền hiện tại</h5>
                </div>
                <div class="card-body">
                    @if($licenses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>👤 Tên người dùng</th>
                                    <th>🖥️ ID Máy</th>
                                    <th>📅 Ngày hết hạn</th>
                                    <th>⏰ Trạng thái</th>
                                    <th>🔧 Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($licenses as $license)
                                    <tr>
                                        <td>{{ $license->id }}</td>
                                        <td>{{ $license->name }}</td>
                                        <td><code>{{ $license->machine_id }}</code></td>
                                        <td>{{ $license->expires_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                                    <span class="badge bg-{{ $license->status['class'] }}">
                                                        {{ $license->status['text'] }}
                                                    </span>
                                        </td>
                                        <td>
                                            <!-- Nút gia hạn -->
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal" data-bs-target="#extendModal{{ $license->id }}">
                                                ⏰ Gia hạn
                                            </button>

                                            <!-- Nút xóa -->
                                            <form method="POST" action="{{ route('licenses.destroy', $license->id) }}"
                                                  class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    🗑️ Xóa
                                                </button>
                                            </form>

                                            <!-- Modal gia hạn -->
                                            <div class="modal fade" id="extendModal{{ $license->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Gia hạn cho {{ $license->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="POST" action="{{ route('licenses.extend', $license->id) }}">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Số ngày gia hạn</label>
                                                                    <select name="days" class="form-select" required>
                                                                        <option value="7">7 ngày</option>
                                                                        <option value="30" selected>30 ngày</option>
                                                                        <option value="90">90 ngày</option>
                                                                        <option value="180">180 ngày</option>
                                                                        <option value="365">365 ngày</option>
                                                                    </select>
                                                                </div>
                                                                <p class="text-muted">
                                                                    Hiện tại: {{ $license->expires_at->format('d/m/Y H:i') }}<br>
                                                                    Trạng thái: {{ $license->status['text'] }}
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                                <button type="submit" class="btn btn-primary">Gia hạn</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">Chưa có bản quyền nào được tạo</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form thêm bản quyền mới -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">➕ Thêm bản quyền mới</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('licenses.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="name" class="form-label">👤 Tên người dùng</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name') }}" required placeholder="VD: Nguyễn Văn A">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="machine_id" class="form-label">🖥️ ID máy</label>
                                <input type="text" name="machine_id" class="form-control"
                                       value="{{ old('machine_id') }}" required placeholder="VD: ABC-123-DEF">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="expires_at" class="form-label">📅 Ngày hết hạn</label>
                                <input type="datetime-local" name="expires_at" class="form-control"
                                       value="{{ old('expires_at', now()->addDays(30)->format('Y-m-d\TH:i')) }}" required>
                            </div>
                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100">
                                    💾 Thêm bản quyền
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thống kê tổng quan -->
            <div class="row mt-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h4 class="text-primary">{{ $totalLicenses }}</h4>
                            <p class="card-text">📊 Tổng bản quyền</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h4 class="text-success">{{ $activeLicenses }}</h4>
                            <p class="card-text">✅ Còn hiệu lực</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h4 class="text-warning">{{ $expiringNext7Days }}</h4>
                            <p class="card-text">⚠️ Sắp hết hạn (7 ngày)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <h4 class="text-danger">{{ $expiredLicenses }}</h4>
                            <p class="card-text">❌ Đã hết hạn</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

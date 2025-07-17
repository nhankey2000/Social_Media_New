<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hardware ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
        }

        .list-item {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .list-item:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateX(5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .input-field {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: rgba(255, 255, 255, 1);
        }
    </style>
</head>
<body class="min-h-screen p-6">
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">
            <i class="fas fa-key mr-3"></i>
            Quản lý Hardware ID
        </h1>
        <p class="text-white/80 text-lg">Hệ thống quản lý danh sách ID được kích hoạt</p>
    </div>

    <!-- Form thêm Hardware ID -->
    <div class="card rounded-3xl p-8 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-plus-circle mr-3 text-blue-500"></i>
            Thêm Hardware ID mới
        </h2>

        <form method="POST" action="/keys" class="space-y-4">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hardware ID</label>
                    <input
                        name="hardware_id"
                        type="text"
                        placeholder="Nhập Hardware ID..."
                        class="input-field w-full px-4 py-3 rounded-xl focus:outline-none"
                        required
                    />
                </div>
                <div class="flex items-end">
                    <button
                        type="submit"
                        class="btn-primary text-white px-8 py-3 rounded-xl font-semibold flex items-center justify-center min-w-[120px]"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        Thêm
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Danh sách Hardware ID -->
    <div class="card rounded-3xl p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
                <i class="fas fa-list mr-3 text-green-500"></i>
                Danh sách ID đã kích hoạt
            </h2>
            <div class="text-sm text-gray-500">
                Tổng số: <span class="font-semibold text-gray-700">{{ count($keys) }}</span>
            </div>
        </div>

        @if(count($keys) > 0)
            <div class="space-y-3">
                @foreach ($keys as $key)
                    <div class="list-item rounded-xl p-4 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-microchip text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">{{ $key->hardware_id }}</div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Đã thêm: {{ $key->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Hoạt động
                                </span>
                            <form method="POST" action="/keys/{{ $key->id }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn-danger text-white px-4 py-2 rounded-lg font-medium flex items-center"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa Hardware ID này?')"
                                >
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-inbox text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có Hardware ID nào</h3>
                <p class="text-gray-500">Thêm Hardware ID đầu tiên để bắt đầu quản lý</p>
            </div>
        @endif
    </div>
</div>

<script>
    // Thêm hiệu ứng loading khi submit form
    document.querySelector('form').addEventListener('submit', function(e) {
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang thêm...';
        button.disabled = true;
    });

    // Thêm hiệu ứng loading khi xóa
    document.querySelectorAll('form[method="POST"]').forEach(form => {
        if (form.querySelector('input[name="_method"][value="DELETE"]')) {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                if (button && confirm('Bạn có chắc chắn muốn xóa Hardware ID này?')) {
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xóa...';
                    button.disabled = true;
                }
            });
        }
    });
</script>
</body>
</html>

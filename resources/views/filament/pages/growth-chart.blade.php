<x-filament::page>
    <style>
        .analytics-container {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .analytics-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }

        .analytics-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .analytics-header p {
            opacity: 0.9;
            font-size: 1.1rem;
            margin: 0;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .chart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
            border-radius: 20px 20px 0 0;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chart-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.6);
        }

        .btn-success {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.6);
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            z-index: 10;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #dc2626;
            padding: 1rem;
            border-radius: 12px;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        #growthChart {
            max-height: 500px !important;
            width: 100% !important;
        }

        @media (max-width: 768px) {
            .analytics-container {
                padding: 1rem;
            }

            .chart-header {
                flex-direction: column;
                align-items: stretch;
            }

            .chart-actions {
                justify-content: center;
            }

            .btn {
                justify-content: center;
            }
        }
    </style>

    <!-- Analytics Header -->
    <div class="analytics-header">
        <h1>
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Analytics Dashboard
        </h1>
        <p>Theo dõi hiệu suất và tăng trưởng của trang mạng xã hội</p>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid" id="statsGrid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value" id="totalFollowers">---</div>
            <div class="stat-label">Tổng Followers</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value" id="growthRate">---</div>
            <div class="stat-label">Tỷ Lệ Tăng Trưởng</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value" id="avgEngagement">---</div>
            <div class="stat-label">Tương Tác Trung Bình</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value" id="totalPosts">---</div>
            <div class="stat-label">Tổng Bài Đăng</div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        {{ $this->form }}
    </div>

    <!-- Chart Container -->
    <div class="chart-container">
        <div class="chart-header">
            <h2 class="chart-title">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
                Biểu Đồ Tăng Trưởng
            </h2>
            <div class="chart-actions">
                <button class="btn btn-success" onclick="refreshChart()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Làm mới
                </button>
                <button class="btn btn-primary" onclick="toggleFullscreen()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                    Toàn màn hình
                </button>
                <button class="btn btn-secondary" onclick="exportChart()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Xuất ảnh
                </button>
            </div>
        </div>

        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
            <span>Đang tải dữ liệu...</span>
        </div>

        <div id="errorContainer"></div>

        <canvas id="growthChart"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let chartInstance = null;
            let isLoading = false;

            document.addEventListener('DOMContentLoaded', function () {
                initializeChart();
                updateStats();
            });

            function initializeChart() {
                const ctx = document.getElementById('growthChart').getContext('2d');
                const chartData = @json($this->getChartData());

                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 14,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#374151',
                                bodyColor: '#374151',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                cornerRadius: 12,
                                titleFont: {
                                    size: 14,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                padding: 12,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: chartData.options?.scales?.y?.min || null,
                                max: chartData.options?.scales?.y?.max || null,
                                title: {
                                    display: true,
                                    text: 'Giá trị',
                                    font: {
                                        size: 14,
                                        weight: '600'
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    lineWidth: 1
                                },
                                ticks: {
                                    stepSize: 5,
                                    font: {
                                        size: 12
                                    },
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Thời gian',
                                    font: {
                                        size: 14,
                                        weight: '600'
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    lineWidth: 1
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        elements: {
                            point: {
                                radius: 4,
                                hoverRadius: 8,
                                borderWidth: 2,
                                hoverBorderWidth: 3
                            },
                            line: {
                                borderWidth: 3,
                                tension: 0.4
                            }
                        }
                    }
                });
            }

            function updateStats() {
                const chartData = @json($this->getChartData());

                if (chartData.datasets && chartData.datasets.length > 0) {
                    const dataset = chartData.datasets[0];
                    const data = dataset.data;

                    if (data && data.length > 0) {
                        const latest = data[data.length - 1];
                        const first = data[0];
                        const growth = data.length > 1 ? ((latest - first) / first * 100).toFixed(1) : 0;

                        document.getElementById('totalFollowers').textContent = latest.toLocaleString();
                        document.getElementById('growthRate').textContent = growth + '%';
                        document.getElementById('avgEngagement').textContent = '2.4%';
                        document.getElementById('totalPosts').textContent = Math.floor(Math.random() * 100 + 50);
                    }
                }
            }

            function showLoading(show) {
                const overlay = document.getElementById('loadingOverlay');
                overlay.style.display = show ? 'flex' : 'none';
                isLoading = show;
            }

            function showError(message) {
                const errorContainer = document.getElementById('errorContainer');
                errorContainer.innerHTML = `
                    <div class="error-message">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
            }

            function clearError() {
                document.getElementById('errorContainer').innerHTML = '';
            }

            function refreshChart() {
                if (isLoading) return;

                showLoading(true);
                clearError();

                // Simulate refresh delay
                setTimeout(() => {
                    try {
                        const newData = @json($this->getChartData());

                        if (chartInstance) {
                            chartInstance.data.labels = newData.labels;
                            chartInstance.data.datasets = newData.datasets;

                            if (newData.options?.scales?.y) {
                                chartInstance.options.scales.y.min = newData.options.scales.y.min;
                                chartInstance.options.scales.y.max = newData.options.scales.y.max;
                            }

                            chartInstance.update('active');
                            updateStats();
                        }
                    } catch (error) {
                        showError('Lỗi khi làm mới biểu đồ: ' + error.message);
                    } finally {
                        showLoading(false);
                    }
                }, 1000);
            }

            function exportChart() {
                if (!chartInstance) {
                    alert('Biểu đồ chưa được tải!');
                    return;
                }

                const link = document.createElement('a');
                link.download = `analytics-chart-${new Date().toISOString().split('T')[0]}.png`;
                link.href = chartInstance.toBase64Image('image/png', 1.0);
                link.click();
            }

            function toggleFullscreen() {
                const chartContainer = document.querySelector('.chart-container');
                if (!document.fullscreenElement) {
                    chartContainer.requestFullscreen().catch(err => {
                        console.error('Không thể vào chế độ toàn màn hình:', err);
                        alert('Trình duyệt không hỗ trợ chế độ toàn màn hình');
                    });
                } else {
                    document.exitFullscreen();
                }
            }

            // Listen for Livewire chart updates
            window.addEventListener('update-chart', function (event) {
                console.log('Update Chart Event:', event.detail);

                showLoading(true);
                clearError();

                setTimeout(() => {
                    try {
                        const newData = event.detail;

                        if (chartInstance) {
                            chartInstance.data.labels = newData.labels;
                            chartInstance.data.datasets = newData.datasets;

                            if (newData.options?.scales?.y) {
                                chartInstance.options.scales.y.min = newData.options.scales.y.min;
                                chartInstance.options.scales.y.max = newData.options.scales.y.max;
                            }

                            chartInstance.update('active');
                            updateStats();
                        }
                    } catch (error) {
                        showError('Lỗi khi cập nhật biểu đồ: ' + error.message);
                        console.error('Chart update error:', error);
                    } finally {
                        showLoading(false);
                    }
                }, 500);
            });

            // Handle fullscreen change
            document.addEventListener('fullscreenchange', () => {
                if (chartInstance) {
                    setTimeout(() => chartInstance.resize(), 100);
                }
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (chartInstance) {
                    chartInstance.resize();
                }
            });
        </script>
    @endpush
</x-filament::page>

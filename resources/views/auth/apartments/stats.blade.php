<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detailed Statistics for: {{ $apartment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg text-gray-800 dark:text-gray-200 font-semibold mb-4">Total Views: {{ $totalViews }}
                </h3>

                <form method="GET" action="{{ route('apartments.stats', $apartment->id) }}">
                    <select class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200" name="period"
                        onchange="this.form.submit()">
                        <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </form>

                <canvas id="viewsChart"></canvas>

                <a href="{{ route('apartments.show', $apartment->id) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Back to Apartment
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4"></script>
    <script>
        const ctx = document.getElementById('viewsChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Views',
                    data: @json($views),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Views'
                        },
                        beginAtZero: true,
                        suggestedMin: 0,
                        suggestedMax: 10,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return Number.isInteger(value) ? value : null;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>


</x-app-layout>

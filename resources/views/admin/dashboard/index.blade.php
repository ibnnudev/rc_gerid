<x-app-layout>
    <x-breadcrumbs name="dashboard" />
    <h1 class="font-semibold text-xl my-8">Dashboard</h1>

    {{-- Statistic --}}
    <div class="xl:grid xl:grid-cols-4 gap-x-4 mb-4 sm:block">
        {{-- Total Visitor --}}
        <div class="stats shadow mb-4 w-full">
            <div class="stat w-full">
                <div class="stat-figure text-secondary">
                    <i class="fas fa-users fa-2xl text-primary"></i>
                </div>
                <div class="stat-title">Total Pengunjung</div>
                <div class="stat-value">
                    {{ $totalVisitors }}
                </div>
                <div class="stat-desc">
                    {{ $totalVisitorToday }} Pengunjung Hari Ini
                </div>
            </div>
        </div>

        {{-- Total Sample --}}
        <div class="stats shadow mb-4 w-full">
            <div class="stat w-full">
                <div class="stat-figure text-secondary">
                    <i class="fas fa-flask fa-2xl text-primary"></i>
                </div>
                <div class="stat-title">Total Sampel</div>
                <div class="stat-value">
                    {{ $totalSamples }}
                </div>
                <div class="stat-desc">
                    {{ $totalSampleToday }} Sampel Hari Ini
                </div>
            </div>
        </div>

        {{-- Total Viruses --}}
        <div class="stats shadow mb-4 w-full">
            <div class="stat w-full">
                <div class="stat-figure text-secondary">
                    <i class="fas fa-viruses fa-2xl text-primary"></i>
                </div>
                <div class="stat-title">Jenis Virus</div>
                <div class="stat-value">
                    {{ $totalViruses }}
                </div>
            </div>
        </div>

        {{-- Total Author --}}
        <div class="stats shadow mb-4 w-full">
            <div class="stat w-full">
                <div class="stat-figure text-secondary">
                    <i class="fas fa-user fa-2xl text-primary"></i>
                </div>
                <div class="stat-title">Total Pengarang</div>
                <div class="stat-value">
                    {{ $totalAuthors }}
                </div>
            </div>
        </div>
    </div>

    {{-- Visitor Chart --}}
    <div class="md:grid md:grid-cols-2 gap-x-4">
        <x-card-container>
            <div class="flex justify-between items-center">
                <h3 class="font-semibold">Jumlah Visitor</h3>
                <div>
                    {{-- input year with select2 --}}
                    <x-select name="year" id="year" class="max-w-sm">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div style="height: 300px" class="relative">
                <canvas id="totalVisitorsChart" class="absolute z-10"></canvas>
            </div>
        </x-card-container>

        <x-card-container>
            <div class="flex justify-between items-center" id="virusContainer">
                <h3 class="font-semibold">Virus</h3>
                <div>
                    {{-- input year with select2 --}}
                    <x-select name="year" id="year" class="max-w-sm">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div style="height: 300px" class="relative">
                <canvas id="totalVisitorsChart" class="absolute z-10"></canvas>
            </div>
        </x-card-container>
    </div>

    @push('js-internal')
        <script>
            let totalVisitorPerMonth = @json($totalVisitorPerMonth);
            let months = @json($months);

            $(function() {
                $('#year').select2();
                let year;

                $('#year').on('change', function() {
                    year = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.filter.total-visitor') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            year: year
                        },
                        dataType: "json",
                        success: function(response) {
                            totalVisitorPerMonth = response.totalVisitorPerMonth;
                            months = response.months;

                            totalVisitorsChart.data.labels = months.map(month => month.substr(0,
                                3));
                            // remove -1
                            totalVisitorsChart.data.datasets[0].data = totalVisitorPerMonth;
                            totalVisitorsChart.update();

                        }
                    });
                });

                $('#virusContainer #year').select2();
                let virusYear;

                $('#virusContainer #year').on('change', function() {
                    virusYear = $(this).val();

                });
            });
        </script>

        {{-- Total Visitor Chart --}}
        <script src="{{ asset('js/total-visitors.js') }}"></script>
    @endpush
</x-app-layout>

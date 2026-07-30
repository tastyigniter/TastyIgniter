<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Reverb Connections"
        title="Time: {{ number_format($time) }}ms; Run at: {{ $runAt }};"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
            <x-reverb::icons.reverb />
        </x-slot:icon>
        <x-slot:actions>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                    <div class="h-0.5 w-3 rounded-full bg-[{{ $this->colors['max'] }}]"></div>
                    Peak
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                    <div class="h-0.5 w-3 rounded-full bg-[{{ $this->colors['avg'] }}]"></div>
                    Average
                </div>
            </div>
        </x-slot:actions>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        @if ($connections->isEmpty())
            <x-pulse::no-results />
        @else
            <div class="grid gap-3 mx-px mb-px">
                @foreach ($connections as $app => $readings)
                    <div wire:key="connections:{{ $app }}">
                        <h3 class="font-bold text-gray-700 dark:text-gray-300">
                            {{ $app }}
                        </h3>
                        @php
                            $highest = $readings->flatten()->max();
                        @endphp

                        <div class="mt-3 relative">
                            <div class="absolute -left-px -top-2 max-w-fit h-4 flex items-center px-1 text-xs leading-none text-white font-bold bg-purple-500 rounded after:[--triangle-size:4px] after:border-l-purple-500 after:absolute after:right-[calc(-1*var(--triangle-size))] after:top-[calc(50%-var(--triangle-size))] after:border-t-[length:var(--triangle-size)] after:border-b-[length:var(--triangle-size)] after:border-l-[length:var(--triangle-size)] after:border-transparent">
                                @if ($config['sample_rate'] < 1)
                                    <span title="Sample rate: {{ $config['sample_rate'] }}, Raw value: {{ number_format($highest) }}">~{{ number_format($highest * (1 / $config['sample_rate'])) }}</span>
                                @else
                                    {{ number_format($highest) }}
                                @endif
                            </div>

                            <div
                                wire:ignore
                                class="h-14"
                                x-data="connectionsChart({
                                    app: '{{ $app }}',
                                    readings: @js($readings),
                                    sampleRate: {{ $config['sample_rate'] }},
                                })"
                            >
                                <canvas x-ref="canvas" class="ring-1 ring-gray-900/5 dark:ring-gray-100/10 bg-gray-50 dark:bg-gray-800 rounded-md shadow-sm"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-pulse::scroll>
</x-pulse::card>

@script
<script>
Alpine.data('connectionsChart', (config) => ({
    init() {
        let chart = new Chart(
            this.$refs.canvas,
            {
                type: 'line',
                data: {
                    labels: this.labels(config.readings),
                    datasets: [
                        {
                            label: 'Peak',
                            borderColor: '{{ $this->colors['max'] }}',
                            data: this.scale(config.readings['reverb_connections:max']),
                            order: 0,
                        },
                        {
                            label: 'Average',
                            borderColor: '{{ $this->colors['avg'] }}',
                            data: this.scale(config.readings['reverb_connections:avg']),
                            order: 1,
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        autoPadding: false,
                        padding: {
                            top: 1,
                        },
                    },
                    datasets: {
                        line: {
                            borderWidth: 2,
                            borderCapStyle: 'round',
                            pointHitRadius: 10,
                            pointStyle: false,
                            tension: 0.2,
                            spanGaps: false,
                            segment: {
                                borderColor: (ctx) => ctx.p0.raw === 0 && ctx.p1.raw === 0 ? 'transparent' : undefined,
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: false,
                        },
                        y: {
                            display: false,
                            min: 0,
                            max: this.highest(config.readings),
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            mode: 'index',
                            position: 'nearest',
                            intersect: false,
                            callbacks: {
                                beforeBody: (context) => context
                                    .map(item => `${item.dataset.label}: ${config.sampleRate < 1 ? '~' : ''}${item.formattedValue}`)
                                    .join(', '),
                                label: () => null,
                            },
                        },
                    },
                },
            }
        )

        Livewire.on('reverb-connections-chart-update', ({ connections }) => {
            if (chart === undefined) {
                return
            }

            if (connections[config.app] === undefined && chart) {
                chart.destroy()
                chart = undefined
                return
            }

            chart.data.labels = this.labels(connections[config.app])
            chart.options.scales.y.max = this.highest(connections[config.app])
            chart.data.datasets[0].data = this.scale(connections[config.app]['reverb_connections:max'])
            chart.data.datasets[1].data = this.scale(connections[config.app]['reverb_connections:avg'])
            chart.update()
        })
    },
    labels(readings) {
        return Object.keys(readings['reverb_connections:max'])
    },
    scale(data) {
        return Object.values(data).map(value => value * (1 / config.sampleRate ))
    },
    highest(readings) {
        return Math.max(...Object.values(readings).map(dataset => Math.max(...Object.values(dataset)))) * (1 / config.sampleRate)
    }
}))
</script>
@endscript

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Event Saya
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto space-y-6">

        {{-- Event Sedang Diikuti --}}
        <h2 class="text-2xl font-bold mb-3">Event Sedang Diikuti</h2>
        @if($ongoingEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($ongoingEvents as $event)
                    @php
                        $attendance = $event->attendances()->where('user_id', auth()->id())->first();
                        $statusBadge = 'bg-yellow-600';
                        $statusText = $event->status_event;
                        if ($event->status_event == 'Selesai' && !$attendance) {
                            $statusText = 'Tidak Hadir';
                            $statusBadge = 'bg-red-600';
                        } elseif ($event->status_event == 'Selesai') {
                            $statusBadge = 'bg-green-600';
                        }
                    @endphp

                    <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-semibold mb-1">{{ $event->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $event->date }} | {{ $event->location }}</p>
                            <span class="inline-block px-2 py-1 rounded text-white text-xs {{ $statusBadge }}">
                                {{ $statusText }}
                            </span>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('mahasiswa.events.show', $event->id) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Tidak ada event sedang diikuti.</p>
        @endif

        {{-- Event Telah Diikuti --}}
        <h2 class="text-2xl font-bold mt-8 mb-3">Event Telah Diikuti</h2>
        @if($finishedEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($finishedEvents as $event)
                    @php
                        $attendance = $event->attendances()->where('user_id', auth()->id())->first();
                        $statusBadge = 'bg-green-600';
                        $statusText = 'Selesai';
                        if ($event->status_event == 'Selesai' && !$attendance) {
                            $statusText = 'Tidak Hadir';
                            $statusBadge = 'bg-red-600';
                        }
                    @endphp

                    <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-semibold mb-1">{{ $event->title }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $event->date }} | {{ $event->location }}</p>
                            <span class="inline-block px-2 py-1 rounded text-white text-xs {{ $statusBadge }}">
                                {{ $statusText }}
                            </span>
                        </div>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('mahasiswa.events.show', $event->id) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                Lihat Detail
                            </a>

                            @php
                                $attendance = $event->attendances()->where('user_id', auth()->id())->first();
                            @endphp
                            @if($attendance && $event->status_event == 'Selesai')
                                <a href="{{ route('events.downloadCertificate', $event->id) }}" class="px-4 py-2 bg-green-600 text-white rounded">
                                    Download Sertifikat
                                </a>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Tidak ada event yang telah diikuti.</p>
        @endif

    </div>
</x-app-layout>

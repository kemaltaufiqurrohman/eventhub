<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-2xl font-bold mb-4">Kelola Event</h1>

            <table class="w-full border-collapse shadow rounded overflow-hidden">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Judul</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Panitia</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($events as $event)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-2">{{ $event->title }}</td>
                            <td class="p-2">{{ $event->date }}</td>
                            <td class="p-2">{{ $event->organizer->name }}</td>

                            <td class="p-2">
                                @if ($event->status == 'Pending')
                                    <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded">Pending</span>
                                @elseif ($event->status == 'Disetujui')
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded">Disetujui</span>
                                @else
                                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded">Ditolak</span>
                                @endif
                            </td>

                            <td class="p-2 flex gap-2">

                                {{-- Detail Event --}}
                                <a href="{{ route('admin.events.show', $event->id) }}"
                                   class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Detail
                                </a>

                                {{-- Tombol Approve/Reject HANYA jika pending --}}
                                @if($event->status == 'Pending')

                                    <form action="{{ route('admin.event.setStatus') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        <input type="hidden" name="status" value="Disetujui">
                                        <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                            Setuju
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.event.setStatus') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        <input type="hidden" name="status" value="Ditolak">
                                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                            Tolak
                                        </button>
                                    </form>

                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</x-app-layout>

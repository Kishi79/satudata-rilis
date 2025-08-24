<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        {{-- Judul --}}
        <h1 class="text-xl font-bold mb-1">Jadwal Rilis Dataset</h1>
        <p class="mb-4 text-sm text-gray-600">
            Merupakan informasi mengenai jadwal rilis dari sebuah dataset.
        </p>

        {{-- Filter --}}
        <form method="get" class="grid md:grid-cols-3 gap-3 mb-4">
            <input type="text" name="q" value="{{ request('q') }}" 
                   placeholder="Cari Judul Dataset..."
                   class="border rounded px-3 py-2 w-full">

            <select name="opd" class="border rounded px-3 py-2 w-full">
                <option value="">Pilih OPD</option>
                @foreach($opds as $o)
                    <option value="{{ $o->id }}" @selected(request('opd')==$o->id)>
                        {{ $o->name }}
                    </option>
                @endforeach
            </select>

            <select name="group" class="border rounded px-3 py-2 w-full">
                <option value="">Pilih sektoral</option>
                @foreach($groups as $g)
                    <option value="{{ $g->id }}" @selected(request('group')==$g->id)>
                        {{ $g->name }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Switch Kalender/Tabel --}}
        <div class="flex items-center gap-2 mb-3">
            <button type="button" class="px-4 py-2 border rounded bg-gray-200">Kalender</button>
            <button type="button" class="px-4 py-2 border rounded bg-gray-500 text-white">Tabel</button>

            {{-- Tombol tambah hanya muncul jika login --}}
            @auth
                @role('Admin')
                    <a href="{{ route('jadwal.create') }}" 
                       class="ml-auto bg-blue-600 text-white px-4 py-2 rounded">
                        + Tambah Jadwal Rilis
                    </a>
                @endrole
            @endauth
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto bg-white border rounded">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left">No</th>
                        <th class="px-3 py-2 text-left">Judul Dataset</th>
                        <th class="px-3 py-2 text-center">Periode Waktu</th>
                        <th class="px-3 py-2 text-center">OPD</th>
                        <th class="px-3 py-2 text-center">Jadwal Rilis</th>
                        <th class="px-3 py-2 text-center">Status Rilis</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($q as $i => $row)
                        <tr class="border-t">
                            <td class="px-3 py-2">{{ $q->firstItem() + $i }}</td>
                            <td class="px-3 py-2">{{ $row->judul_dataset }}</td>
                            <td class="px-3 py-2 text-center">
                                {{ $row->dataset->priode_waktu ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-center">
                                {{ $row->opd->name ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-center">
                                {{ $row->release_date?->format('d-m-Y') ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-center">
                                @php
                                    $map = [
                                        'akan_dirilis' => 'bg-blue-100 text-blue-800',
                                        'tertunda' => 'bg-red-100 text-red-800',
                                        'sudah_dirilis' => 'bg-green-100 text-green-800'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded {{ $map[$row->status] ?? 'bg-gray-100' }}">
                                    {{ str($row->status)->replace('_',' ')->title() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-6 text-center text-gray-500">
                                Belum ada jadwal
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $q->links() }}</div>
    </div>
</x-app-layout>

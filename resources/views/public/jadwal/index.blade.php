<x-app-layout>
  <div class="max-w-6xl mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Jadwal Rilis Dataset</h1>

    {{-- highlight jadwal terdekat --}}
    @if($terdekat)
      <div class="mb-4 border rounded p-3 bg-yellow-50">
        <div class="text-sm">Jadwal terdekat</div>
        <div class="font-medium">{{ $terdekat->judul_dataset }}</div>
        <div class="text-sm">{{ $terdekat->opd->name }} • {{ $terdekat->release_date->translatedFormat('d F Y') }}</div>
      </div>
    @endif

    <form method="get" class="grid md:grid-cols-5 gap-2 mb-4">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Judul Dataset…"
             class="border rounded px-3 py-2 md:col-span-2">
      <select name="opd" class="border rounded px-3 py-2">
        <option value="">Pilih OPD</option>
        @foreach($opds as $o)<option value="{{ $o->id }}" @selected(request('opd')==$o->id)>{{ $o->name }}</option>@endforeach
      </select>
      <select name="group" class="border rounded px-3 py-2">
        <option value="">Pilih Sektoral</option>
        @foreach($groups as $g)<option value="{{ $g->id }}" @selected(request('group')==$g->id)>{{ $g->name }}</option>@endforeach
      </select>
      <select name="status" class="border rounded px-3 py-2">
        <option value="">Semua Status</option>
        @foreach(['akan_dirilis'=>'Akan dirilis','tertunda'=>'Tertunda','sudah_dirilis'=>'Sudah dirilis'] as $k=>$v)
          <option value="{{ $k }}" @selected(request('status')==$k)>{{ $v }}</option>
        @endforeach
      </select>
      <div class="grid grid-cols-2 gap-2 md:col-span-2">
        <select name="bulan" class="border rounded px-3 py-2">
          <option value="">Bulan</option>
          @for($m=1;$m<=12;$m++) <option value="{{ $m }}" @selected(request('bulan')==$m)>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option> @endfor
        </select>
        <input type="number" name="tahun" value="{{ request('tahun') }}" placeholder="Tahun" class="border rounded px-3 py-2">
      </div>
      <button class="border rounded px-4 py-2 bg-gray-800 text-white">Terapkan</button>
    </form>

    <div class="overflow-x-auto bg-white border rounded">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
          <tr>
            <th class="px-3 py-2 text-left">Judul</th>
            <th class="px-3 py-2">Periode Waktu</th>
            <th class="px-3 py-2">Jadwal Rilis</th>
            <th class="px-3 py-2">OPD</th>
            <th class="px-3 py-2">Status</th>
          </tr>
        </thead>
        <tbody>
        @forelse($q as $row)
          <tr class="border-t">
            <td class="px-3 py-2">
              <div class="font-medium">{{ $row->judul_dataset }}</div>
              @if($row->dataset)<div class="text-xs text-gray-500">{{ $row->dataset->group?->name }}</div>@endif
            </td>
            <td class="px-3 py-2 text-center">{{ $row->dataset->priode_waktu ?? '-' }}</td>
            <td class="px-3 py-2 text-center">
              {{ $row->release_date->translatedFormat('d M Y') }}
              @if(\Carbon\Carbon::now()->diffInDays($row->release_date,false) >=0 && \Carbon\Carbon::now()->diffInDays($row->release_date) <=7)
                <span class="ml-2 text-xs bg-yellow-200 px-2 py-1 rounded">Terdekat</span>
              @endif
            </td>
            <td class="px-3 py-2 text-center">{{ $row->opd->name }}</td>
            <td class="px-3 py-2 text-center">
              @php $map=['akan_dirilis'=>'bg-blue-100','tertunda'=>'bg-red-100','sudah_dirilis'=>'bg-green-100']; @endphp
              <span class="px-2 py-1 rounded {{ $map[$row->status] }}">{{ str($row->status)->replace('_',' ')->title() }}</span>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-3 py-6 text-center text-gray-500">Belum ada jadwal</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">{{ $q->links() }}</div>
  </div>
</x-app-layout>

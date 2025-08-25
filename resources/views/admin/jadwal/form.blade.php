<x-app-layout>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-xl font-semibold mb-4">
      {{ isset($schedule) ? 'Edit' : 'Tambah' }} Jadwal Rilis Dataset
    </h1>

    {{-- Form Simpan --}}
    <form method="POST"
      action="{{ isset($schedule) 
                ? route('admin.jadwal.update', ['schedule' => $schedule->id]) 
                : route('admin.jadwal.store') }}">
      @csrf
      @if(isset($schedule))
        @method('PUT')
      @endif

      {{-- Judul Dataset --}}
      <label class="block mb-2 text-sm font-medium">
        Judul Dataset <span class="text-red-500">*</span>
      </label>
      <input name="judul_dataset" class="w-full border rounded px-3 py-2 mb-4"
        value="{{ old('judul_dataset', $schedule->judul_dataset ?? '') }}" required />

      {{-- Periode Waktu --}}
      <label class="block mb-2 text-sm font-medium">Periode Waktu</label>
      <input type="text" name="periode_waktu" class="w-full border rounded px-3 py-2 mb-4"
        placeholder="Contoh: 2023 / Januari - Maret"
        value="{{ old('periode_waktu', $schedule->periode_waktu ?? '') }}" />

      {{-- OPD --}}
      <label class="block mb-2 text-sm font-medium">OPD</label>
      <select name="opd_id" class="w-full border rounded px-3 py-2 mb-4">
        @foreach($opds as $o)
          <option value="{{ $o->id }}" 
            @selected(old('opd_id', $schedule->opd_id ?? '') == $o->id)>
            {{ $o->name }}
          </option>
        @endforeach
      </select>

      {{-- Jadwal Rilis + Status --}}
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block mb-2 text-sm font-medium">Jadwal Rilis</label>
          <input type="date" name="release_date" class="w-full border rounded px-3 py-2"
            value="{{ old('release_date', isset($schedule) ? $schedule->release_date->format('Y-m-d') : '') }}">
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium">Status Rilis</label>
          <select name="status" class="w-full border rounded px-3 py-2">
            @foreach(['akan_dirilis','tertunda','sudah_dirilis'] as $s)
              <option value="{{ $s }}" 
                @selected(old('status', $schedule->status ?? 'akan_dirilis') == $s)>
                {{ str($s)->replace('_',' ')->title() }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      {{-- Catatan --}}
      <label class="block mt-4 mb-2 text-sm font-medium">Catatan</label>
      <textarea name="catatan" class="w-full border rounded px-3 py-2">
        {{ old('catatan', $schedule->catatan ?? '') }}
      </textarea>

      {{-- Tombol Simpan --}}
      <div class="mt-6 flex gap-2">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
          Simpan
        </button>
      </div>
    </form>

    {{-- Form Hapus dipisah --}}
    @isset($schedule)
    @role('Admin')
      <form method="POST" 
        action="{{ route('admin.jadwal.destroy', ['schedule' => $schedule->id]) }}"
        class="mt-3" onsubmit="return confirm('Yakin hapus jadwal ini?')">
        @csrf
        @method('DELETE')
        <button class="px-4 py-2 bg-red-600 text-white rounded">
          Hapus
        </button>
      </form>
    @endrole
    @endisset

  </div>
</x-app-layout>

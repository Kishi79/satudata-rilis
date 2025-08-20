<x-app-layout>
 <div class="max-w-3xl mx-auto p-6">
  <h1 class="text-xl font-semibold mb-4">{{ isset($schedule)?'Edit':'Tambah' }} Jadwal</h1>
  <form method="post" action="{{ isset($schedule)?route('jadwal.update',$schedule):route('jadwal.store') }}">
    @csrf @if(isset($schedule)) @method('PUT') @endif
    <label class="block mb-2 text-sm">Dataset (opsional)</label>
    <select name="dataset_id" class="w-full border rounded px-3 py-2 mb-3">
      <option value="">-- pilih --</option>
      @foreach($datasets as $d)
        <option value="{{ $d->id }}" @selected(old('dataset_id',$schedule->dataset_id??'')==$d->id)>
          {{ $d->judul }} ({{ $d->opd->name }})
        </option>
      @endforeach
    </select>

    <label class="block mb-2 text-sm">Judul Dataset (wajib)</label>
    <input name="judul_dataset" class="w-full border rounded px-3 py-2 mb-3"
           value="{{ old('judul_dataset',$schedule->judul_dataset??'') }}"/>

    <label class="block mb-2 text-sm">OPD</label>
    <select name="opd_id" class="w-full border rounded px-3 py-2 mb-3">
      @foreach($opds as $o)
        <option value="{{ $o->id }}" @selected(old('opd_id',$schedule->opd_id??'')==$o->id)>{{ $o->name }}</option>
      @endforeach
    </select>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block mb-2 text-sm">Tanggal Rilis</label>
        <input type="date" name="release_date" class="w-full border rounded px-3 py-2"
               value="{{ old('release_date', isset($schedule)?$schedule->release_date->format('Y-m-d'):'') }}">
      </div>
      <div>
        <label class="block mb-2 text-sm">Status</label>
        <select name="status" class="w-full border rounded px-3 py-2">
          @foreach(['akan_dirilis','tertunda','sudah_dirilis'] as $s)
            <option value="{{ $s }}" @selected(old('status',$schedule->status??'akan_dirilis')==$s)>{{ str($s)->replace('_',' ')->title() }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <label class="block mt-3 mb-2 text-sm">Catatan</label>
    <textarea name="catatan" class="w-full border rounded px-3 py-2">{{ old('catatan',$schedule->catatan??'') }}</textarea>

    <div class="mt-4 flex gap-2">
      <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
      @isset($schedule)
        @role('Admin')
          <form method="post" action="{{ route('jadwal.destroy',$schedule) }}" onsubmit="return confirm('Hapus?')">
            @csrf @method('DELETE')
            <button class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
          </form>
        @endrole
      @endisset
    </div>
  </form>
 </div>
</x-app-layout>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
use App\Models\Dataset;
use App\Models\Schedule;

class ScheduleController extends Controller
{
  // public function __construct(){ $this->middleware('role:Admin|Kontributor'); }

  public function index(Request $r){
    $opds = Opd::orderBy('name')->get();
    $datasets = Dataset::with('opd')->latest()->take(50)->get();
    $q = Schedule::with(['dataset','opd'])
      ->when($r->q, fn($x)=>$x->where('judul_dataset','like',"%{$r->q}%"))
      ->when($r->opd, fn($x)=>$x->where('opd_id',$r->opd))
      ->when($r->status, fn($x)=>$x->where('status',$r->status))
      ->when($r->bulan, fn($x)=>$x->whereMonth('release_date',$r->bulan))
      ->when($r->tahun, fn($x)=>$x->whereYear('release_date',$r->tahun))
      ->orderBy('release_date')->paginate(10)->withQueryString();

    return view('admin.jadwal.index', compact('q','opds','datasets'));
  }

  public function create(){
    return view('admin.jadwal.form',[
      'opds'=>Opd::orderBy('name')->get(),
      'datasets'=>Dataset::with('opd','group')->orderBy('judul')->get()
    ]);
  }

  public function store(Request $r){
    $data = $r->validate([
      'dataset_id'=>'nullable|exists:datasets,id',
      'opd_id'=>'required|exists:opds,id',
      'judul_dataset'=>'required|string|max:255',
      'release_date'=>'required|date',
      'status'=>'required|in:akan_dirilis,tertunda,sudah_dirilis',
      'catatan'=>'nullable|string'
    ]);
    Schedule::create($data);
    return back()->with('ok','Jadwal dibuat');
  }

  public function edit(Schedule $schedule){
    return view('admin.jadwal.form',[
      'schedule'=>$schedule,
      'opds'=>Opd::orderBy('name')->get(),
      'datasets'=>Dataset::orderBy('judul')->get()
    ]);
  }

  public function update(Request $r, Schedule $schedule){
    $data = $r->validate([
      'dataset_id'=>'nullable|exists:datasets,id',
      'opd_id'=>'required|exists:opds,id',
      'judul_dataset'=>'required|string|max:255',
      'release_date'=>'required|date',
      'status'=>'required|in:akan_dirilis,tertunda,sudah_dirilis',
      'catatan'=>'nullable|string'
    ]);
    $schedule->update($data);
    return back()->with('ok','Jadwal diupdate');
  }

  public function destroy(Schedule $schedule){
    $schedule->delete();
    return back()->with('ok','Jadwal dihapus');
  }
}

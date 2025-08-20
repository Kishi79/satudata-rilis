<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Opd;
use App\Models\Group;
use App\Models\Dataset;
use App\Models\Schedule;
class SchedulePublicController extends Controller
{
  public function index(Request $r){
    $opds = Opd::orderBy('name')->get();
    $groups = Group::orderBy('name')->get();

    $q = Schedule::query()->with(['dataset.group','opd'])
      ->when($r->q, fn($x)=>$x->where('judul_dataset','like',"%{$r->q}%"))
      ->when($r->opd, fn($x)=>$x->where('opd_id',$r->opd))
      ->when($r->group, fn($x)=>$x->whereHas('dataset', fn($d)=>$d->where('group_id',$r->group)))
      ->when($r->status, fn($x)=>$x->where('status',$r->status))
      ->when($r->bulan, fn($x)=>$x->whereMonth('release_date',$r->bulan))
      ->when($r->tahun, fn($x)=>$x->whereYear('release_date',$r->tahun))
      ->orderBy('release_date')
      ->paginate(10)->withQueryString();

    $terdekat = Schedule::upcoming()->orderBy('release_date')->first();
    return view('public.jadwal.index', compact('q','opds','groups','terdekat'));
  }
}

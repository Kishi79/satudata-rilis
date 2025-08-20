<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Opd,Group,Dataset};
use Illuminate\Support\Str;

class MasterSeeder extends Seeder {
  public function run(): void {
    // OPD
    $opds = json_decode(file_get_contents(database_path('seeders/data/opds.json')), true)['success'] ? 
            json_decode(file_get_contents(database_path('seeders/data/opds.json')), true)['data'] :
            json_decode(file_get_contents(database_path('seeders/data/opds.json')), true);
    foreach($opds as $o){
      Opd::updateOrCreate(['id'=>$o['id']],[
        'name'=>$o['name']??'-','slug'=>$o['slug']??Str::slug($o['name']??uniqid()),
        'jenis_opd'=>$o['jenis_opd']??null,'alamat'=>$o['alamat']??null,
        'telpon'=>$o['telpon']??null,'email'=>$o['email']??null,'fax'=>$o['fax']??null,'logo'=>$o['gambar']??null,
      ]);
    }

    // DATASET + GROUP (sektoral)
    $datasets = json_decode(file_get_contents(database_path('seeders/data/datasets.json')), true)['datasets']['data'] ?? [];
    foreach($datasets as $d){
      $g = $d['grup'] ?? null;
      $groupId = null;
      if($g){ $groupId = Group::firstOrCreate(['id'=>$g['id']],[
          'name'=>$g['name'], 'slug'=>$g['slug'] ?? Str::slug($g['name'])
      ])->id; }
      Dataset::updateOrCreate(['external_id'=>$d['id']],[
        'judul'=>$d['judul'],'slug'=>$d['slug'] ?? Str::slug($d['judul']),
        'opd_id'=>$d['opd_id'],'group_id'=>$groupId,'priode_waktu'=>$d['priode_waktu'] ?? null,
      ]);
    }
  }
}

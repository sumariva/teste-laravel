<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Uf;

class DatabaseSeeder extends Seeder
{
    /**
     * Popular a base com as entradas fixas
     *
     * @return void
     */
    public function run()
    {
        foreach ( Uf::all() as $uf ){
            $uf->delete();
        }
        $ufs = array( Uf::PR,'RS','SC','SP','RJ','ES','MT','MS');
        foreach ( $ufs as $uftext ){
            $uf = Uf::create( array('nome' => $uftext) );
            $uf->save();
        }
    }
}

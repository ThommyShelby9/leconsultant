<?php

namespace App\Http\Livewire;

use Livewire\Component;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Autorite;
use App\Models\Direction;
use App\Models\Categorie;

class AcByCategorie extends Component
{
    public $selectCateg = null;
    public $selectAc= null ;
    public $les_ac= null;
    public $les_directions = null;


    public function render()
    {

        if(!empty($this->selectCateg)) {
            $this->les_ac = DB::table('autorites')->where('categ_id', $this->selectCateg)->get(['id', 'name']);
        }

        if(!empty($this->selectAc)) {
            $this->les_directions  = DB::table('directions')->where('aut_id', $this->selectAc)->get();
        }

        $categ = Categorie::all();

        return view('livewire.ac-by-categorie',['les_categories'=>$categ ]);
    }

    public function updatedSelectCateg($categ_choice) {
        $this->les_ac = null;
        $this->les_ac = DB::table('autorites')->where('categ_id', $categ_choice)->get(['id', 'name']);
    }

    public function updatedSelectAc($ac_choice) {
        $this->les_directions  = DB::table('directions')->where('aut_id', $ac_choice)->get();
    }

}

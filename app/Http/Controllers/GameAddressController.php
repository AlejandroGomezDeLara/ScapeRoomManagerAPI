<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use stdClass;

class GameAddressController extends Controller
{
    public function index(){
        $addresses=[];
        $games=Game::all();
        foreach ($games as $game) {
            $address=new stdClass();
            $address->id=$game->id;
            $address->address=$game->address;
            array_push($addresses,$address);
        }
        return $addresses;
    }
}

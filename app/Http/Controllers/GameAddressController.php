<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use stdClass;

class GameAddressController extends Controller
{
    public function index(Request $request)
    {
        $max_price = $request->max_price;
        $min_price = $request->min_price;
        $max_people = $request->max_people;
        $min_people = $request->min_people;
        $min_duration = $request->min_duration;
        $max_duration = $request->max_duration;
        $categories = preg_split('@,@', $request->selected_categories, -1, PREG_SPLIT_NO_EMPTY);
        $subcategories = preg_split('@,@', $request->selected_subcategories, -1, PREG_SPLIT_NO_EMPTY);

        /* searchbar */

        $selected_name = $request->selected_name;
        $selected_address = $request->selected_address;

        if (!empty($categories) && !empty($subcategories)) {
            $games = Game::where('min_price', '>=', $min_price)
                ->where('min_price', '<=', $max_price)
                ->where('max_duration', '>=', $min_duration)
                ->where('max_duration', '<=', $max_duration)
                ->where('max_people', '>=', $min_people)
                ->where('max_people', '<=', $max_people)
                ->whereIn('category_id', $categories)
                ->where('name', 'like', '%' . $selected_name . '%')
                ->where('address', 'like', '%' . $selected_address . '%')
                ->get();
        } else if (!empty($categories)) {
            $games = Game::where('min_price', '>=', $min_price)
                ->where('min_price', '<=', $max_price)
                ->where('max_duration', '>=', $min_duration)
                ->where('max_duration', '<=', $max_duration)
                ->where('max_people', '>=', $min_people)
                ->where('max_people', '<=', $max_people)
                ->whereIn('category_id', $categories)
                ->where('name', 'like', '%' . $selected_name . '%')
                ->where('address', 'like', '%' . $selected_address . '%')
                ->get();
        } else if (!empty($subcategories)) {
            $games = Game::where('min_price', '>=', $min_price)
                ->where('min_price', '<=', $max_price)
                ->where('max_duration', '>=', $min_duration)
                ->where('max_people', '>=', $min_people)
                ->where('max_duration', '<=', $max_duration)
                ->where('max_people', '<=', $max_people)
                ->whereIn('subcategory_id', $subcategories)
                ->where('name', 'like', '%' . $selected_name . '%')
                ->where('address', 'like', '%' . $selected_address . '%')
                ->get();
        } else {
            $games = Game::where('min_price', '>=', $min_price)
                ->where('min_price', '<=', $max_price)
                ->where('max_duration', '>=', $min_duration)
                ->where('max_duration', '<=', $max_duration)

                ->where('max_people', '>=', $min_people)
                ->where('max_people', '<=', $max_people)
                ->where('name', 'like', '%' . $selected_name . '%')
                ->where('address', 'like', '%' . $selected_address . '%')
                ->get();
        }

        return $games;
    }
}

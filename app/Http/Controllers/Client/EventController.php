<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\models\website\Event;

class EventController extends Controller
{
    public function list()
    {
        $data['events'] = Event::active()->homeOrder()->paginate(12);

        return view('event.list', $data);
    }

    public function detail($slug)
    {
        $detail = Event::active()->where('slug', $slug)->first();
        if (!$detail) {
            abort(404);
        }

        $data['detail'] = $detail;
        $data['related'] = Event::active()->where('id', '!=', $detail->id)->homeOrder()->limit(3)->get();

        return view('event.detail', $data);
    }
}

<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\models\website\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function list(Request $request)
    {
        $keyword = trim((string) $request->keyword);

        $data = Event::when($keyword !== '', function ($q) use ($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%');
            })
            ->orderBy('event_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->get(['id', 'title', 'slug', 'image', 'event_date', 'event_time', 'location', 'tag', 'status']);

        return response()->json(['data' => $data, 'message' => 'success'], 200);
    }

    public function save(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:2000',
        ]);

        $event = $request->id ? Event::find($request->id) : null;
        if (!$event) {
            $event = new Event();
        }

        $event->fill([
            'title' => trim($request->title),
            'slug' => Event::uniqueSlug($request->title, $event->id),
            'image' => $request->image ?: null,
            'event_date' => $request->event_date ?: null,
            'event_time' => $request->event_time ?: null,
            'location' => $request->location ?: null,
            'tag' => $request->tag ?: null,
            'content' => $request->content ?: null,
            'status' => (int) ($request->status ?? 1),
        ]);
        $event->save();

        return response()->json(['data' => $event, 'message' => 'success'], 200);
    }

    public function edit($id)
    {
        $data = Event::find($id);

        return response()->json(['data' => $data, 'message' => 'success'], 200);
    }

    public function delete($id)
    {
        Event::where('id', $id)->delete();

        return response()->json(['message' => 'Delete Success'], 200);
    }
}

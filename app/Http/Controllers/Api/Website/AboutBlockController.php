<?php

namespace App\Http\Controllers\Api\Website;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\models\website\AboutBlock;

class AboutBlockController extends Controller
{
    public function createOrUpdate(Request $request)
    {
        $rows = is_array($request->data) ? $request->data : [];

        DB::transaction(function () use ($rows) {
            AboutBlock::query()->delete();
            foreach ($rows as $index => $value) {
                $items = collect($value['items'] ?? [])
                    ->map(function ($item) {
                        return [
                            'title' => trim((string) ($item['title'] ?? '')),
                            'description' => trim((string) ($item['description'] ?? '')),
                        ];
                    })
                    ->filter(function ($item) {
                        return $item['title'] !== '' || $item['description'] !== '';
                    })
                    ->values()
                    ->all();

                AboutBlock::create([
                    'title' => trim((string) ($value['title'] ?? '')),
                    'intro' => trim((string) ($value['intro'] ?? '')),
                    'items' => $items,
                    'image' => $value['image'] ?? null,
                    'decor' => (int) ($value['decor'] ?? 1),
                    'sort' => $index + 1,
                    'status' => (int) ($value['status'] ?? 1),
                ]);
            }
        });

        return response()->json(['message' => 'success'], 200);
    }

    public function list()
    {
        $data = AboutBlock::orderBy('sort')->get();

        return response()->json(['message' => 'success', 'data' => $data], 200);
    }
}

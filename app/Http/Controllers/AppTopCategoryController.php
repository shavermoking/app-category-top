<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\AppTopPosition;

class AppTopCategoryController extends Controller
{
    public function getAppTopPositions(Request $request): JsonResponse
    {
        $date = $request->input('date');

        if (!$date) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Date parameter is required',
                'data' => []
            ], 400);
        }

        // Получаем данные из базы для указанной даты
        $positions = AppTopPosition::forDate((string) $date)->get();

        if ($positions->isEmpty()) {
            return response()->json([
                'status_code' => 404,
                'message' => 'No data found for the specified date',
                'data' => []
            ], 404);
        }

        // Преобразуем данные в нужный формат
        $result = [];
        foreach ($positions as $position) {
            $result[$position->category] = $position->position;
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'ok',
            'data' => $result
        ]);
    }
}

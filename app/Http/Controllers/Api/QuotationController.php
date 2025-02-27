<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

final class QuotationController extends Controller
{
    public function getQuotation(QuotationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $ages = explode(',', $data['age']);

        $tripLength = Carbon::parse($data['start_date'])->diffInDays(Carbon::parse($data['end_date'])) + 1;

        $totalPrice = 0;

        foreach ($ages as $age) {
            $totalPrice += Constants::FIXED_RATE * $this->calculateAgeLoad($age) * $tripLength;
        }

        return $this->sendSuccessResponse(data: [
            'total' => number_format($totalPrice, 2),
            'currency_id' => $data['currency_id'],
            'quotation_id' => rand(1000, 9999),
        ]);
    }

    private function calculateAgeLoad($age): float
    {
        foreach (Constants::AGE_BRACKETS as $bracket) {
            if ($age >= $bracket['min'] && $age <= $bracket['max']) {
                return $bracket['load'];
            }
        }
        return 1.0;
    }
}

<?php

namespace App\Http\Resources;

use App\Traits\UseFormattedCurrency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionItemResource extends JsonResource
{
    use UseFormattedCurrency;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->formatCurrency($this->price),
            'total_amount' => $this->formatCurrency($this->total_amount),
        ];
    }
}

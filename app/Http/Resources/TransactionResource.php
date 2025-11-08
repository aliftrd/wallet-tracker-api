<?php

namespace App\Http\Resources;

use App\Traits\UseFormattedCurrency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'id' => $this->id,
            'type' => $this->type,
            'category' => new UserCategoryResource($this->category),
            'store_name' => $this->store_name,
            'date' => $this->date,
            'note' => $this->note,
            'items' => TransactionItemResource::collection($this->items),
            'tax_amount' => $this->formatCurrency($this->tax_amount),
            'total_amount' => $this->formatCurrency($this->total_amount),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

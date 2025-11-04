<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Enums\TransactionTypeEnum;
use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    public function mount(): void
    {
        parent::mount();

        // Pre-fill user_id from query parameter if provided
        if ($userId = request()->query('user_id')) {
            $this->form->fill([
                'user_id' => $userId,
            ]);
        }
    }

    protected function afterCreate(): void
    {
        $transaction = $this->record;
        if ($transaction->type === TransactionTypeEnum::INCOME) {
            $transaction->wallet->balance += $transaction->total_amount;
        } else {
            $transaction->wallet->balance -= $transaction->total_amount;
        }
        $transaction->wallet->save();
    }
}

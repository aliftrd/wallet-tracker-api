<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use App\Enums\TransactionTypeEnum;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    public ?array $oldData = null;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
                    $this->record->revertFromWallet($this->record->wallet);
                }),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->oldData = $data;
        return $data;
    }

    protected function afterSave(): void
    {
        // Get old values
        $oldTotalAmount = $this->oldData['total_amount'] ?? 0;
        $oldType = TransactionTypeEnum::from($this->oldData['type'] ?? null);
        $oldWalletId = $this->oldData['wallet_id'] ?? null;

        // Update wallet balance using the model method
        $this->record->updateWalletBalanceOnEdit($oldWalletId, $oldType, $oldTotalAmount);
    }
}

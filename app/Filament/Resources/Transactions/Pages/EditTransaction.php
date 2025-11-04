<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use App\Enums\TransactionTypeEnum;
use App\Models\Wallet;
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
                    $transaction = $this->record;
                    $wallet = $transaction->wallet;

                    // Revert the transaction from wallet balance
                    if ($transaction->isIncome()) {
                        $wallet->balance -= $transaction->total_amount;
                    } elseif ($transaction->isExpense()) {
                        $wallet->balance += $transaction->total_amount;
                    }

                    $wallet->save();
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
        $transaction = $this->record;
        $wallet = $transaction->wallet;

        // Get old values
        $oldTotalAmount = $this->oldData['total_amount'] ?? 0;
        $oldType = TransactionTypeEnum::from($this->oldData['type'] ?? null);
        $oldWalletId = $this->oldData['wallet_id'] ?? null;

        // If wallet changed, we need to revert old wallet and update new wallet
        if ($oldWalletId && $oldWalletId != $transaction->wallet_id) {
            $oldWallet = Wallet::findOrFail($oldWalletId);
            if ($oldWallet) {
                // Revert the old transaction from old wallet
                if ($oldType === TransactionTypeEnum::INCOME) {
                    $oldWallet->balance -= $oldTotalAmount;
                } elseif ($oldType === TransactionTypeEnum::EXPENSE) {
                    $oldWallet->balance += $oldTotalAmount;
                }
                $oldWallet->save();
            }

            // Apply new transaction to new wallet
            if ($transaction->isIncome()) {
                $wallet->balance += $transaction->total_amount;
            } elseif ($transaction->isExpense()) {
                $wallet->balance -= $transaction->total_amount;
            }
        } else {
            // Same wallet, calculate the difference
            // First, revert the old transaction
            if ($oldType === TransactionTypeEnum::INCOME) {
                $wallet->balance -= $oldTotalAmount;
            } else {
                $wallet->balance += $oldTotalAmount;
            }

            // Then, apply the new transaction
            if ($transaction->isIncome()) {
                $wallet->balance += $transaction->total_amount;
            } elseif ($transaction->isExpense()) {
                $wallet->balance -= $transaction->total_amount;
            }
        }

        $wallet->save();
    }
}

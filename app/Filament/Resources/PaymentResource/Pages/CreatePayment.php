<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected  function afterCreate(): void
    {
        $payment = $this->record;

        // Ödəniş edən müştərini tapın.
        $customer = User::find($payment->user_id);

        // Müştərinin borcunu ödəniş məbləği qədər azaldın.
        // Ehtiyatlı olun, borc mənfiyə düşməməlidir.
        $newDebt = max(0, $customer->debt - $payment->sum);

        // Müştərinin yeni borcunu bazada yeniləyin.
        $customer->debt = $newDebt;
        $customer->save();
    }
}

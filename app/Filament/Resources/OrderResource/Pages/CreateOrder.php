<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class CreateOrder extends CreateRecord
{
    use HasWizard;
    protected static string $resource = OrderResource::class;

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps())
                    ->contained(false),
            ])
            ->columns(null);
    }
    protected function getSteps(): array
    {
        return [
            Step::make('Order Details')
                ->schema([
                    Section::make()->schema(OrderResource::getDetailsFormSchema())->columns(),
                ]),

            Step::make('Order Items')
                ->schema([
                    Section::make()->schema([
                        OrderResource::getItemsRepeater(),
                    ]),
                ]),
        ];
    }
    protected function afterCreate(): void
    {
        $order = $this->record; // Bu, güncellenen sipariş nesnesidir.
        $totalPrice = $order->items->sum(function ($item) {
            return $item->price * $item->qty; // Her sipariş öğesinin toplam fiyatını hesapla.
        });

        $order->update(['total_price' => $totalPrice]); // Siparişin toplam fiyatını güncelle.


    }

}

<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class TotalRevenueChart extends Component
{
    protected function getData(): array
    {
        $data = Order::query()
            ->select('order_date', \DB::raw('sum(total) as total'))
            ->where('order_date', '>=', now()->subDays(7))
            ->groupBy('order_date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total revenue from last 7 days',
                    'data' => $data->map(fn (Order $order) => $order->total / 100),
                ]
            ],
            'labels' => $data->map(fn (Order $order) => $order->order_date->format('d/m/Y')),
        ];
    }

    public function updateChartData(): void
    {
        $this->emitSelf('updateChartData', [
            'data' => $this->getData(),
        ]);
    }

    public function render()
    {
        return view('livewire.total-revenue-chart');
    }
}

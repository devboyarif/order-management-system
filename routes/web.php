<?php

use App\Models\Order;
use App\Models\Product;
use App\Http\Livewire\OrderForm;
use App\Http\Livewire\OrdersList;
use App\Http\Livewire\ProductForm;
use App\Http\Livewire\ProductsList;
use App\Http\Livewire\CategoriesList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return $data = Order::query()
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

    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('orders', OrdersList::class)->name('orders.index');
    Route::get('orders/create', OrderForm::class)->name('orders.create');
    Route::get('orders/{order}', OrderForm::class)->name('orders.edit');
    Route::get('categories', CategoriesList::class)->name('categories.index');
    Route::get('products', ProductsList::class)->name('products.index');
    Route::get('products/create', ProductForm::class)->name('products.create');
    Route::get('products/{product}', ProductForm::class)->name('products.edit');
});

require __DIR__.'/auth.php';

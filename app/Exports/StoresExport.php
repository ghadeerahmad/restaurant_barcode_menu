<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StoresExport implements FromCollection, WithHeadings
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //return collect($this->data);
        $orders = null;
        if (isset($this->data['orders'])) $orders = $this->data['orders'];
        $stores = $this->data['stores'];
        $sheet = [];
        foreach ($stores as $store) {
            $total = 0;
            $branches = count($store->branches) > 0 ? count($store->branches) : 0;
            $tables = count($store->tables) > 0 ? count($store->tables) : 0;
            $categories = count($store->product_categories) > 0 ? count($store->product_categories) : 0;
            $products = count($store->products) > 0 ? count($store->products) : 0;
            $count = count($store->orders) > 0 ? count($store->orders) : 0;
            if ($orders != null && count($orders) > 0) {

                foreach ($orders as $order)
                    if ($order->store_id == $store->id) {
                        $total = $order->total;
                        if ($order->ordersCount > 0)
                            $count = $order->ordersCount;
                    }
            } else
                foreach ($store->orders as $order) $total += $order->total;

            array_push($sheet, [
                'name' => get_local_name($store->name_ar, $store->name_en),
                'email' => $store->email,
                'phone' => $store->phone,
                'branches' => $branches,
                'tables' => $tables,
                'categories' => $categories,
                'products' => $products,
                'orders' => $count,
                'orders_total' => $total . $store->currency->code,
                'plan' => get_local_name($store->plan->name_ar, $store->plan->name_en),
                'created_at' => $store->created_at,
                'sub_end' => $store->sub_end,
                'sub_value' => $store->plan->price . $store->plan->currency->code
            ]);
        }
        //if($orders != null)
        return collect($sheet);
    }
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'branches',
            'tables',
            'categories',
            'products',
            'orders',
            'orders total',
            'plan',
            'Created_at',
            'Subscription End',
            'Subscription Value'
        ];
    }
}

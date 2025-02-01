<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class EmailPreviewController extends Controller
{
        public function __invoke(){
            request()->validate([
                'customer' => ['required', 'string'],
                'email' => ['required', 'email'],
                'payment_method' => ['required', 'in:1,2,3'], 
                'products' => ['required', 'array'],
                'products.*.name' => ['required', 'string', 'max:50'],
                'products.*.price' => ['required', 'numeric', 'gt:0'],
                'products.*.quantity' => ['required', 'integer', 'gte:1'],

            ]);

            $request = request()->all();

            $data = [
                'customer' => $request['customer'],
                'created_at' => now() -> format('Y-m-d H:i:s'),
                'email' => $request['email'],
                'order_number' => 'RB'.now()->format('Y').now()->format('m').'-'.rand(1,100),
                'payment_method' => match($request['payment_method']) {
                    1 => 'Transferencia bancaria',
                    2 => 'Contraentrega',
                    3 => 'Tarjeta de crédito',
                }, 
                'order_status' => match($request['payment_method']) {
                    1 => 'Pendiente de revisión',
                    2 => 'En proceso',
                    3 => 'En proceso',
                },
                

            ];  
            // Inicializamos una variable para calcular el total

            $total = 0;
            // se itera el arreglo de productos
            foreach($request['products'] as $product) {
                // calculo del subtotal
                $subtotal = $product['price'] * $product['quantity'];
                $data['products'][] = [
                    'name' => $product['name'],
                    'price'=> number_format($product['price'], 2),
                    'quantity' => $product['quantity'],
                    'subtotal' => number_format($subtotal,2),
                ];
                //el total es la suma de los subtotales
                $total += $subtotal;
            }
            $data['total'] = number_format($total, 2);

            return view('EmailPreview', $data);
        }
    }
  
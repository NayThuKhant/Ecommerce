<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use http\Env\Response;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{

    public function isCancelled(Order $order)
    {
        return $order->cancellation()->exists();
    }

    public function confirmOrder(Order $order)
    {
        if ($this->isCancelled($order)) {
            return redirect()->back()->with('error', 'The order was cancelled and there\' nothing to do');
        } else {
            $order->orderStatus->update([
                'confirmed_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', 'Successfully confirmed');
        }

    }

    public function proceedOrder(Order $order)
    {
        if ($this->isCancelled($order)) {
            return redirect()->back()->with('error', 'The order was cancelled and there\' nothing to do');
        } else {
            if ($order->orderStatus->confirmed_at) {
                $order->orderStatus->update([
                    'processed_at' => date('Y-m-d H:i:s')
                ]);
                return redirect()->back()->with('success', 'Successfully proceeded');
            } else {
                return redirect()->back()->with('fail', 'You have to confirm the order first');
            }
        }

    }

    public function shipOrder(Order $order)
    {
        if ($this->isCancelled($order)) {
            return redirect()->back()->with('error', 'The order was cancelled and there\' nothing to do');
        } else {
            if ($order->orderStatus->processed_at) {
                $order->orderStatus->update([
                    'shipped_at' => date('Y-m-d H:i:s')
                ]);
                return redirect()->back()->with('success', 'Successfully shipped');
            } else {
                return redirect()->back()->with('fail', 'You have to proceed the order first');
            }
        }

    }

    public function deliverOrder(Order $order)
    {
        if ($this->isCancelled($order)) {
            return redirect()->back()->with('error', 'The order was cancelled and there\' nothing to do');
        } else {
            if ($order->orderStatus->shipped_at) {
                $order->orderStatus->update([
                    'delivered_at' => date('Y-m-d H:i:s'),
                    'paid_at' => date('Y-m-d H:i:s')
                ]);
                return redirect()->back()->with('success', 'successfully delivered');
            } else {
                return redirect()->back()->with('fail', 'You have to ship the order first');
            }
        }


    }
}

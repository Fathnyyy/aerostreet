<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Alur status order:
     * pending → pending_verification → paid → processing → shipped → completed
     *                                                    ↘ cancelled (kapanpun)
     */

    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $stats = [
            'total'               => Order::count(),
            'pending'             => Order::where('status', 'pending')->count(),
            'pending_verification'=> Order::where('status', 'pending_verification')->count(),
            'paid'                => Order::where('status', 'paid')->count(),
            'processing'          => Order::where('status', 'processing')->count(),
            'shipped'             => Order::where('status', 'shipped')->count(),
            'completed'           => Order::where('status', 'completed')->count(),
            'revenue'             => Order::whereIn('status', ['paid','processing','shipped','completed'])->sum('total_price'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,pending_verification,paid,processing,shipped,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        Log::info("Admin updated order {$order->order_number}: {$oldStatus} → {$request->status}");

        $statusLabels = [
            'paid'       => '✅ Pembayaran dikonfirmasi — pesanan siap diproses.',
            'processing' => '📦 Pesanan sedang dikemas & disiapkan.',
            'shipped'    => '🚚 Pesanan sudah dikirim ke kurir.',
            'completed'  => '🎉 Pesanan selesai & diterima pelanggan.',
            'cancelled'  => '❌ Pesanan dibatalkan.',
        ];

        $message = $statusLabels[$request->status] ?? "Status diperbarui ke {$request->status}";

        return back()->with('success', $message);
    }
}

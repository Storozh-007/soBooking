<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CheckOut extends Component
{
    public $search = '';
    public $actionView = null; // 'checkout', 'delay', 'early_checkout', 'receipt'
    public $selectedBooking = null;

    public $newEndDate = null;
    public $receipt = null;
    public $receiptType = ''; // 'standard', 'delay', 'refund'
    
    public function mount()
    {
        $this->newEndDate = Carbon::today()->format('Y-m-d');
    }

    public function selectAction($action, $bookingId)
    {
        $this->actionView = $action;
        $this->selectedBooking = Booking::with(['user', 'apartment'])->findOrFail($bookingId);
        
        if ($action === 'delay') {
            $this->newEndDate = Carbon::parse($this->selectedBooking->end_date)->addDay()->format('Y-m-d');
        } elseif ($action === 'early_checkout') {
            $this->newEndDate = Carbon::today()->format('Y-m-d');
        }
    }

    public function cancelAction()
    {
        $this->actionView = null;
        $this->selectedBooking = null;
        $this->receipt = null;
    }

    public function processCheckout()
    {
        $booking = $this->selectedBooking;
        $booking->update(['status' => 'completed']);
        $booking->apartment->update(['status' => 'cleaning']);

        $this->receiptType = 'standard';
        $this->generateReceipt($booking, 0, 'Standard Checkout Complete');
        $this->actionView = 'receipt';
    }

    public function processDelay()
    {
        $this->validate([
            'newEndDate' => 'required|date|after:' . Carbon::parse($this->selectedBooking->end_date)->format('Y-m-d')
        ]);

        $booking = $this->selectedBooking;
        $extraDays = Carbon::parse($booking->end_date)->diffInDays(Carbon::parse($this->newEndDate));
        $extraCost = $extraDays * $booking->apartment->price;

        $booking->update([
            'end_date' => $this->newEndDate,
            'total_price' => $booking->total_price + $extraCost
        ]);

        $this->receiptType = 'delay';
        $this->generateReceipt($booking, $extraCost, 'Extension Payment Required');
        $this->actionView = 'receipt';
    }

    public function processEarlyCheckout()
    {
        $this->validate([
            'newEndDate' => 'required|date|before:' . Carbon::parse($this->selectedBooking->end_date)->format('Y-m-d')
        ]);

        $booking = $this->selectedBooking;
        $savedDays = Carbon::parse($this->newEndDate)->diffInDays(Carbon::parse($booking->end_date));
        $refundAmount = $savedDays * $booking->apartment->price;

        $booking->update([
            'end_date' => $this->newEndDate,
            'total_price' => $booking->total_price - $refundAmount,
            'status' => 'completed'
        ]);
        
        $booking->apartment->update(['status' => 'cleaning']);

        $this->receiptType = 'refund';
        $this->generateReceipt($booking, $refundAmount, 'Early Departure Refund');
        $this->actionView = 'receipt';
    }

    private function generateReceipt($booking, $differenceAmount, $title)
    {
        $this->receipt = [
            'booking_id' => $booking->id,
            'title' => $title,
            'guest_name' => $booking->user->name,
            'passport' => $booking->user->passport_data,
            'room_title' => $booking->apartment->title,
            'room_class' => $booking->apartment->room_class ?: 'Standard',
            'original_start' => $booking->start_date,
            'new_end' => $booking->end_date,
            'difference_amount' => $differenceAmount / 100,
            'total_amount' => $booking->total_price / 100,
            'date_issued' => now()->format('Y-m-d H:i:s'),
        ];
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $query = Booking::with(['user', 'apartment'])
            ->where('status', 'confirmed') // Show all confirmed bookings so user can test features
            ->orderBy('end_date', 'asc');

        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->whereHas('user', function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('passport_data', 'like', $searchTerm);
            })->orWhereHas('apartment', function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm);
            });
        }

        return view('livewire.admin.check-out', [
            'activeBookings' => $query->get()
        ]);
    }
}

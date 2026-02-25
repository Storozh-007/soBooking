<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class GuestList extends Component
{
    use WithPagination;

    public string $search = '';
    public $selectedGuestId = null;
    
    // Edit Form State
    public $isEditing = false;
    public $editName = '';
    public $editEmail = '';
    public $editPhone = '';
    public $editPassport = '';

    public function viewGuest($id)
    {
        $this->selectedGuestId = $id;
        $this->isEditing = false; // Reset edit state when opening new guest
        $this->dispatch('open-guest-modal');
    }

    public function closeGuest()
    {
        $this->isEditing = false;
        $this->dispatch('close-guest-modal');
        // We do NOT nullify selectedGuestId immediately so the modal can animate out,
        // it will just be replaced on the next viewGuest call.
    }

    public function toggleEdit()
    {
        if (!$this->isEditing && $this->selectedGuestId) {
            $guest = User::find($this->selectedGuestId);
            $this->editName = $guest->name ?? '';
            $this->editEmail = $guest->email ?? '';
            $this->editPassport = $guest->passport_data ?? '';
            
            // Get phone from latest booking if exists
            $latestBooking = $guest->bookings()->orderBy('start_date', 'desc')->first();
            $this->editPhone = $latestBooking ? (string)$latestBooking->phone : '';
        }
        $this->isEditing = !$this->isEditing;
    }

    public function saveGuest()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editEmail' => 'required|email|max:255|unique:users,email,' . $this->selectedGuestId,
            'editPhone' => 'nullable|string|max:20',
            'editPassport' => 'nullable|string|max:50',
        ]);

        $guest = User::find($this->selectedGuestId);
        $guest->update([
            'name' => $this->editName,
            'email' => $this->editEmail,
            'passport_data' => $this->editPassport,
        ]);

        // Update phone on all active/future bookings if provided
        if ($this->editPhone) {
            $guest->bookings()
                  ->whereIn('status', ['pending', 'approved', 'confirmed', 'active'])
                  ->update(['phone' => $this->editPhone]);
        }

        $this->isEditing = false; // Close edit mode after saving
        $this->dispatch('guest-saved'); // Optional trigger for front-end success state
        session()->flash('message', 'Дані гостя успішно оновлено.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $query = User::whereHas('bookings')
            ->with(['bookings' => function($q) {
                $q->orderBy('start_date', 'desc')->with('apartment');
            }]);

        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('passport_data', 'like', $searchTerm)
                  ->orWhereHas('bookings', function($b) use ($searchTerm) {
                      $b->where('phone', 'like', $searchTerm)
                        ->orWhereHas('apartment', function($a) use ($searchTerm) {
                            $a->where('title', 'like', $searchTerm);
                        });
                  });
            });
        }

        $selectedGuest = null;
        if ($this->selectedGuestId) {
            $selectedGuest = User::with(['bookings' => function($q) {
                $q->orderBy('start_date', 'desc')->with('apartment');
            }])->find($this->selectedGuestId);
        }

        return view('livewire.admin.guest-list', [
            'guests' => $query->paginate(12),
            'selectedGuest' => $selectedGuest
        ]);
    }
}

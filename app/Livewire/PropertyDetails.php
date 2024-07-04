<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class PropertyDetails extends Component
{
    public $propertyId;
    public $property;

    public function mount($propertyId)
    {
        $this->propertyId = $propertyId;
        $this->property = Property::findOrFail($this->propertyId);
    }

    public function render()
    {
        return view('livewire.property-details');
    }

    public function signOut()
    {
        auth()->logout();
        return redirect('/login');
    }
}

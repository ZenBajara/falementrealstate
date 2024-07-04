<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Property;
use App\Models\PropertyType;

class Home extends Component
{
    use WithPagination;

    public $searchQuery = '';
    public $priceRangeMin = 0;
    public $priceRangeMax = 1000000;
    public $propertyType = '';
    public $startDate = '';
    public $endDate = '';
    public $isFilterModalVisible = false;
    public $isLoading = true;

    public $hasMoreProperties = true;

    public function mount()
    {
        $this->isLoading = false;
    }

    public function showFilterModal()
    {
        $this->isFilterModalVisible = true;
    }


    public function applyFilters()
    {
        $this->isFilterModalVisible = false;
    }

    public function signOut()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function render()
    {
        $properties = Property::query()
            ->when($this->searchQuery, function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('state', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('country', 'like', '%' . $this->searchQuery . '%');
            })
            ->when($this->priceRangeMin || $this->priceRangeMax, function ($query) {
                $query->whereBetween('price', [$this->priceRangeMin, $this->priceRangeMax]);
            })
            ->when($this->propertyType, function ($query) {
                $query->where('property_type_id', $this->propertyType);
            })
            ->when($this->startDate || $this->endDate, function ($query) {
                if ($this->startDate && $this->endDate) {
                    $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
                } elseif ($this->startDate) {
                    $query->whereDate('created_at', '>=', $this->startDate);
                } elseif ($this->endDate) {
                    $query->whereDate('created_at', '<=', $this->endDate);
                }
            })
            ->paginate(9);

        $featuredProperties = Property::where('is_featured', true)->get();
        $propertyTypes = PropertyType::all();

        return view('livewire.home', [
            'properties' => $properties,
            'featuredProperties' => $featuredProperties,
            'propertyTypes' => $propertyTypes,
        ]);
    }

    public function closeFilterModal()
    {
        $this->isFilterModalVisible = false;
    }
}

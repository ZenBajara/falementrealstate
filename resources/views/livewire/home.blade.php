<div>
    <!-- Main Content -->
    @unless ($isLoading)
        <!-- Header Section -->
        <section class="w-full px-8 text-gray-700 bg-white shadow-md mb-8">
            <div class="container flex flex-col flex-wrap items-center justify-between py-3 mx-auto md:flex-row max-w-7xl">
                <div class="relative flex flex-col md:flex-row items-center">
                    <a href="{{ url('/') }}" class="flex items-center mb-5 font-medium text-gray-900 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                        <img src="{{ asset('asset/realstate_logo.png') }}" class="w-24 h-16" alt="Real Estate Logo">
                    </a>
                    <nav class="flex flex-wrap items-center mb-5 text-base md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-200">
                        <a href="{{ url('/') }}" class="mr-5 font-medium leading-6 text-gray-600 hover:text-gray-900">Home</a>
                    </nav>
                </div>
                <div class="inline-flex items-center ml-5 space-x-6 lg:justify-end">
                    @auth
                        <a href="#" wire:click.prevent="signOut" class="inline-flex items-center justify-center px-4 py-2 text-base font-medium leading-6 text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                            Sign Out
                        </a>
                    @else
                        <a href="{{ url('admin/login') }}" class="inline-flex items-center justify-center px-4 py-2 text-base font-medium leading-6 text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <div class="w-full flex items-center justify-center">
            <div class="w-full">
                <div x-data="{ activeSlide: 1, slideCount: {{ $featuredProperties->count() }} }" class="overflow-hidden relative">
                    <!-- Slider -->
                    <div class="whitespace-nowrap transition-transform duration-500 ease-in-out"
                        :style="'transform: translateX(-' + (activeSlide - 1) * 100 + '%)'"
                        x-init="setInterval(() => { activeSlide = activeSlide < slideCount ? activeSlide + 1 : 1 }, 5000)">
                        @foreach ($featuredProperties as $index => $property)
                            <div class="inline-block w-full h-screen">
                                <img src="{{ asset('storage/' . $property->images[0]) }}"
                                    alt="Property Image"
                                    class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation Arrows -->
                    <div class="absolute inset-0 flex items-center justify-between px-4">
                        <button @click="activeSlide = activeSlide > 1 ? activeSlide - 1 : slideCount"
                                class="w-10 h-10 flex items-center justify-center bg-black/30 text-white p-2 rounded-full">
                            &#8592;
                        </button>
                        <button @click="activeSlide = activeSlide < slideCount ? activeSlide + 1 : 1"
                                class="w-10 h-10 flex items-center justify-center bg-black/30 text-white p-2 rounded-full">
                            &#8594;
                        </button>
                    </div>

                    <!-- Dots Navigation -->
                    <div class="absolute bottom-0 left-0 right-0 flex justify-center space-x-2 p-4">
                        <template x-for="slideIndex in slideCount" :key="slideIndex">
                            <button @click="activeSlide = slideIndex"
                                    class="h-2 w-2 rounded-full"
                                    :class="{'bg-orange-500': activeSlide === slideIndex, 'bg-white/50': activeSlide !== slideIndex}">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>




        <!-- Search Bar and Filters -->
        <section class="bg-gray-50 py-12">
            <div class="container px-4 mx-auto sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold text-gray-900 sm:text-3xl lg:text-4xl text-center mb-8">Latest Properties</h2>

                <!-- Search Input -->
                <div class="flex justify-center mb-8">
                    <input wire:model.debounce.300ms="searchQuery" type="text" placeholder="Search properties..." class="px-4 py-2 border border-gray-300 rounded-lg w-full sm:w-1/2">
                </div>

                <!-- Filters and Badges -->
                <div class="flex items-center mb-8">
                    <!-- Applied Filters Badges -->
                    <div class="flex space-x-2 mb-4">
                        @if ($priceRangeMin || $priceRangeMax)
                            <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                                Price: {{ $priceRangeMin }} - {{ $priceRangeMax }}
                                <button wire:click="$set('priceRangeMin', 0); $set('priceRangeMax', 1000000)" class="ml-2 text-red-500">×</button>
                            </span>
                        @endif
                        @if ($propertyType)
                            <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                                Type: {{ $propertyTypes->firstWhere('id', $propertyType)->type }}
                                <button wire:click="$set('propertyType', '')" class="ml-2 text-red-500">×</button>
                            </span>
                        @endif
                        @if ($startDate || $endDate)
                            <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                                Date: {{ $startDate }} - {{ $endDate }}
                                <button wire:click="$set('startDate', ''); $set('endDate', '')" class="ml-2 text-red-500">×</button>
                            </span>
                        @endif
                    </div>

                    <!-- Filter Icon -->
                    <div class="flex-grow flex justify-end">
                        <button wire:click="showFilterModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Filters
                        </button>
                    </div>
                </div>

                <!-- Properties Grid -->
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-3 lg:gap-16">
                    @foreach ($properties as $property)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden relative">
                            <figure class="relative">
                                @if (!empty($property->images) && count($property->images) > 0)
                                    <img src="{{ asset('storage/' . $property->images[0]) }}" alt="Property Image" class="w-full h-60 object-cover">
                                @else
                                    <div class="w-full h-60 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">No Image Available</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 opacity-30"></div>
                                <div class="absolute top-0 right-0 m-4 bg-blue-500 text-white text-sm font-semibold px-3 py-1 rounded">
                                    {{ $property->propertyType->type }}
                                </div>
                            </figure>
                            <div class="p-4">
                                <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ $property->name }}</h3>
                                <p class="text-gray-600 mb-4">
                                    <span class="font-medium text-gray-800">State:</span> {{ $property->state }}<br>
                                    <span class="font-medium text-gray-800">Country:</span> {{ $property->country }}
                                </p>
                                <p class="text-gray-600 mb-4 flex items-center space-x-4">
                                    <i class="fas fa-dollar-sign text-gray-500"></i>
                                    <span class="font-medium text-gray-800">Price:</span> {{ $property->price }}<br>
                                    <i class="fas fa-bed text-gray-500"></i>
                                    <span class="font-medium text-gray-800">Bed:</span> {{ $property->num_bedrooms }}<br>
                                    <i class="fas fa-bath text-gray-500"></i>
                                    <span class="font-medium text-gray-800">Bath:</span> {{ $property->num_bathrooms }}
                                </p>
                                <div class="absolute bottom-0 left-0 m-4 text-gray-600 text-sm">
                                    <div class="badge badge-primary">{{ \Carbon\Carbon::parse($property->created_at)->toDateString() }}</div>
                                </div>
                                <div class="flex justify-end mt-4">
                                   <!-- Inside your properties loop -->
                                <a href="{{ route('property.details', ['propertyId' => $property->id]) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out">
                                    View Details
                                </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- Filter Modal -->
        @if ($isFilterModalVisible)
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-lg">
                    <h3 class="text-lg font-semibold mb-4">Filters</h3>
                    <form wire:submit.prevent="applyFilters">
                        <!-- Filter Fields -->
                        <div class="mb-4">
                            <label for="propertyType" class="block text-sm font-medium text-gray-700">Property Type</label>
                            <select wire:model="propertyType" id="propertyType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All</option>
                                @foreach ($propertyTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 flex space-x-4">
                            <div class="w-1/2">
                                <label for="priceRangeMin" class="block text-sm font-medium text-gray-700">Min Price</label>
                                <input type="number" wire:model="priceRangeMin" id="priceRangeMin" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                            <div class="w-1/2">
                                <label for="priceRangeMax" class="block text-sm font-medium text-gray-700">Max Price</label>
                                <input type="number" wire:model="priceRangeMax" id="priceRangeMax" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                        </div>
                        <div class="mb-4 flex space-x-4">
                            <div class="w-1/2">
                                <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" wire:model="startDate" id="startDate" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                            <div class="w-1/2">
                                <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" wire:model="endDate" id="endDate" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button" wire:click="closeFilterModal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @else
        <!-- Loading State -->
        <div class="flex justify-center items-center h-80">
            <span class="text-gray-500 text-xl">Loading...</span>
        </div>
    @endunless
</div>

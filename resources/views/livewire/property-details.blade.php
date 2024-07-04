<div>
    <!-- Navigation Section -->
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

    <!-- Property Details Section -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="flex flex-col lg:flex-row">
            <!-- Image Carousel -->
            <div class="w-full lg:w-2/3">
                <div class="carousel w-full">
                    @foreach($property->images as $index => $image)
                        <div :id="'slide' + {{ $index + 1 }}" class="carousel-item relative w-full">
                            <img src="{{ asset('storage/' . $image) }}" class="w-full h-64 object-cover" />
                            <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                                <a :href="'#slide' + {{ $index === 0 ? count($property->images) : $index }}" class="btn btn-circle bg-gray-800 text-white"><i class="fas fa-chevron-left"></i></a>
                                <a :href="'#slide' + {{ $index + 2 > count($property->images) ? 1 : $index + 2 }}" class="btn btn-circle bg-gray-800 text-white"><i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Thumbnail Previews -->
                <div class="flex space-x-2 mt-4">
                    @foreach($property->images as $index => $image)
                        <div class="w-1/4">
                            <a :href="'#slide' + {{ $index + 1 }}">
                                <img src="{{ asset('storage/' . $image) }}" class="w-full h-20 object-cover cursor-pointer border-2 border-gray-300 rounded-lg hover:border-gray-600" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Property Details -->
            <div class="w-full lg:w-1/3 p-6 bg-gray-100">
                <h2 class="text-3xl font-semibold text-gray-800 mb-4">{{ $property->name }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-gray-600">
                    <div class="flex items-center space-x-2">
                        <!-- Font Awesome icon for City -->
                        <i class="fas fa-city text-gray-800"></i>
                        <p><span class="font-medium text-gray-800">City:</span> {{ $property->city }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Font Awesome icon for State -->
                        <i class="fas fa-home text-gray-800"></i>
                        <p><span class="font-medium text-gray-800">State:</span> {{ $property->state }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Font Awesome icon for Country -->
                        <i class="fas fa-flag text-gray-800"></i>
                        <p><span class="font-medium text-gray-800">Country:</span> {{ $property->country }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Font Awesome icon for Price -->
                        <i class="fas fa-dollar-sign text-gray-800"></i>
                        <p><span class="font-medium text-gray-800">Price:</span> {{ $property->price }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Font Awesome icon for Bed -->
                        <i class="fas fa-bed text-gray-800"></i>
                        <p><span class="font-medium text-gray-800">Bed:</span> {{ $property->bedrooms }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Font Awesome icon for Bath -->
                        <i class="fas fa-bath text-gray-800"></i>
                        <p><span class="font-medium text-gray-800">Bath:</span> {{ $property->bathrooms }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Font Awesome icon for Type -->
                        <i class="fas fa-home-lg text-gray-800"></i>
                        <p><span class="font-medium text-gray-800">Type:</span> {{ $property->type }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Font Awesome icon for Pincode -->
                        <i class="fas fa-thumbtack text-gray-800"></i>
                        <p><span class="font-medium text-gray-800">Pincode:</span> {{ $property->pincode }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Font Awesome icon for Address -->
                    <i class="fas fa-map-marker-alt text-gray-800"></i>
                    <p><span class="font-medium text-gray-800">Address:</span> {{ $property->address }}</p>
                </div>
                <p class="text-gray-600 mb-4"><span class="font-medium text-gray-800">Description:</span> {{ $property->description }}</p>
                <p class="text-gray-600"><span class="font-medium text-gray-800">Created At:</span> <div class="badge badge-primary">{{ \Carbon\Carbon::parse($property->created_at)->toDateString() }}</div></p>
            </div>
        </div>
    </div>
</div>

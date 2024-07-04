@props(['title', 'show'])

<div x-data="{ open: @entangle($show).defer }" x-show="open" @keydown.window.escape="open = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">{{ $title }}</h3>
            <button type="button" @click="open = false" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div>
            {{ $slot }}
        </div>
        <div class="flex justify-end space-x-4 mt-4">
            {{ $footer }}
        </div>
    </div>
</div>

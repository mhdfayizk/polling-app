<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Available Polls') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-4">
                        @forelse ($polls as $poll)
                            <div class="p-4 border dark:border-gray-700 rounded-lg flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg">{{ $poll->question }}</h3>
                                    <p class="text-sm text-gray-500">{{ $poll->options->count() }} options</p>
                                </div>
                                <a href="{{ route('polls.show', $poll) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-700 disabled:opacity-25 transition">
                                    View & Vote
                                </a>
                            </div>
                        @empty
                            <p>No polls available at the moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
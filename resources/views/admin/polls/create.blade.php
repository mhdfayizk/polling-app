<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Poll') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.polls.store') }}" method="POST" x-data="{ options: [''] }">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="question" :value="__('Poll Question')" />
                            <x-text-input id="question" class="block mt-1 w-full" type="text" name="question" :value="old('question')" required autofocus />
                            <x-input-error :messages="$errors->get('question')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label :value="__('Options (2-5 options)')" />
                            <template x-for="(option, index) in options" :key="index">
                                <div class="flex items-center mt-2">
                                    <x-text-input type="text" name="options[]" class="block w-full" x-model="options[index]" required />
                                    <button type="button" @click="options.splice(index, 1)" x-show="options.length > 1" class="ml-2 text-red-500 hover:text-red-700">&times;</button>
                                </div>
                            </template>
                             <x-input-error :messages="$errors->get('options')" class="mt-2" />
                             <x-input-error :messages="$errors->get('options.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center space-x-4">
                           <x-secondary-button type="button" @click="options.push('')" x-show="options.length < 5">
                                Add Option
                            </x-secondary-button>
                             <x-primary-button>
                                {{ __('Create Poll') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
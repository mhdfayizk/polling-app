<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $poll->question }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Cast Your Vote</h3>
                    
                    @auth
                        @php
                            $userVote = auth()->user()->votes()->where('poll_id', $poll->id)->first();
                        @endphp
                        
                        @if ($userVote)
                            <p class="text-green-600 dark:text-green-400">You have already voted for: <strong>{{ $userVote->option->name }}</strong></p>
                        @else
                            <form id="vote-form" action="{{ route('polls.vote', $poll) }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    @foreach ($poll->options as $option)
                                        <label for="option-{{ $option->id }}" class="flex items-center p-3 border dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                            <input type="radio" name="option_id" id="option-{{ $option->id }}" value="{{ $option->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-indigo-600">
                                            <span class="ml-3 text-sm font-medium">{{ $option->name }}</span>
                                        </label>
                                    @endforeach
                                    @error('option_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-6">
                                    <x-primary-button type="submit">
                                        Submit Vote
                                    </x-primary-button>
                                </div>
                            </form>
                        @endif
                    @else
                        <p>Please <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">log in</a> to vote.</p>
                    @endauth
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Live Results</h3>
                    <div id="results-container">
                       <canvas id="pollChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const pollData = {
            labels: {!! json_encode($poll->options->pluck('name')) !!},
            votes: {!! json_encode($poll->options->map(fn($option) => $option->votes->count())) !!},
        };

        const ctx = document.getElementById('pollChart').getContext('2d');
        let pollChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: pollData.labels,
                datasets: [{
                    label: '# of Votes',
                    data: pollData.votes,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
        
        // AJAX Form Submission
        const voteForm = document.getElementById('vote-form');
        if (voteForm) {
            voteForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const actionUrl = this.action;

                fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.results) {
                        // Update chart data
                        pollChart.data.datasets[0].data = data.results.map(r => r.votes);
                        pollChart.update();
                        
                        // Disable form and show success message
                        voteForm.innerHTML = `<p class="text-green-600 dark:text-green-400">Thank you for voting!</p>`;
                    } else {
                        alert(data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while submitting your vote.');
                });
            });
        }
    </script>
</x-app-layout>
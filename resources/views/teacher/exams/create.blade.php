@extends('layouts.app')

@section('content')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-semibold text-[#880000] mb-6">Create Exam</h1>

        <div class="bg-white rounded-xl border border-gray-100 p-6 sm:p-8">
            <form method="POST" action="{{ route('teacher.exams.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Exam Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        placeholder="e.g. Midterm Exam"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select name="subject_id"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                            <option value="">Select subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->code }} — {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                        <select name="section_id"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                            <option value="">Select section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('section_id')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                        <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}"
                            min="1" placeholder="60"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                        @error('duration_minutes')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date & Time</label>
                        <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                        @error('starts_at')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date & Time</label>
                        <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                        @error('ends_at')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Select Questions <span class="text-gray-400 font-normal">({{ $questions->count() }} available)</span>
                    </label>

                    @error('questions')
                        <p class="text-red-500 text-xs mb-2 font-medium">{{ $message }}</p>
                    @enderror

                    @if($questions->isEmpty())
                        <p class="text-sm text-gray-400">No questions in your bank yet.
                            <a href="{{ route('teacher.questions.create') }}" class="text-[#880000] hover:underline font-medium">Add questions first.</a>
                        </p>
                    @else
                        <div class="border border-gray-200 rounded-lg divide-y divide-gray-100 max-h-60 overflow-y-auto">
                            @foreach($questions as $question)
                                <label class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="checkbox"
                                        name="questions[]"
                                        value="{{ $question->id }}"
                                        {{ in_array($question->id, old('questions', [])) ? 'checked' : '' }}
                                        class="accent-[#880000] mt-0.5 w-4 h-4 rounded border-gray-300">
                                    <div>
                                        <p class="text-sm text-gray-800">{{ Str::limit($question->body, 100) }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 font-mono bg-gray-50 px-1 rounded inline-block">{{ $question->subject->code ?? '' }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="inline-flex items-center justify-center bg-[#880000] text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-[#6a0000]">
                        Save as Draft
                    </button>
                    <a href="{{ route('teacher.exams.index') }}"
                       class="text-sm font-medium text-gray-500 hover:text-gray-800 hover:underline">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
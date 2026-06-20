@extends('layouts.app')

@section('content')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
        <div class="flex items-center justify-between gap-4 mb-6">
            <h1 class="text-2xl font-semibold text-[#880000]">{{ $exam->title }}</h1>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium border
                @if($exam->status === 'published') bg-green-50 text-green-700 border-green-200
                @elseif($exam->status === 'closed') bg-gray-50 text-gray-600 border-gray-200
                @else bg-yellow-50 text-yellow-700 border-yellow-200
                @endif">
                {{ ucfirst($exam->status) }}
            </span>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4 text-sm">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide font-medium">Subject</p>
                    <p class="font-medium text-gray-800 mt-1">{{ $exam->subject->code }} — {{ $exam->subject->name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide font-medium">Section</p>
                    <p class="font-medium text-gray-800 mt-1">{{ $exam->section->name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide font-medium">Duration</p>
                    <p class="font-medium text-gray-800 mt-1">{{ $exam->duration_minutes }} minutes</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide font-medium">Questions</p>
                    <p class="font-medium text-gray-800 mt-1">{{ $exam->questions->count() }} items</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide font-medium">Opens</p>
                    <p class="font-medium text-gray-800 mt-1">{{ $exam->starts_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wide font-medium">Closes</p>
                    <p class="font-medium text-gray-800 mt-1">{{ $exam->ends_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <h2 class="text-lg font-semibold text-gray-800 mb-4">Questions</h2>

        <div class="space-y-4">
            @foreach($exam->questions as $i => $question)
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-sm font-medium text-gray-800 mb-4">
                        <span class="text-[#880000]">{{ $i + 1 }}.</span> {{ $question->body }}
                    </p>
                    <div class="space-y-2">
                        @foreach($question->choices as $choice)
                            <div class="text-sm px-4 py-2.5 rounded-lg border
                                {{ $choice->is_correct ? 'bg-green-50 border-green-200 text-green-700 font-medium' : 'bg-gray-50 border-transparent text-gray-600' }}">
                                {{ $choice->body }}
                                @if($choice->is_correct)
                                    <span class="text-xs font-bold uppercase ml-2">(correct)</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <a href="{{ route('teacher.exams.index') }}"
               class="text-sm font-medium text-gray-500 hover:text-[#880000] hover:underline">
               ← Back to Exams
            </a>
        </div>

    </div>

@endsection
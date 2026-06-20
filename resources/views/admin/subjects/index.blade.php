@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
            <h1 class="text-2xl font-semibold text-[#880000]">Subjects</h1>
            <a href="{{ route('admin.subjects.create') }}"
               class="inline-flex items-center gap-1.5 bg-[#880000] text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-[#6a0000]">
                + Add Subject
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left whitespace-nowrap min-w-[580px]">
                    <thead class="bg-[#880000] border-b-2 border-[#880000] uppercase text-xs text-white font-medium tracking-wide">
                        <tr>
                            <th class="px-5 py-3">Code</th>
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">Teacher</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($subjects as $subject)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3.5 font-mono text-gray-500 text-xs">{{ $subject->code }}</td>
                                <td class="px-5 py-3.5 font-medium text-gray-800">{{ $subject->name }}</td>
                                <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $subject->teacher->name ?? '—' }}</td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('admin.subjects.edit', $subject) }}"
                                           class="text-[#880000] text-xs font-medium hover:underline">Edit</a>
                                        <form method="POST" action="{{ route('admin.subjects.destroy', $subject) }}"
                                              onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 text-xs font-medium hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-gray-400 text-sm">
                                    No subjects found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subjects->hasPages())
                <div class="px-5 py-4 border-t bg-gray-50">
                    {{ $subjects->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection
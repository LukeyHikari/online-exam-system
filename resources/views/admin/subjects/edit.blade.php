@extends('layouts.app')

@section('content')

    <div class="max-w-lg mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-semibold text-[#880000] mb-6">Edit Subject</h1>

        <div class="bg-white rounded-xl border border-gray-100 p-6 sm:p-8">
            <form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject Code</label>
                    <input type="text" name="code" value="{{ old('code', $subject->code) }}"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                    @error('code')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject Name</label>
                    <input type="text" name="name" value="{{ old('name', $subject->name) }}"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assign Teacher</label>
                    <select name="teacher_id"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm">
                        <option value="">Select a teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="inline-flex items-center justify-center bg-[#880000] text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-[#6a0000]">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.subjects.index') }}"
                       class="text-sm font-medium text-gray-500 hover:text-gray-800 hover:underline">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
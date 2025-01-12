@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-6">Chat Groups</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($groups as $group)
        <a href="{{ route('chat.show', $group) }}" 
           class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <h3 class="text-xl font-semibold mb-2">{{ $group->name }}</h3>
            <p class="text-gray-600">
                @switch($group->type)
                    @case('student_grade')
                        Students - Grade {{ $group->grade }}
                        @break
                    @case('teacher_school')
                        Teachers
                        @break
                    @case('manager_staff')
                        Managers & Staff
                        @break
                    @case('staff')
                        Staff Members
                        @break
                @endswitch
            </p>
        </a>
        @endforeach
    </div>
</div>
@endsection

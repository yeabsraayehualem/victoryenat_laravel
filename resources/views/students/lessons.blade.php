@extends('students.base')

@section('content')
    <div class="container">
        <h2>Lessons</h2>
        @if($lessons->isEmpty())
        <p>No lessons found for this subject.</p>
    @else
        <!-- Table to display lessons -->
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{!! $lesson->title !!}</td>
                        <td>{!! Str($lesson->description,10) !!}</td>
                        <td>
                            <a href="{{ route('lessons.show', ['id' => $lesson->subject->id, 'subId' => $lesson->id]) }}" class="btn btn-info">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    </div>
@endsection

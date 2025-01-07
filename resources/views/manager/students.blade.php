@extends('manager.base')
@section('content')

<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Students</h1>
        </div>
        <div class="d-flex gap-2">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" id="teacherSearch" placeholder="Search students...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Students List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatablesSimple">
                    <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="teachers-table-body">
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td>{{ $student->grade }}</td>
                                        <td class="text-center d-flex justify-content-between">
                                            
                                           
                                                    <a class="dropdown-item" href="{{ route('manager.user.detail', $student->id) }}" ><i class="fa fa-eye btn btn-warning"></i> </a>
                                                    @if ($student->status =='active')
                                                        <a class="dropdown-item" href="{{ route('manager.activateStudent', $student->id) }}" ><i class="fa fa-ban btn btn-danger"></i> </a>
                                                    @else
                                                        <a class="dropdown-item" href="{{ route('manager.activateStudent', $student->id) }}" ><i class="fa fa-check btn btn-success"></i> </a>
                                                    @endif
                                             
                                           
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        $('#teacherSearch').on('keyup',function(){
            var value = $(this).val().toLowerCase();
            $('#teachers-table-body tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

@endsection
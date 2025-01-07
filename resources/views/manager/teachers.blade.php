@extends('manager.base')
@section('content')

<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Teachers</h1>
        </div>
        <div class="d-flex gap-2">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" id="teacherSearch" placeholder="Search teachers...">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Teachers List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatablesSimple">
                    <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="teachers-table-body">
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->phone }}</td>
                                        <td >
                                            <div class="d-flex justify-content-between">
                                            <a class="ml-2" href="{{ route('manager.user.detail', $teacher->id) }}" ><i class="fa fa-edit btn btn-warning"></i> </a>
                                                    @if ($teacher->status =='active')
                                                        <a class="ml-2" href="{{ route('manager.activateTeacher', $teacher->id) }}" ><i class="fa fa-ban btn btn-danger"></i> </a>
                                                    @else
                                                        <a class="ml-2" href="{{ route('manager.activateTeacher', $teacher->id) }}" ><i class="fa fa-check btn btn-success"></i> </a>
                                                    @endif
                                            </div>
                                           
                                                    
                                             
                                           
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
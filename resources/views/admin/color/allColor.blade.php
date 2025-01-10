@extends('admin.layout')
@section('title', 'allColor')

@section('content')
<div class="container-fluid">
    <div class="table-data__tool">
        <div class="table-data__tool-left">
            <h3>Product Colors</h3>
        </div>
        <div class="table-data__tool-right"><a href="{{ route('admin.addColor') }}">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                    <i class="zmdi zmdi-plus"></i>add Color</button></a>
        </div>
    </div>
    <div class="row m-t-10">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Color Name</th>
                            <th>Color Code</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($colors->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No Data Available</td>
                            </tr>
                        @else
                            @foreach ($colors as $color)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $color->name }}</td>
                                    <td>{{ $color->code}}</td>
                                    <td>
                                        @if ($color->is_active)
                                            <span class="role member">Active</span>
                                        @else
                                            <span class="role admin">Inactive</span>
                                        @endif
                                    </td>
                                    <td>Edit</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
</div>
@endsection
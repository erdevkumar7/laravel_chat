@extends('admin.layout')
@section('title', 'allSize')

@section('content')
<div class="container-fluid">
    <div class="table-data__tool">
        <div class="table-data__tool-left">
            <h3>All Product Sizes</h3>
        </div>
        <div class="table-data__tool-right"><a href="{{ route('admin.addSize') }}">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                    <i class="zmdi zmdi-plus"></i>add Size</button></a>
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
                            <th>Size Name</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($sizes->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">No Data Available</td>
                            </tr>
                        @else
                            @foreach ($sizes as $size)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $size->name }}</td>
                                    <td>
                                        @if ($size->is_active)
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
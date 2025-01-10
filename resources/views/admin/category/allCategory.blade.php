@extends('admin.layout')
@section('title', 'allCategory')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <h3>All Categories</h3>
                    </div>
                    <div class="table-data__tool-right"><a href="{{route('admin.addCategory')}}">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i>add category</button></a>
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
                                        <th>Category Name</th>
                                        <th>Category Slug</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($categories->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">No Data Available</td>
                                        </tr>
                                    @else
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->category_slug }}</td>
                                                <td class="process">
                                                    {{ $category->is_active ? 'Active' : 'Inacive' }}
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
                {{-- <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a
                                href="#">Colorlib</a>.</p>
                    </div>
                </div>
            </div> --}}
            </div>
        </div>
    </div>
@endsection

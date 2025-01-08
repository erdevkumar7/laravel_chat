@extends('admin.layout')
@section('title', 'AddCatagory')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Create Category</strong>
                            </div>
                            <form action="{{ route('admin.addCategory') }}" method="post" enctype="multipart/form-data"
                                class="form-horizontal">
                                @csrf
                                <div class="card-body card-block">
                                    <div class="row form-group">
                                        <div class="col col-md-6">
                                            <label for="text-input" class=" form-control-label">Category Name*</label>
                                            <input type="text" id="text-input" name="name" placeholder="i.e Men" value="{{old('name')}}"
                                                class="form-control" oninput="removeError('nameErr')">
                                            @error('name')
                                                <small class="form-text text-danger" id='nameErr'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="text-desc" class=" form-control-label">Short Description*</label>
                                            <input type="text" id="text-desc" name="description" value="{{old('description')}}"
                                                placeholder="description" class="form-control"
                                                oninput="removeError('descriptionErr')">
                                            @error('description')
                                                <small class="form-text text-danger"
                                                    id='descriptionErr'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    <button type="reset" class="btn btn-danger btn-sm">Back</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="#">Colorlib</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

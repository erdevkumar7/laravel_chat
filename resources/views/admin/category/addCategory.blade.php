@extends('admin.layout')
@section('title', 'AddCatagory')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add Category</strong>
                    </div>
                    <form action="{{ route('admin.addCategory') }}" method="post" enctype="multipart/form-data"
                        class="form-horizontal">
                        @csrf
                        <div class="card-body card-block">
                            <div class="row form-group">
                                <div class="col col-md-6">
                                    <label for="text-input" class=" form-control-label">Category Name*</label>
                                    <input type="text" id="text-input" name="name" placeholder="i.e Men"
                                        value="{{ old('name') }}" class="form-control" oninput="removeError('nameErr')">
                                    @error('name')
                                        <small class="form-text text-danger" id='nameErr'>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="text-slug" class=" form-control-label">Category Slug*</label>
                                    <input type="text" id="text-slug" name="category_slug"
                                        value="{{ old('category_slug') }}" placeholder="i.e mens wear" class="form-control"
                                        oninput="removeError('category_slugErr')">
                                    @error('category_slug')
                                        <small class="form-text text-danger" id='descriptionErr'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <a href="{{ route('admin.getAllCategory') }}"><button type="button"
                                    class="btn btn-danger btn-sm">Back</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

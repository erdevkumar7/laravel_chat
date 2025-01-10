@extends('admin.layout')
@section('title', 'sizeManage')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add Product Size</strong>
                    </div>
                    <form action="{{ route('admin.addSize') }}" method="post" enctype="multipart/form-data"
                        class="form-horizontal">
                        @csrf
                        <div class="card-body card-block">
                            <div class="row form-group">
                                <div class="col col-md-12">
                                    <label for="text-input" class=" form-control-label">Size Name*</label>
                                    <input type="text" id="text-input" name="name" placeholder="i.e XL"
                                        value="{{ old('name') }}" class="form-control" oninput="removeError('nameErr')">
                                    @error('name')
                                        <small class="form-text text-danger" id='nameErr'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <a href="{{ route('admin.getAllSize') }}"><button type="button"
                                    class="btn btn-danger btn-sm">Back</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

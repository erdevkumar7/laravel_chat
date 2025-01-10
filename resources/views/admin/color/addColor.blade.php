@extends('admin.layout')
@section('title', 'colorManage')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Add Color</strong>
                    </div>
                    <form action="{{ route('admin.addColor') }}" method="post" enctype="multipart/form-data"
                        class="form-horizontal">
                        @csrf
                        <div class="card-body card-block">
                            <div class="row form-group">
                                <div class="col col-md-6">
                                    <label for="text-input" class=" form-control-label">Color Name*</label>
                                    <input type="text" id="text-input" name="name" placeholder="i.e Green"
                                        value="{{ old('name') }}" class="form-control" oninput="removeError('nameErr')" required>
                                    @error('name')
                                        <small class="form-text text-danger" id='nameErr'>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="text-code" class=" form-control-label">Color Code*</label>
                                    <input type="text" id="text-code" name="code"
                                        value="{{ old('code') }}" placeholder="i.e #008000" class="form-control"
                                        oninput="removeError('codeErr')" required>
                                    @error('code')
                                        <small class="form-text text-danger" id='descriptionErr'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <a href="{{ route('admin.getAllColor') }}"><button type="button"
                                    class="btn btn-danger btn-sm">Back</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
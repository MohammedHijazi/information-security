@extends('user.layout.app')
@push('style')
@endpush
@section('content')
    <!--begin::Content-->
    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6  subheader-solid " id="kt_subheader">
            <div
                class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">

                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">
                            Documents
                        </h5>
                        <!--end::Page Title-->

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{route('document.index')}}" class="text-muted">
                                    Documents
                                </a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->

                <!--begin::Toolbar-->
                <div class="d-flex align-items-center"></div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container ">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Permission of Document</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Example-->
                        <div class="example mb-10">
                            <div class="example-preview">
                                <form method="post" action="{{route('document.permission_post',$document->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label  class="col-2 col-form-label">User: </label>
                                        <div class="col-10">
                                            <div class="dropdown bootstrap-select show-tick form-control show dropup">
                                                <select class="form-control selectpicker" name="user">
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}">
                                                            {{$user->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('user')
                                        <div class="text-danger" role="alert">
                                            {{$errors->first('user')}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-2 col-form-label">Permissions: </label>
                                        <div class="col-10">
                                            <div class="dropdown bootstrap-select show-tick form-control show dropup">
                                                <select class="form-control selectpicker" name="permission[]" multiple>
                                                    <option value="view">view</option>
                                                    <option value="create">create</option>
                                                    <option value="delete">delete</option>
                                                    <option value="readWrite">read & write</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('permission')
                                        <div class="text-danger" role="alert">
                                            {{$errors->first('permission')}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="card-footer align-items-end">
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                        <a href="{{route('document.index')}}"  class="btn btn-secondary">Cancel</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--end::Example-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@push('script')

@endpush

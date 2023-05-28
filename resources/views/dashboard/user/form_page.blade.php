@extends('admin.layout.app')
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
                            users
                        </h5>
                        <!--end::Page Title-->

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{route('user.index')}}" class="text-muted">
                                    users
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#" class="text-muted">
                                    {{!$user?'Create user' : 'Edit user'}}
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
                            <h3 class="card-label">{{!$user?'Create new user' : 'Edit user'}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Example-->
                        <div class="example mb-10">
                            <div class="example-preview">
                                <form method="post" action="{{!$user? route('user.store'): route('user.update',$user->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    @if($user)
                                        @method('put')
                                    @endif
                                    <div class="form-group row">
                                        <label  class="col-2 col-form-label">Name </label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" value="{{$user? $user->name :old('name')}}" name="name"/>
                                            @error('name')
                                            <div class="text-danger" role="alert">
                                                {{$errors->first('name')}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-2 col-form-label">Email</label>
                                        <div class="col-10">
                                            <input class="form-control" type="email" value="{{$user? $user->email :old('email')}}" name="email"/>
                                            @error('email')
                                            <div class="text-danger" role="alert">
                                                {{$errors->first('email')}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-2 col-form-label">Security Level</label>
                                        <div class="col-10">
                                            <div class="dropdown bootstrap-select show-tick form-control show dropup">
                                                <select class="form-control selectpicker" tabindex="null" name="security_level">
                                                    <option value="top_secret" {{ $user && $user->security_level == "top_secret"? "selected" : ""}}>Top Secret</option>
                                                    <option value="secret" {{ $user && $user->security_level == "secret"? "selected" : ""}}>Secret</option>
                                                    <option value="confidential" {{ $user && $user->security_level == "confidential"? "selected" : ""}}>Confidential</option>
                                                    <option value="unclassified" {{ $user && $user->security_level == "unclassified"? "selected" : ""}}>Unclassified</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('security_level')
                                        <div class="text-danger" role="alert">
                                            {{$errors->first('security_level')}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-2 col-form-label">Password</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" value="" name="password"/>
                                            @error('password')
                                            <div class="text-danger" role="alert">
                                                {{$errors->first('password')}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer align-items-end">
                                        @if($user)
                                            <button type="submit" class="btn btn-success mr-2">Update</button>
                                        @else
                                            <button type="submit" class="btn btn-success mr-2">Store</button>
                                        @endif
                                        <a href="{{route('user.index')}}"  class="btn btn-secondary">Cancel</a>
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

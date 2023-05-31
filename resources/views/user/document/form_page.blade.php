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
                            <li class="breadcrumb-item">
                                <a href="#" class="text-muted">
                                    {{!$document?'Create document' : 'Edit document'}}
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
                            <h3 class="card-label">{{!$document?'Create new document' : 'Edit document'}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Example-->
                        <div class="example mb-10">
                            <div class="example-preview">
                                <form method="post" action="{{!$document? route('document.store'): route('document.update',$document->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    @if($document)
                                        @method('put')
                                    @endif
                                    <div class="form-group row">
                                        <label  class="col-2 col-form-label">Name </label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" value="{{$document? $document->name :old('name')}}" name="name"/>
                                            @error('name')
                                            <div class="text-danger" role="alert">
                                                {{$errors->first('name')}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if(!$document)
                                        <div class="form-group row">
                                            <label  class="col-2 col-form-label">Text File</label>
                                            <div class="col-10">
                                                <input class="form-control" type="file" value="{{$document? $document->file :old('file')}}" name="file"/>
                                                @error('file')
                                                <div class="text-danger" role="alert">
                                                    {{$errors->first('file')}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label  class="col-2 col-form-label">Security Level</label>
                                        <div class="col-10">
                                            <div class="dropdown bootstrap-select show-tick form-control show dropup">
                                                <select class="form-control selectpicker" tabindex="null" name="security_level">
                                                    <option value="top_secret" {{ $document && $document->security_level == "top_secret"? "selected" : ""}}>Top Secret</option>
                                                    <option value="secret" {{ $document && $document->security_level == "secret"? "selected" : ""}}>Secret</option>
                                                    <option value="confidential" {{ $document && $document->security_level == "confidential"? "selected" : ""}}>Confidential</option>
                                                    <option value="unclassified" {{ $document && $document->security_level == "unclassified"? "selected" : ""}}>Unclassified</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('security_level')
                                        <div class="text-danger" role="alert">
                                            {{$errors->first('security_level')}}
                                        </div>
                                        @enderror
                                    </div>
                                    @if($document)
                                        <div class="form-group row">
                                                <label for="content" class="form-label">Content file</label>
                                                <textarea class="form-control" name="content" id="content" rows="7">{{\Illuminate\Support\Facades\Storage::disk('public')->get($document->file_path)}}</textarea>
                                        </div>
                                    @endif
                                    <div class="card-footer align-items-end">
                                        @if($document)
                                            <button type="submit" class="btn btn-success mr-2">Update</button>
                                        @else
                                            <button type="submit" class="btn btn-success mr-2">Store</button>
                                        @endif
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

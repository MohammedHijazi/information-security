@extends('admin.layout.app')
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
                            Contact us
                        </h5>
                        <!--end::Page Title-->

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.home')}}" class="text-muted">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('contactus.index')}}" class="text-muted">
                                    Contact us
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
                @if(session()->has('success'))
                    <div class="alert alert-success w-25">{{session('success')}}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger w-25">{{session('error')}}</div>
                @endif
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Contact us</h3>
                        </div>

                    </div>
                    <div class="">
                        <!--begin::Example-->
                        <div class="example mb-10">
                            <div class="example-preview">
                                <table class="table table-responsive">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Sent at</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contactUss as $contactUs)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$contactUs->name}}</td>
                                            <td>{{$contactUs->email}}</td>
                                            <td>{{$contactUs->phone}}</td>
                                            <td>{{$contactUs->location}}</td>
                                            <td>{{$contactUs->company}}</td>
                                            <td>{{$contactUs->message}}</td>
                                            <td>{{$contactUs->created_at->diffForHumans()}}</td>
                                            <td>
                                                <form method="post" action="{{route('contactus.destroy',[$contactUs->id])}}" class="btn deleteForm{{$contactUs->id}}" onclick="confirmDeleted({{$contactUs->id}})">
                                                    @csrf
                                                    @method('delete')
                                                    <i class="menu-icon text-danger flaticon2-trash"></i>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                {!! $contactUss->links('admin.pagination') !!}
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
@push('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmDeleted(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.deleteForm'+id).submit();
                }
            })
        }
    </script>
@endpush

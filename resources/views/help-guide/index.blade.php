@extends('layouts.default')

@section('content')
    <div id="dashboard">
        <div class="row g-0">
            <div class="col-md-12 p-0">

                <div class="row g-0">
                    <div class="col-md-6 p-0">
                        <div class="page-heading">
                            <h1>Your Help & Guides</h1>
                        </div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="col-md-12">
                            <a href="{{ route('help-guide.create')}}" class="btn btn-success float-end">Add a help Guide</a>
                        </div>
                    </div>
                </div>

                <div class="table-wrap mt-5">
                    <div class="table-responsive">
                        <table class="table" id="pages-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Page Type</th>
                                <th>Title</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- <script>
        $(document).ready(function () {
            $('#pages-table').DataTable ({
                "ordering": false,
                language: {
                    searchPlaceholder: "Search records"
                },
                "columnDefs": [
                    {"className": "table-td", "targets": "_all"}
                ],
                processing: true,
                serverSide: true,
                ajax :'{!! url('/load-pages') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'page_type.name', name: 'page_type.name'},
                    {data: 'title', name: 'title'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'},
                ]
            });
        });


    </script> -->
@endsection

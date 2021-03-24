@EXTENDS('layout.main')

@section('content')

<!-- DataTales Example -->
@if(Session('notification'))
    <div id="alert" class="alert alert-success">{{Session('notification')}}</div>
@endif
<div CLASS="card shadow mb-4">
    <div CLASS="card-header py-3">
        <h6 CLASS="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div CLASS="card-body">
        <div CLASS="table-responsive">
            <table CLASS="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $da)
                    <tr>
                        <td>{{$da['id']}}</td>
                        <td>{{$da['name']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

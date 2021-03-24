<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <base href="{{asset('')}}">
    <link href="css/styles.css" rel="stylesheet" />
    <!-- <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" /> -->
    <script src="js/all.min.js" crossorigin="anonymous"></script>
    @php
    $count_fanpage = Session::get('count_fanpage');
    $count_comment = Session::get('count_comment');
    $inf_fanpage = Session::get('nodefanpage');
    $Name_Fanpage = Session::get('Name_DetailFanpage');
    @endphp
</head>

<body class="sb-nav-fixed">
    @include('home.layout.header')
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Đăng bài viết</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/poststatus')}}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <p>Trạng thái</p>
                            <textarea name="status" id="" style="border-radius: 10px; outline: none" cols="60" rows="5"></textarea>
                        </div>
                        <div class="justify-content mt-4">
                            <div>Link</div>
                            <div class="btn btn-mdb-color btn-rounded">
                                <input type="text" name="link" style="border: none; border-bottom: 1px solid #e06363; width:440px; outline: none">
                            </div>
                        </div>
                        <div>
                            <p class="mt-4">Chọn trang fanpage</p>
                            <div class="mt-2 d-flex row" style="padding: 10px;">
                                @foreach($inf_fanpage->data as $check)
                                <div class="checkbox col-6">
                                    <label>
                                        <input type="checkbox" name="fanpage[]" value="{{$check->access_token}}">
                                        {{$check->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Đăng Bài</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Sửa bài viết</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('/edit_post')}}" method="post" role="form" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <input type="text" id="id" name="id" style="display: none;">
                        </div>
                        <div>
                            <p>Trạng thái</p>
                            <textarea name="statusEdit" id="statusEdit" style="border-radius: 10px; outline: none" cols="60" rows="5"></textarea>
                        </div>
                        <div class="justify-content mt-4">
                            <div>Images</div>
                            <div class="btn btn-mdb-color btn-rounded">
                                <img src="" id="imgEdit" alt="">
                            </div>
                        </div>
                        <div class="justify-content mt-4">
                            <div>Link</div>
                            <div class="btn btn-mdb-color btn-rounded">
                                <input type="text" id="linkEdit" name="linkEdit" style="border: none; border-bottom: 1px solid #e06363; width:440px; outline: none">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="layoutSidenav">
        @include('home.layout.menu')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    @if(Session('error'))
                    <div id="alert" class="alert alert-success mt-4">{{Session('error')}}</div>
                    @endif
                    @if(Session('success'))
                    <div id="alert" class="alert alert-success mt-4">{{Session('success')}}</div>
                    @endif
                    <h1 class="mt-4">{{('WELCOME TO ADMIN DASHBOARD')}}</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Total Fanpage</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="small text-white stretched-link">
                                        @if(isset($count_fanpage))
                                        <span>{{$count_fanpage}}</span>
                                        @else
                                        <span>{{0}}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Total Post</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="small text-white stretched-link">
                                        @if(isset($count_comment))
                                        <span>{{$count_comment}}</span>
                                        @else
                                        <span>{{0}}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Success Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">fanpage information</div>
                                <div class="card-footer d-flex align-items-center justify-content-between" style="height: 44px;">
                                    <div class="dropdown">
                                        <span class="btn btn-secondary dropdown-toggle btn-sm" style="background: none; border:none" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            select fanpage
                                        </span>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach($inf_fanpage->data as $ifo)
                                            <a class="dropdown-item" href="{{url('/detail_fanpage/'.$ifo->id)}}">{{$ifo->name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            @if(isset($Name_Fanpage))
                            <span>{{$Name_Fanpage}}</span>
                            @else
                            <span>Fanpage</span>
                            @endif
                        </div>
                        @yield('content')
                    </div>
                </div>
            </main>

            @include('home.layout.footer')
        </div>
    </div>
    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <!-- <script src="js/jquery.dataTables.min.js" crossorigin="anonymous"></script> -->
    <script src="js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
    <script>
        setTimeout(() => {
            document.getElementById('alert').style.display = 'none';
        }, 5000);
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.edit').click(function(e) {
                var url = $(this).attr('data-url');
                $('#EditModal').modal('show');
                e.preventDefault();
                $.ajax({
                    type: 'get',
                    url,
                    success: function(res) {
                        $('#id').val(res.data.id);
                        $('#statusEdit').val(res.data.message);
                        let image = document.getElementById('imgEdit');
                        image.src = res.data.picture;
                        if (res.data.picture !== '') {
                            $('#linkEdit').val(res.data.picture);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>

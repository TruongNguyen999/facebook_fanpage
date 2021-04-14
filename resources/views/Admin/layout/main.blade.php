<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin</title>
    <base href="{{asset('')}}">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="js/all.min.js" crossorigin="anonymous"></script>
    <style>
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: black;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    @include('home.layout.header')
    <div id="layoutSidenav">
        @include('home.layout.menu')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid" style="background: #1c1e21;color:white">
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 mt-auto" style="background: #1c1e21;color:white">
                <div class="container-fluid" style="background: #1c1e21;color:white">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Nguyễn Nhựt Trường - Trần Hiến Thanh Thanh Báo Cáo Thực Tập &copy; {{date('Y')}}</div>
                    </div>
                </div>
            </footer>

        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/pusher.min.js"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.detail_album').click(function(e) {
                let url = $(this).attr('data-url');
                e.preventDefault();
                $.ajax({
                    type: 'get',
                    url,
                    success: function(res) {
                        document.getElementById('img-opacity').style.opacity = '0.4';
                        document.getElementById('model_img_display').style.display = 'flex';
                        document.getElementById('model_img').style.backgroundImage = "url(" + res.img + ")";
                    }
                });
            });
        });

        function display_album() {
            document.getElementById('model_img_display').style.display = 'none';
            document.getElementById('img-opacity').style.opacity = '1';
        }
    </script>
</body>

</html>

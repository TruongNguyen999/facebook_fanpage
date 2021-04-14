@php
$inf_fanpage = Session::get('nodefanpage');
@endphp
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link" href="{{url('/success')}}" onclick="post()">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Trang Chủ
                </a>
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Tin Nhắn Khách Hàng
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @foreach($inf_fanpage->data as $inf)
                        <a class="nav-link" href="{{url('/inbox/'.$inf->id)}}">{{$inf->name}}</a>
                        @endforeach
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Bình Luận
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        @foreach($inf_fanpage->data as $inf)
                        <a class="nav-link" href="{{url('/comments/'.$inf->id)}}">{{$inf->name}}</a>
                        @endforeach
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link" data-toggle="modal" data-target="#exampleModalCenter" id="showPost" style="display: none;">
                    <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
                    Đăng Bài Mới
                </a>
                <a class="nav-link" href="status_admin">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Trạng Thái
                </a>
                <a class="nav-link" href="album_admin">
                    <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
                    Album Ảnh
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>

<script>
    if(window.location.href === 'https://localhost:8081/public/success'){
        document.getElementById('showPost').style.display = 'flex';
    }
    if(window.location.href === 'https://facebook-app01.herokuapp.com/success'){
        document.getElementById('showPost').style.display = 'flex';
    }
    if(window.location.href === 'http://facebook-app01.herokuapp.com/success'){
        document.getElementById('showPost').style.display = 'flex';
    }
</script>

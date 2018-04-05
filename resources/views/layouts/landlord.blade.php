<!DOCTYPE HTML>
<html>
<head>
    <title>{{env('APP_NAME')}}: Landlord</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('dashboard/css/bootstrap.css')}}" rel='stylesheet' type='text/css'/>

    <!-- Custom CSS -->
    <link href="{{asset('dashboard/css/style.css')}}" rel='stylesheet' type='text/css'/>

    <!-- font-awesome icons CSS -->
    <link href="{{asset('dashboard/css/font-awesome.css')}}" rel="stylesheet">
    <!-- //font-awesome icons CSS-->

    <!-- side nav css file -->
    <link href='{{asset('dashboard/css/SidebarNav.min.css')}}' media='all' rel='stylesheet' type='text/css'/>
    <!-- //side nav css file -->

    <!-- js-->
    <script src="{{asset('dashboard/js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('dashboard/js/modernizr.custom.js')}}"></script>

    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
          rel="stylesheet">
    <!--//webfonts-->

    <!-- chart -->
    <script src="{{asset('dashboard/js/Chart.js')}}"></script>
    <!-- //chart -->

    <!-- Metis Menu -->
    <script src="{{asset('dashboard/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('dashboard/js/custom.js')}}"></script>
    <link href="{{asset('dashboard/css/custom.css')}}" rel="stylesheet">
    <!--//Metis Menu -->
    <style>
        #chartdiv {
            width: 100%;
            height: 295px;
        }
    </style>
    <!--pie-chart --><!-- index page sales reviews visitors pie chart -->
    <script src="{{asset('dashboard/js/pie-chart.js')}}" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#demo-pie-1').pieChart({
                barColor: '#2dde98',
                trackColor: '#eee',
                lineCap: 'round',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-2').pieChart({
                barColor: '#8e43e7',
                trackColor: '#eee',
                lineCap: 'butt',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-3').pieChart({
                barColor: '#ffc168',
                trackColor: '#eee',
                lineCap: 'square',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });


        });

    </script>
    <!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

    <!-- requried-jsfiles-for owl -->
    <link href="{{asset('dashboard/css/owl.carousel.css')}}" rel="stylesheet">
    <script src="{{asset('dashboard/js/owl.carousel.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#owl-demo").owlCarousel({
                items: 3,
                lazyLoad: true,
                autoPlay: true,
                pagination: true,
                nav: true,
            });
        });
    </script>
    <!-- //requried-jsfiles-for owl -->
</head>
<body class="cbp-spmenu-push">
<div class="main-content">
    <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
        <!--left-fixed -navigation-->
        <aside class="sidebar-left">
            <nav class="navbar navbar-inverse" >
                <div class="navbar-header" >
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse"
                            aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <h1><a class="navbar-brand" href="{{ route('landlord.dashboard') }}"><img src="{{asset('homeStyles/images/uploads/logo.png')}}" height="60"></a></h1>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="treeview">
                            <a href="{{ route('landlord.dashboard') }}">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="treeview active">
                            <a href="#">
                                <i class="fa fa-server"></i>
                                <span>Transactions</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('landlord.statement') }}"><i class="fa fa-angle-right"></i> Mini statement</a>
                                </li>
                                <li><a href="{{ route('landlord.withdraw') }}"><i class="fa fa-angle-right"></i> Withdraw</a></li>

                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-home"></i>
                                <span>Apartments</span>
                                <i class="fa fa-angle-left pull-right"></i>

                            </a>
                            <ul class="treeview-menu">
                             <li><a href="{{ route('landlord.addHouse') }}"><i class="fa fa-angle-right"></i> Request lease</a></li>
                                <li><a href="{{ route('landlord.remove') }}"><i class="fa fa-angle-right"></i> My active houses</a></li>
                                <li><a href="{{ route('landlord.removed') }}"><i class="fa fa-angle-right"></i> Removed houses</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bullhorn"></i>
                                <span>Messages</span>
                                <i class="fa fa-angle-left pull-right"></i>
                                <i class="badge badge-danger pull-right">{{auth()->user()->notifs}}</i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('landlord.messages') }}"><i class="fa fa-angle-right"></i> Inbox <i class="badge badge-danger pull-right">{{auth()->user()->notifs}}</i></a></li>
                                <li><a href="{{ route('landlord.compose') }}"><i class="fa fa-angle-right"></i> Send Message</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="{{route('landlord.logout')}}">
                                <i class="fa fa-sign-out"></i> <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
        </aside>
    </div>
    <!--left-fixed -navigation-->

    <!-- header-starts -->
    <div class="sticky-header header-section " style=" background: #00a78e;">

        <div class="header-left">
            <button id="showLeftPush"><i class="fa fa-bars"></i></button>

            <ul class="nofitications-dropdown">
                <li class="dropdown head-dpdn">
                    <a href="{{ route('landlord.messages') }}" class="dropdown-toggle"><i class="fa fa-envelope"></i><span class="badge">{{auth()->user()->notifs}}</span></a>
                </li>
            </ul>
        </div>
        <div class="header-right">

            <!--toggle button start-->

            <!--toggle button end-->
            <div class="profile_details">
                <ul>
                    <li class="dropdown profile_details_drop">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div class="profile_img">
                                <span class="prfil-img"><img src="{{asset('dashboard/images/2.jpg')}}" alt=""> </span>
                                <div class="user-name">
                                    <p>{{auth()->user()->name}}</p>
                                    <span style="color: #ffffff;">Land Owner</span>
                                </div>
                                <i class="fa fa-angle-down lnr"></i>
                                <i class="fa fa-angle-up lnr"></i>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu drp-mnu">
                            <li><a href="{{route('landlord.changePassword')}}"><i class="fa fa-cog"></i> Change Password</a></li>
                            <li><a href="{{route('landlord.logout')}}"><i class="fa fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
        @yield('content')
    </div>
    <!--footer-->
    <div class="footer">
        <p>&copy; {{date('Y')}} {{env('APP_NAME')}} Real Estate. All Rights Reserved.</p>
    </div>
    <!--//footer-->
</div>


{{--sweet alerts--}}
<script src="{{asset('js/sweetalert.js')}}"></script>
@include('sweet::alert')

<!-- new added graphs chart js-->

<script src="{{asset('dashboard/js/Chart.bundle.js')}}"></script>
<script src="{{asset('dashboard/js/utils.js')}}"></script>


<!-- Classie --><!-- for toggle left push menu script -->
<script src="{{asset('dashboard/js/classie.js')}}"></script>
<script>
    var menuLeft = document.getElementById('cbp-spmenu-s1'),
        showLeftPush = document.getElementById('showLeftPush'),
        body = document.body;

    showLeftPush.onclick = function () {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
    };


    function disableOther(button) {
        if (button !== 'showLeftPush') {
            classie.toggle(showLeftPush, 'disabled');
        }
    }
</script>
<!-- //Classie --><!-- //for toggle left push menu script -->

<!--scrolling js-->
<script src="{{asset('dashboard/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('dashboard/js/scripts.js')}}"></script>
<!--//scrolling js-->

<!-- side nav js -->
<script src='{{asset('dashboard/js/SidebarNav.min.js')}}' type='text/javascript'></script>
<script>
    $('.sidebar-menu').SidebarNav()
</script>
<!-- //side nav js -->

<!-- for index page weekly sales java script -->
<script src="{{asset('dashboard/js/SimpleChart.js')}}"></script>
<script>
    var graphdata1 = {
        linecolor: "#CCA300",
        title: "Monday",
        values: [
            {X: "6:00", Y: 10.00},
            {X: "7:00", Y: 20.00},
            {X: "8:00", Y: 40.00},
            {X: "9:00", Y: 34.00},
            {X: "10:00", Y: 40.25},
            {X: "11:00", Y: 28.56},
            {X: "12:00", Y: 18.57},
            {X: "13:00", Y: 34.00},
            {X: "14:00", Y: 40.89},
            {X: "15:00", Y: 12.57},
            {X: "16:00", Y: 28.24},
            {X: "17:00", Y: 18.00},
            {X: "18:00", Y: 34.24},
            {X: "19:00", Y: 40.58},
            {X: "20:00", Y: 12.54},
            {X: "21:00", Y: 28.00},
            {X: "22:00", Y: 18.00},
            {X: "23:00", Y: 34.89},
            {X: "0:00", Y: 40.26},
            {X: "1:00", Y: 28.89},
            {X: "2:00", Y: 18.87},
            {X: "3:00", Y: 34.00},
            {X: "4:00", Y: 40.00}
        ]
    };
    var graphdata2 = {
        linecolor: "#00CC66",
        title: "Tuesday",
        values: [
            {X: "6:00", Y: 100.00},
            {X: "7:00", Y: 120.00},
            {X: "8:00", Y: 140.00},
            {X: "9:00", Y: 134.00},
            {X: "10:00", Y: 140.25},
            {X: "11:00", Y: 128.56},
            {X: "12:00", Y: 118.57},
            {X: "13:00", Y: 134.00},
            {X: "14:00", Y: 140.89},
            {X: "15:00", Y: 112.57},
            {X: "16:00", Y: 128.24},
            {X: "17:00", Y: 118.00},
            {X: "18:00", Y: 134.24},
            {X: "19:00", Y: 140.58},
            {X: "20:00", Y: 112.54},
            {X: "21:00", Y: 128.00},
            {X: "22:00", Y: 118.00},
            {X: "23:00", Y: 134.89},
            {X: "0:00", Y: 140.26},
            {X: "1:00", Y: 128.89},
            {X: "2:00", Y: 118.87},
            {X: "3:00", Y: 134.00},
            {X: "4:00", Y: 180.00}
        ]
    };
    var graphdata3 = {
        linecolor: "#FF99CC",
        title: "Wednesday",
        values: [
            {X: "6:00", Y: 230.00},
            {X: "7:00", Y: 210.00},
            {X: "8:00", Y: 214.00},
            {X: "9:00", Y: 234.00},
            {X: "10:00", Y: 247.25},
            {X: "11:00", Y: 218.56},
            {X: "12:00", Y: 268.57},
            {X: "13:00", Y: 274.00},
            {X: "14:00", Y: 280.89},
            {X: "15:00", Y: 242.57},
            {X: "16:00", Y: 298.24},
            {X: "17:00", Y: 208.00},
            {X: "18:00", Y: 214.24},
            {X: "19:00", Y: 214.58},
            {X: "20:00", Y: 211.54},
            {X: "21:00", Y: 248.00},
            {X: "22:00", Y: 258.00},
            {X: "23:00", Y: 234.89},
            {X: "0:00", Y: 210.26},
            {X: "1:00", Y: 248.89},
            {X: "2:00", Y: 238.87},
            {X: "3:00", Y: 264.00},
            {X: "4:00", Y: 270.00}
        ]
    };
    var graphdata4 = {
        linecolor: "Random",
        title: "Thursday",
        values: [
            {X: "6:00", Y: 300.00},
            {X: "7:00", Y: 410.98},
            {X: "8:00", Y: 310.00},
            {X: "9:00", Y: 314.00},
            {X: "10:00", Y: 310.25},
            {X: "11:00", Y: 318.56},
            {X: "12:00", Y: 318.57},
            {X: "13:00", Y: 314.00},
            {X: "14:00", Y: 310.89},
            {X: "15:00", Y: 512.57},
            {X: "16:00", Y: 318.24},
            {X: "17:00", Y: 318.00},
            {X: "18:00", Y: 314.24},
            {X: "19:00", Y: 310.58},
            {X: "20:00", Y: 312.54},
            {X: "21:00", Y: 318.00},
            {X: "22:00", Y: 318.00},
            {X: "23:00", Y: 314.89},
            {X: "0:00", Y: 310.26},
            {X: "1:00", Y: 318.89},
            {X: "2:00", Y: 518.87},
            {X: "3:00", Y: 314.00},
            {X: "4:00", Y: 310.00}
        ]
    };
    var Piedata = {
        linecolor: "Random",
        title: "Profit",
        values: [
            {X: "Monday", Y: 50.00},
            {X: "Tuesday", Y: 110.98},
            {X: "Wednesday", Y: 70.00},
            {X: "Thursday", Y: 204.00},
            {X: "Friday", Y: 80.25},
            {X: "Saturday", Y: 38.56},
            {X: "Sunday", Y: 98.57}
        ]
    };
    $(function () {
        $("#Bargraph").SimpleChart({
            ChartType: "Bar",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata4, graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#sltchartype").on('change', function () {
            $("#Bargraph").SimpleChart('ChartType', $(this).val());
            $("#Bargraph").SimpleChart('reload', 'true');
        });
        $("#Hybridgraph").SimpleChart({
            ChartType: "Hybrid",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata4],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#Linegraph").SimpleChart({
            ChartType: "Line",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: false,
            data: [graphdata4, graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#Areagraph").SimpleChart({
            ChartType: "Area",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata4, graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#Scatterredgraph").SimpleChart({
            ChartType: "Scattered",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata4, graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#Piegraph").SimpleChart({
            ChartType: "Pie",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            showpielables: true,
            data: [Piedata],
            legendsize: "250",
            legendposition: 'right',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });

        $("#Stackedbargraph").SimpleChart({
            ChartType: "Stacked",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });

        $("#StackedHybridbargraph").SimpleChart({
            ChartType: "StackedHybrid",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
    });

</script>
<!-- //for index page weekly sales java script -->


<!-- Bootstrap Core JavaScript -->
<script src="{{asset('dashboard/js/bootstrap.js')}}"></script>
<!-- //Bootstrap Core JavaScript -->

</body>
</html>
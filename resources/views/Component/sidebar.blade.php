<div class="sidebar" data-color="blue" data-background-color="black" data-image="./assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          MI
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Management Info
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            
            <img src="{{asset('assets/img/avatar.jpg')}}" height="34px" width="34px" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                {{session('name')}}
                <b class="caret"></b>
              </span>
            </a>
            <div class="collapse @yield('show-profile')" id="collapseExample">
              <ul class="nav">
                <li class="nav-item @yield('active-profile')">
                  <a class="nav-link" href="{{route('getProfile')}}">
                    <span class="sidebar-mini"> UP </span>
                    <span class="sidebar-normal"> User Profile </span>
                  </a>
                </li>             
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item @yield('active-dashboard')">
            <a class="nav-link" href="{{route('dashboard')}}">
              <i class="material-icons">dashboard</i>
              <p> Dashboard </p>
            </a>
          </li>
          @if(session('id_role') == "1" || session('id_role') == "2" || session('id_role') == "4")
          <li class="nav-item @yield('active-ticket')">
            <a class="nav-link" href="{{route('getTicketManagement')}}">
              <i class="material-icons">domain</i>
              <p> Ticket Management </p>
            </a>
          </li>                           
          @endif
          @if(session('id_role') == "1" || session('id_role') == "3")
          <li class="nav-item @yield('active-project')">
            <a class="nav-link" href="{{route('getProjectManagement')}}">
              <i class="material-icons">domain</i>
              <p> Project Management </p>
            </a>
          </li>                           
          @endif<!-- 
          @if(session('id_role') == "1" || session('id_role') == "4")
          <li class="nav-item @yield('active-project')">
            <a class="nav-link" href="{{route('getCustomerManagement')}}">
              <i class="material-icons">domain</i>
              <p> Project Management </p>
            </a>
          </li>                           
          @endif -->
          @if(session('id_role') == "1")            
          <li class="nav-item @yield('active-master')">
            <a class="nav-link" data-toggle="collapse" href="#formsExamples">
              <i class="material-icons">content_paste</i>
              <p> Master Data
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse @yield('show-master')" id="formsExamples">
              <ul class="nav">
                <li class="nav-item @yield('active-user')">
                  <a class="nav-link" href="{{route('getUserManagement')}}">
                    <span class="sidebar-mini"> MU </span>
                    <span class="sidebar-normal"> Master User </span>
                  </a>
                </li>
                <li class="nav-item @yield('active-vehicle')">
                  <a class="nav-link" href="{{route('getVehicle')}}">
                    <span class="sidebar-mini"> MV </span>
                    <span class="sidebar-normal"> Master Vehicle </span>
                  </a>
                </li>
                <li class="nav-item @yield('active-advance')">
                  <a class="nav-link" href="{{route('getAdvance')}}">
                    <span class="sidebar-mini"> AM </span>
                    <span class="sidebar-normal"> Advance Menu </span>
                  </a>
                </li>                      
              </ul>
            </div>
          </li>  
          @endif

          <li class="nav-item ">
            <a class="nav-link" href="{{route('logout')}}">
              <i class="material-icons">exit_to_app</i>
              <p> Logout </p>
            </a>
          </li>
        </ul>
      </div>
    </div>
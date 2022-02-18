<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Главная
          </p>
        </router-link>
      </li>


      @can('isAdmin')
        <li class="nav-item">
          <router-link to="/teachers" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Преподаватели</p>
          </router-link>
        </li>
      @endcan



      @can('isAdmin')
        <li class="nav-item">
            <router-link to="/directions" class="nav-link">
            <svg class="nav-icon" width="20" height="20" fill="lightblue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M96 0C113.7 0 128 14.33 128 32V64H480C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H128V480C128 497.7 113.7 512 96 512C78.33 512 64 497.7 64 480V128H32C14.33 128 0 113.7 0 96C0 78.33 14.33 64 32 64H64V32C64 14.33 78.33 0 96 0zM448 160C465.7 160 480 174.3 480 192V352C480 369.7 465.7 384 448 384H192C174.3 384 160 369.7 160 352V192C160 174.3 174.3 160 192 160H448z"/></svg>
            <p> Направления </p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/groups" class="nav-link">
            <svg class="nav-icon" width="20" height="20" fill="lightgreen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3c-95.73 0-173.3 77.6-173.3 173.3C0 496.5 15.52 512 34.66 512H413.3C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM479.1 320h-73.85C451.2 357.7 480 414.1 480 477.3C480 490.1 476.2 501.9 470 512h138C625.7 512 640 497.6 640 479.1C640 391.6 568.4 320 479.1 320zM432 256C493.9 256 544 205.9 544 144S493.9 32 432 32c-25.11 0-48.04 8.555-66.72 22.51C376.8 76.63 384 101.4 384 128c0 35.52-11.93 68.14-31.59 94.71C372.7 243.2 400.8 256 432 256z"/></svg>
            <p> Группы </p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link to="/schedule" class="nav-link">
                <svg class="nav-icon" width="20" height="20" fill="lightgreen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M336 64h-53.88C268.9 26.8 233.7 0 192 0S115.1 26.8 101.9 64H48C21.5 64 0 85.48 0 112v352C0 490.5 21.5 512 48 512h288c26.5 0 48-21.48 48-48v-352C384 85.48 362.5 64 336 64zM96 392c-13.25 0-24-10.75-24-24S82.75 344 96 344s24 10.75 24 24S109.3 392 96 392zM96 296c-13.25 0-24-10.75-24-24S82.75 248 96 248S120 258.8 120 272S109.3 296 96 296zM192 64c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S160 113.7 160 96C160 78.33 174.3 64 192 64zM304 384h-128C167.2 384 160 376.8 160 368C160 359.2 167.2 352 176 352h128c8.801 0 16 7.199 16 16C320 376.8 312.8 384 304 384zM304 288h-128C167.2 288 160 280.8 160 272C160 263.2 167.2 256 176 256h128C312.8 256 320 263.2 320 272C320 280.8 312.8 288 304 288z"/></svg>
                <p> Расписание </p>
            </router-link>
        </li>


      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Настройки
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/user/roles" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Роли
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/study_variants" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Варианты обучения
              </p>
            </router-link>
          </li>
        </ul>
      </li>

    @endcan



      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            Выйти из системы
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>

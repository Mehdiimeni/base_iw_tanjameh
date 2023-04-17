<?php
///template/global/nav.php
?>

<nav class="navbar navbar-expand-lg">
      <div class="container-lg">
          <div class="flex-fill d-none d-lg-flex">
            <ul class="navbar-nav fw-bold">
<?php foreach(get_nav() as $Nav){
  $selected_sting_a_css = 'nav-link nav-hover';
  $selected_sting_li_css = 'nav-item';
  if(@$_GET['gender'] == @$Nav->Name ){
      $selected_sting_a_css = 'nav-link  text-white';
      $selected_sting_li_css = 'nav-item mx-1 bg-dark';
  }
  
  ?>
              <li class="<?php echo($selected_sting_li_css); ?>">
                <a class=" <?php echo($selected_sting_a_css); ?>" href="./?gender=<?php echo(@$Nav->Name); ?>"><?php echo(@$Nav->LocalName); ?></a>
              </li>
<?php } ?>
            </ul>
          </div>
          <div class="flex-fill text-start text-lg-center">
            <a class="navbar-brand" href="./">
              <img src="./itemplates/iweb/media/logo.png" alt="Logo" class="d-inline-block align-text-top">
            </a>
          </div>
        <div class="flex-fill dropdhover">
          <ul class="navbar-nav float-end flex-row">
            <!-- account -->
            <li class="nav-item dropdown b-drop">              
                <a class="nav-link" href="#">
                <svg class="" height="1.3em" width="1.3em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="your-account-8883409" role="img" aria-hidden="false"><title id="your-account-8883409">پروفایل</title><path d="M21.645 22.866a28.717 28.717 0 0 0-6.46-7.817c-2.322-1.892-4.048-1.892-6.37 0a28.74 28.74 0 0 0-6.46 7.817.75.75 0 0 0 1.294.76 27.264 27.264 0 0 1 6.113-7.413A3.98 3.98 0 0 1 12 15.125a3.81 3.81 0 0 1 2.236 1.088 27.252 27.252 0 0 1 6.115 7.412.75.75 0 1 0 1.294-.76zM12 12.002A6.01 6.01 0 0 0 18.003 6 6.003 6.003 0 1 0 12 12.002zm0-10.505a4.502 4.502 0 1 1 0 9.005 4.502 4.502 0 0 1 0-9.005z"></path></svg>
              </a>
                <ul id="accountDrop" class="dropdown-menu b-animate b-dark border-0 rounded-0 position-absolute">
                  <!-- show li when user is not login -->
                  <li class="px-3 mt-2"><a class="btn btn-dark w-100 rounded-0" href="./login"><?php echo(_LANG['login']); ?></a></li>
<?php if (@$objACL->NormalUserLogin(dirname(__FILE__,4)  . '/irepository/log/login/user/' . $UserIdKey)) { ?>
                  <li class="b-animate b-purple px-3 pt-2">
                    <a class="text-decoration-none text-mediumpurple d-inline-block" href="./signin">ثبت نام</a>
                    <span class="font-x-s">- تنها یک دقیقه طول می کشد.</span>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <?php }else{ ?>
                  <!-- end show -->
                  <!-- show li when user is login -->
                  <li><a class="dropdown-item" href="#">پروفایلم</a></li>
                  <li><a class="dropdown-item" href="#">سفارشاتم</a></li>
                  <li><a class="dropdown-item" href="#">تماس و راهنما</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">
                    <div class="row fs-6">
                      <div class="col-9 text-truncate">username نیستی؟</div>
                      <div class="col-3">خروج</div>
                    </div>
                    </a></li>
                  <!-- end show -->
                  <?php } ?>
                </ul>
            </li>
            <!-- wishlist -->
            <li class="nav-item b-drop position-relative">
              <span class="heartCounter position-absolute top-0 end-0 badge rounded-circle bg-orange p-1 font-x-s">2</span>
              <a class="nav-link" href="#">
                <svg height="1.3em" width="1.5em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="wish-list-8883410" role="img" aria-hidden="false"><title id="wish-list-8883410">علاقمندی</title><path d="M17.488 1.11h-.146a6.552 6.552 0 0 0-5.35 2.81A6.57 6.57 0 0 0 6.62 1.116 6.406 6.406 0 0 0 .09 7.428c0 7.672 11.028 15.028 11.497 15.338a.745.745 0 0 0 .826 0c.47-.31 11.496-7.666 11.496-15.351a6.432 6.432 0 0 0-6.42-6.306zM12 21.228C10.018 19.83 1.59 13.525 1.59 7.442c.05-2.68 2.246-4.826 4.934-4.826h.088c2.058-.005 3.93 1.251 4.684 3.155.226.572 1.168.572 1.394 0 .755-1.907 2.677-3.17 4.69-3.16h.02c2.7-.069 4.96 2.118 5.01 4.817 0 6.089-8.429 12.401-10.41 13.8z"></path></svg>
              </a>
            </li>
            <!-- cart -->
            <li class="cart nav-item b-drop position-relative">
              <span class="items-basket position-absolute top-0 end-0 badge rounded-circle bg-orange p-1 font-x-s"></span>
              <a class="nav-link" href="#">
                <svg height="1.3em" width="1.3em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-labelledby="your-bag-8883411" role="img" aria-hidden="false"><title id="your-bag-8883411">سبد خرید</title><path d="M20.677 13.654a5.23 5.23 0 0 0 1.073-3.194c-.01-2.632-1.968-4.78-4.5-5.137V5.25a5.25 5.25 0 0 0-10.5 0v.059a5.224 5.224 0 0 0-2.444 1.014 5.23 5.23 0 0 0-.983 7.33A5.623 5.623 0 0 0 6.375 24h11.25a5.623 5.623 0 0 0 3.052-10.346zM12 1.5a3.75 3.75 0 0 1 3.75 3.75h-7.5A3.75 3.75 0 0 1 12 1.5zm5.625 21H6.375a4.122 4.122 0 0 1-1.554-7.942.75.75 0 0 0 .214-1.256A3.697 3.697 0 0 1 3.75 10.5a3.755 3.755 0 0 1 3-3.674V9a.75.75 0 0 0 1.5 0V6.75h7.5V9a.75.75 0 1 0 1.5 0V6.826a3.755 3.755 0 0 1 3 3.674c0 1.076-.47 2.1-1.285 2.802a.75.75 0 0 0 .213 1.256 4.122 4.122 0 0 1-1.553 7.942z"></path></svg>
              </a>
              <div id="cart-items" class="position-absolute z-3">
              <div id="bag-empty" class="pt-3 text-center">
                <h6 class="fw-semibold">سبد شما خالی است</h6>
                <h6 class="mx-2">برو آن را با تمام امیدها و رویاهای مد خود پر کن.</h6>
                <div class="text-bg-dark p-5">
                  <h6 class="fw-semibold">نمیدونی از کجا شروع کنی؟</h6>
                  <a href="#" class="btn box-shadow w-100 btn-outline-light rounded-0">جدیدترین ها را ببین</a>
                </div>
              </div>
                  <ol id="list-item-product">
                  </ol>
                  <div id="total-text">
                    <span class="me-2">جمع کل:</span><p id="total-price"></p>
                  </div>
                </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

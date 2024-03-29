<?php
///template/global/menu.php
?>
<nav class="navbar navbar-expand-lg menu p-0 border-bottom">

  <div class="container-lg">
    <a class="btn border-dark-subtle d-lg-none" data-bs-toggle="offcanvas" href="#offcanvasHome" role="button"
      aria-controls="offcanvasHome">
      <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ pVrzNP H3jvU7" height="1em" width="1em" focusable="false"
        fill="currentColor" viewBox="0 0 24 24" aria-labelledby="menu-6594495" role="img" aria-hidden="false">
        <title id="menu-6594495">Menu</title>
        <path
          d="M.75 2.25h22.5a.75.75 0 0 0 0-1.5H.75a.75.75 0 0 0 0 1.5zM23.25 21.75H.75a.75.75 0 0 0 0 1.5h22.5a.75.75 0 0 0 0-1.5zM.75 12.75h12a.75.75 0 0 0 0-1.5h-12a.75.75 0 0 0 0 1.5z">
        </path>
      </svg>
    </a>
    <div class="d-lg-block d-none">
      <ul class="navbar-nav">
        <?php if (get_menu(@$_GET['gender'])) {
          foreach (get_menu(@$_GET['gender']) as $Menu) { ?>
            <li class="nav-item dropdown has-megamenu">
              <a class="nav-link" href="./?gender=<?php echo @$_GET['gender'] ?>&category=<?php echo @$Menu->Name ?>"
                data-bs-toggle="dropdown"> <?php echo @$Menu->LocalName ?> </a>
              <div class="dropdown-menu megamenu rounded-0" role="menu">
                <div class="container-lg">
                  <div class="row b-animate b-dark">
                    <?php
                    $counter = 0;
                    if (get_category(@$_GET['gender'], @$Menu->Name)) {
                      foreach (get_category(@$_GET['gender'], @$Menu->Name) as $Category) {
                        if ($counter == 0 or $counter % 12 == 0) {
                          ?>
                          <div class="col">
                            <h5 class="text-black-50 mt-5"></h5>
                            <div class="d-grid cat">
                            <?php } ?>
                        <a
                          href="./?gender=<?php echo urlencode(@$_GET['gender']) ?>&category=<?php echo urlencode(@$Menu->Name); ?>&group=<?php echo urlencode(@$Category->Name); ?>&CatId=<?php echo @$Category->CatId; ?>"><i
                            class="fa-solid fa-shirt"></i>
                          <?php echo @$Category->LocalName ?>
                        </a>
                        <?php if ($counter != 0 and ($counter % 12 == 0 or count(get_category(@$_GET['gender'], @$Menu->Name)) == $counter + 1)) { ?>
                          </div>
                        </div>

                      <?php }
                        $counter++;
                      }
                    } // ?>
                    <div class="col">
                    </div>
                    <div class="col">
                      <div class="card bg-danger rounded-0 border-0 ps-4 mt-5" style="max-width: 18rem;">
                        <a href="#"><img src="./itemplates/iweb/media/owned-index.png" class="card-img-top" alt="..."></a>
                        <div class="card-body">
                          <p class="card-text b-animate b-light"><a href="./?gender=<?php echo @$_GET['gender']; ?>&category=<?php echo @$Category->Name ?>" class="text-white text-decoration-none ">خرید
                              <i class="fa-solid fa-arrow-left"></i></a></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


            </li>
          <?php }
        } // ?>
      </ul>
    </div>
    <!-- search all website -->
    <div>
      <div class="icon-search bg-gainsboro-light d-flex align-items-center justify-content-between p-1">
        <span class="fs-6 text-dark-emphasis"><?php echo _LANG['search']; ?></span>
        <i class="fa fa-search p-2" aria-hidden="trues"></i>
      </div>
      <div class="search-form">
        <input type="text" id="all_search" class="" placeholder="<?php echo _LANG['search_tip1']; ?>" onfocus="all_search()">
        <div class="result-search position-relative p-0">
          <div id="all_match_list"
            class="position-absolute bg-light-subtle w-100 overflow-y-scroll border-dark border border-top-0"
            style="max-height: 18rem;">
          </div>
        </div>
      </div>

    </div>
  </div>
</nav>
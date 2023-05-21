<?php
///template/global/mobile_view.php
?>
<div class="offcanvas offcanvas-start cat-offcanvas" tabindex="-1" id="offcanvasHome" aria-labelledby="offcanvasHomeLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasHomeLabel">پیمایش در دسته بندی</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr class="m-0">
        <div class="offcanvas-body p-0 overflow-y-scroll overflow-x-hidden">
          <nav>
            <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
            <?php foreach (get_menu(@$_GET['gender']) as $Menu) { ?>
              <button class="nav-link active text-black-50 rounded-0" id="nav-<?php echo @$Menu->Name ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?php echo @$Menu->Name ?>" type="button" role="tab" aria-controls="nav-<?php echo @$Menu->Name ?>" aria-selected="true"><?php echo @$Menu->LocalName ?></button>
              <div class="vr"></div>
              <?php } ?>
            
            </div>
          </nav>
          <div class="tab-content shadow-sm" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-women" role="tabpanel" aria-labelledby="nav-women-tab" tabindex="0">
                <div class="row g-2">
                  <div class="col-6">
                      <div class="card rounded-0 border-0">
                        <a href="#" class="text-dark text-decoration-none"><img src="media/new-collapse.png" class="card-img-top" alt="...">
                        <div class="card-body">
                          <p class="card-text">جدید</p>
                        </div>
                      </a>
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="card rounded-0 border-0">
                        <a href="#" class="text-dark text-decoration-none"><img src="media/look-collapse.png" class="card-img-top" alt="...">
                        <div class="card-body">
                          <p class="card-text">نمایش</p>
                        </div>
                      </a>
                      </div>
                  </div>
                  <div class="col-6">
                    <div class="card rounded-0 border-0">
                      <a href="#" class="text-dark text-decoration-none"><img src="media/shoes-collapse.png" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">کفش</p>
                      </div>
                    </a>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card rounded-0 border-0">
                      <a href="#" class="text-dark text-decoration-none"><img src="media/accessory-collapse.png" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">اکسسوری</p>
                      </div>
                    </a>
                    </div>
                  </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-men" role="tabpanel" aria-labelledby="nav-men-tab" tabindex="0">
                <div class="row g-2">
                  <div class="col-6">
                      <div class="card rounded-0 border-0">
                        <a href="#" class="text-dark text-decoration-none"><img src="media/new-collapse.png" class="card-img-top" alt="...">
                        <div class="card-body">
                          <p class="card-text">جدید</p>
                        </div>
                      </a>
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="card rounded-0 border-0">
                        <a href="#" class="text-dark text-decoration-none"><img src="media/look-collapse.png" class="card-img-top" alt="...">
                        <div class="card-body">
                          <p class="card-text">نمایش</p>
                        </div>
                      </a>
                      </div>
                  </div>
                  <div class="col-6">
                    <div class="card rounded-0 border-0">
                      <a href="#" class="text-dark text-decoration-none"><img src="media/shoes-collapse.png" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">کفش</p>
                      </div>
                    </a>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card rounded-0 border-0">
                      <a href="#" class="text-dark text-decoration-none"><img src="media/accessory-collapse.png" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">اکسسوری</p>
                      </div>
                    </a>
                    </div>
                  </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-kids" role="tabpanel" aria-labelledby="nav-kids-tab" tabindex="0">
                <div class="row g-2">
                  <div class="col-6">
                      <div class="card rounded-0 border-0">
                        <a href="#" class="text-dark text-decoration-none"><img src="media/new-collapse.png" class="card-img-top" alt="...">
                        <div class="card-body">
                          <p class="card-text">جدید</p>
                        </div>
                      </a>
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="card rounded-0 border-0">
                        <a href="#" class="text-dark text-decoration-none"><img src="media/look-collapse.png" class="card-img-top" alt="...">
                        <div class="card-body">
                          <p class="card-text">نمایش</p>
                        </div>
                      </a>
                      </div>
                  </div>
                  <div class="col-6">
                    <div class="card rounded-0 border-0">
                      <a href="#" class="text-dark text-decoration-none"><img src="media/shoes-collapse.png" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">کفش</p>
                      </div>
                    </a>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card rounded-0 border-0">
                      <a href="#" class="text-dark text-decoration-none"><img src="media/accessory-collapse.png" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">اکسسوری</p>
                      </div>
                    </a>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="bg-body-secondary py-3">
            <div class="card py-2 px-4 shadow-sm rounded-0">
              <a href="#" class="fs-5 text-decoration-none text-dark">
                <span class="">راهنما</span>
                <i class="fa-solid fa-arrow-left float-end"></i>
              </a>
              </div>
              <div class="card py-2 px-4 shadow-sm rounded-0">
                <a href="#" class="fs-5 text-decoration-none text-dark">
                  <span class="">خبرنامه</span>
                  <i class="fa-solid fa-arrow-left float-end"></i>
                </a>
                </div>
                <div class="card py-2 px-4 shadow-sm mt-3 rounded-0">
                  <a href="#" class="fs-5 text-decoration-none text-dark">
                    <span class="">خروج</span>
                  </a>
                  </div>
          </div>
        </div>
      </div>
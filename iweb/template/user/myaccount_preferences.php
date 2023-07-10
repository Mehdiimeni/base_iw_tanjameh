<?php
///template/user/myaccount_preferences.php
?>

    <!-- side right -->
    <div class="col-12 col-lg-9">
      <h3 class="fw-bold mb-5">مارک های شما</h3>
      <div class="d-block d-sm-flex justify-content-sm-between align-items-sm-center mb-4">
      <h4 class="fw-bold">مارک هایی که دنبال می کنید</h4>
      <!-- Button trigger modal Add Brand -->
      <button class="btn btn-dark fs-6 fw-bold py-3 d-flex align-items-center rounded-0" data-bs-toggle="modal" data-bs-target="#addBrand"><i class="fa fa-plus me-2"></i><span>افزودن برند</span></button>
      <!-- Modal Add Brand -->
      <div class="modal fade" id="addBrand" tabindex="-1" aria-labelledby="addBrandLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content rounded-0">
            <div class="modal-header border-0">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div>
                <h4 class="fw-semibold m-3">تمام برندها</h4>
                <div class="input-group py-3 border-bottom">
                  <input type="search" id="search_filter" class="form-control form-control-lg border-dark rounded-0 border-end-0" placeholder="جستجوی برند" aria-label="Recipient's brand" aria-describedby="brand-addon1" onkeyup="searchFilter()">
                  <span class="input-group-text border-dark rounded-0 border-start-0 bg-light-subtle" id="brand-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                </div>
                <div class="content-filter overflow-y-scroll overflow-x-hidden px-2" style="max-height: 330px;">
                <ul id="ul_search_filter" class="list-unstyled">
                <li class="border-bottom">
                  <div class="ms-3 py-2 d-flex align-items-center">
                    <!-- data-url link to brand page -->
                    <label class="brandName" data-url="nike.html">nike</label>
                    <button class="btn border-1 rounded-0 btn-outline-dark ms-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
                  </div>
              </li>
              <li class="border-bottom">
                <div class="ms-3 py-2 d-flex align-items-center">
                    <!-- data-url link to brand page -->
                  <label class="brandName" data-url="boss.html">boss</label>
                  <button class="btn border-1 rounded-0 btn-outline-dark ms-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
                </div>
            </li>
                </ul>
                </div>
          </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      <ul id="boxBrandSelected" class="row row-cols-1 row-cols-md-2 g-3 list-unstyled mb-5">
      </ul>
      <h4 class="fw-bold mb-1">برندهای پیشنهادی</h4>
      <h4 class="mb-3">ابتدا چیزهای بیشتری از آنها خواهید دید، از جمله موارد و مجموعه‌های جدید.</h4>
     <!-- carousel autowidth nonloop (Brand) -->
<div class="my-5">
  <div class=" position-relative overflow-hidden">
    <div class="container position-absolute bottom-50 z-2">
      <div class="position-relative index-owl-nav"></div>
    </div>
      <div class="owl-autowidth owl-carousel">
              <div class="item">
               <a href="#" class="text-decoration-none">
                <div class="card text-dark rounded-0 border-0 bg-transparent">
                  <div class="carousel-brand-item border border-1">
                    <img data-src="media/brand/index/brand-b1.webp" class="card-img rounded-0 owl-lazy" alt="...">
                  </div>
                  <div class="card-body p-0 py-2">
                    <h6 class="brandName m-0 text-truncate" data-url="nike.html">Nike Performance</h6>
                  </div>
                </div>
               </a>
               <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
              </div>
              <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b2.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="Carhartt">Carhartt WIP</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
               <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b3.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="Levi's.html">Levi's®</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
               <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b4.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="North.html">The North Face</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
               <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b5.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="Jack.html">Jack & Jones</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
               <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b6.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="Anna.html">Anna Field</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
               <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b7.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="mango.html">Mango</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
               <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b8.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="Lacoste.html">Lacoste</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
               <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b9.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="Tommy.html">Tommy Hilfiger</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
               <div class="item">
                <a href="#" class="text-decoration-none">
                 <div class="card text-dark rounded-0 border-0 bg-transparent">
                   <div class="carousel-brand-item border border-1">
                     <img data-src="media/brand/index/brand-b10.webp" class="card-img rounded-0 owl-lazy" alt="...">
                   </div>
                   <div class="card-body p-0 py-2">
                     <h6 class="m-0 text-truncate brandName" data-url="Pier.html">Pier One</h6>
                   </div>
                 </div>
                </a>
                <button class="btn border-1 rounded-0 btn-outline-dark m-auto d-flex align-items-center clike-follow notfollow"><i class="fa-solid fa-plus me-2"></i><span>دنبال کنید</span></button>
               </div>
      </div>
  </div>
  </div>
  <!-- end carousel -->
</div>
</div>
<!-- toast follow brand -->
<div  class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="brandFollowToast" class="toast text-bg-success border-0 rounded-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        برند مورد نظر را دنبال نمودید
      </div>
      <i class="fa-regular fa-circle-check me-2 m-auto"></i>
    </div>
  </div>
</div>
</div>
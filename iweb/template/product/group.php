<?php
///template/product/group.php
?>
<div class="container-md pt-5">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb b-animate b-dark">
      <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark fw-semibold d-inline-block">مردانه</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">لباس</li>
    </ol>
  </nav>
  <h1 class="fw-semibold mb-5">لباس مردانه</h1>
  <div class="row my-4">
    <div class="col-12 col-lg-3 b-animate b-dark brand-cat lh-lg">
      <ul class="list-unstyled">
        <li>
          <span class="text-mediumpurple fw-bold">لباس</span>
          <ul class="list-unstyled ms-0 ms-lg-3 d-flex d-lg-block scroll-y-nowrap">
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">تی شرت و پولو</a>
            </li>
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">پیراهن</a>
            </li>
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">سویشرت و هودی</a>
            </li>
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">جین</a>
            </li>
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">اسپورت</a>
            </li>
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">ژاکت</a>
            </li>
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">کت</a>
            </li>
            <li class="list-active d-inline-block d-lg-block">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">شلوار</a>
            </li>
            <li class="list-deactive">
              <a href="#" class="text-decoration-none text-dark d-inline-block d-lg-block">بلوز</a>
            </li>
          </ul>
        </li>
      </ul>
      <hr class="d-lg-none">
    </div>
    <div class="col-12 col-lg-9">
      <!-- filter box -->
     <div class="div-filter">
      <div class="dropdown d-inline-block mt-1">
        <button type="button" class="btn btn-outline-dark border-2 rounded-0 dropdown-toggle fw-bold lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
          مرتب سازی
        </button>
        <form class="dropdown-menu rounded-0">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100  py-3"><span class="float-start">محبوبترین</span></button>
            <hr class="ms-3 m-0 border-dark-subtle">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100 py-3 fw-bold"><span class="float-start">جدیدترین</span><i class="fa-solid fa-check float-end"></i></button>
            <hr class="ms-3 m-0 border-dark-subtle">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100 py-3"><span class="float-start">پایین ترین قیمت</span></button>
            <hr class="ms-3 m-0 border-dark-subtle">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100 py-3"><span class="float-start">بالاترین قیمت</span></button>
            <hr class="ms-3 m-0 border-dark-subtle">
            <button type="submit" class="btn btn-outline-light text-dark rounded-0 w-100 py-3"><span class="float-start">حراجی</span></button>
        </form>
      </div>
      <div class="dropdown d-inline-block mt-1">
        <button type="button" class="btn btn-outline-dark border-2 rounded-0 dropdown-toggle fw-bold lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
          <span>برند</span><span class="p-1 text-bg-dark font-x-s ms-1">1</span>
        </button>
        <form class="dropdown-menu p-0 rounded-0 b-animate b-purple" id="choiceAll">
          <div class="input-group p-3 border-bottom">
            <input type="search" id="search_filter" class="form-control border-dark rounded-0 border-end-0" placeholder="جستجوی برند" aria-label="Recipient's brand" aria-describedby="brand-addon1" onkeyup="searchFilter()">
            <span class="input-group-text border-dark rounded-0 border-start-0 bg-light-subtle" id="brand-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
          </div>
          <div class="content-filter overflow-y-scroll overflow-x-hidden">
            <h6 class="fw-semibold m-3">تمام برندها</h6>
          <a class="btn ms-3 p-0 text-mediumpurple text-decoration-none d-block" id="checkall">انتخاب همه</a>
          <ul id="ul_search_filter" class="list-unstyled">
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="brandID1">آدیداس</label>
                <input class="form-check-input" type="checkbox" id="brandID1">
              </div>
          </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="brandID2">نایک</label>
                <input class="form-check-input" type="checkbox" id="brandID2">
              </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID3">BOSS</label>
              <input class="form-check-input" type="checkbox" id="brandID3">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID4">Reebok</label>
              <input class="form-check-input" type="checkbox" id="brandID4">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID5">Champion</label>
              <input class="form-check-input" type="checkbox" id="brandID5">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID6">Diadora</label>
              <input class="form-check-input" type="checkbox" id="brandID6">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID7">DKNY</label>
              <input class="form-check-input" type="checkbox" id="brandID7">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID8">Fila</label>
              <input class="form-check-input" type="checkbox" id="brandID8">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID9">Jack & Jones Performance</label>
              <input class="form-check-input" type="checkbox" id="brandID9">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID10">Jordan</label>
              <input class="form-check-input" type="checkbox" id="brandID10">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID11">Lotto</label>
              <input class="form-check-input" type="checkbox" id="brandID11">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID12">nike</label>
              <input class="form-check-input" type="checkbox" id="brandID12">
            </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <label class="form-check-label flex-grow-1 text-start" for="brandID13">puma</label>
              <input class="form-check-input" type="checkbox" id="brandID13">
            </div>
          </li>
          </ul>
          </div>
          <div class="d-flex overflow-hidden border-top">
            <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
            <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
          </div>
        </form>
        </div>
        <div class="dropdown d-inline-block mt-1">
          <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            اندازه
          </button>
          <form class="dropdown-menu p-0 rounded-0">
            <div class="content-filter overflow-y-scroll overflow-x-hidden">
            <ul id="ul_search_filter" class="list-unstyled pt-2">
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="1.5k">1.5k</label>
                  <input class="form-check-input" type="checkbox" id="1.5k">
                </div>
            </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="2.5k">2.5k</label>
                  <input class="form-check-input" type="checkbox" id="2.5k">
                </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="3.5k">3.5k</label>
                <input class="form-check-input" type="checkbox" id="3.5k">
              </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="4.5k">4.5k</label>
                <input class="form-check-input" type="checkbox" id="4.5k">
              </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="5.5k">5.5k</label>
                <input class="form-check-input" type="checkbox" id="5.5k">
              </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="6.5k">6.5k</label>
                <input class="form-check-input" type="checkbox" id="6.5k">
              </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="7.5k">7.5k</label>
                <input class="form-check-input" type="checkbox" id="7.5k">
              </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="8.5k">8.5k</label>
                <input class="form-check-input" type="checkbox" id="8.5k">
              </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="9.5k">9.5k</label>
                <input class="form-check-input" type="checkbox" id="9.5k">
              </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <label class="form-check-label flex-grow-1 text-start" for="10.5k">10.5k</label>
                <input class="form-check-input" type="checkbox" id="10.5k">
              </div>
            </li>
            </ul>
            </div>
            <div class="d-flex overflow-hidden border-top">
              <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
              <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
            </div>
          </form>
          </div>
          <div class="dropdown d-inline-block mt-1">
            <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              نوع ورزش
            </button>
            <form class="dropdown-menu p-0 rounded-0">
              <div class="content-filter overflow-y-scroll overflow-x-hidden">
              <ul id="ul_search_filter" class="list-unstyled pt-2">
                <li class="border-bottom">
                  <div class="form-check form-check-inline d-flex align-items-center">
                    <label class="form-check-label flex-grow-1 text-start" for="sportID1">فوتبال</label>
                    <input class="form-check-input" type="checkbox" id="sportID1">
                  </div>
              </li>
                <li class="border-bottom">
                  <div class="form-check form-check-inline d-flex align-items-center">
                    <label class="form-check-label flex-grow-1 text-start" for="sportID2">والیبال</label>
                    <input class="form-check-input" type="checkbox" id="sportID2">
                  </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="sportID3">بسکتبال</label>
                  <input class="form-check-input" type="checkbox" id="sportID3">
                </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="sportID4">تکواندو</label>
                  <input class="form-check-input" type="checkbox" id="sportID4">
                </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="sportID5">کشتی</label>
                  <input class="form-check-input" type="checkbox" id="sportID5">
                </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="sportID6">شنا</label>
                  <input class="form-check-input" type="checkbox" id="sportID6">
                </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="sportID7">بوکس</label>
                  <input class="form-check-input" type="checkbox" id="sportID7">
                </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="sportID8">فیتنس</label>
                  <input class="form-check-input" type="checkbox" id="sportID8">
                </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="sportID9">یوگا</label>
                  <input class="form-check-input" type="checkbox" id="sportID9">
                </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <label class="form-check-label flex-grow-1 text-start" for="sportID10">بدنسازی</label>
                  <input class="form-check-input" type="checkbox" id="sportID10">
                </div>
              </li>
              </ul>
              </div>
              <div class="d-flex overflow-hidden border-top">
                <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
              </div>
            </form>
            </div>
            <div class="dropdown d-inline-block mt-1">
              <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                کیفیت
              </button>
              <form class="dropdown-menu p-0 rounded-0 b-animate b-purple">
                <div class="content-filter">
                  <h6 class="m-3 font-x-s">مواردی را پیدا کنید که منعکس کننده چیزهایی هستند که برای شما مهم هستند.</h6>
                <a class="btn ms-3 p-0 text-mediumpurple text-decoration-none d-block" onclick="eventCheckBox()">انتخاب همه</a>
                <ul id="ul_search_filter" class="list-unstyled">
                  <li class="border-bottom">
                    <div class="form-check form-check-inline d-flex align-items-center">
                      <label class="form-check-label flex-grow-1 text-start" for="qualityID1">مواد ارگانیک</label>
                      <input class="form-check-input" type="checkbox" id="qualityID1">
                    </div>
                </li>
                  <li class="border-bottom">
                    <div class="form-check form-check-inline d-flex align-items-center">
                      <label class="form-check-label flex-grow-1 text-start" for="qualityID2">مواد بازیافت شده</label>
                      <input class="form-check-input" type="checkbox" id="qualityID2">
                    </div>
                </li>
                </ul>
                </div>
                <div class="d-flex overflow-hidden border-top">
                  <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                  <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                </div>
              </form>
              </div>
              <div class="dropdown d-inline-block mt-1">
                <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  رنگ
                </button>
                <form class="dropdown-menu p-0 rounded-0">
                  <div class="content-filter overflow-y-scroll overflow-x-hidden">
                  <ul id="ul_search_filter" class="list-unstyled pt-2">
                    <li class="border-bottom">
                      <div class="form-check form-check-inline d-flex align-items-center">
                        <span class="badge bg-dark-900 p-2 rounded-0"> </span>
                        <label class="form-check-label flex-grow-1 text-start" for="colorID1">مشکی</label>
                        <input class="form-check-input" type="checkbox" id="colorID1">
                      </div>
                  </li>
                  <li class="border-bottom">
                    <div class="form-check form-check-inline d-flex align-items-center">
                      <span class="badge bg-primary p-2 rounded-0"> </span>
                      <label class="form-check-label flex-grow-1 text-start" for="colorID2">آبی</label>
                      <input class="form-check-input" type="checkbox" id="colorID2">
                    </div>
                </li>
                <li class="border-bottom">
                  <div class="form-check form-check-inline d-flex align-items-center">
                    <span class="badge bg-danger p-2 rounded-0"> </span>
                    <label class="form-check-label flex-grow-1 text-start" for="colorID3">قرمز</label>
                    <input class="form-check-input" type="checkbox" id="colorID3">
                  </div>
              </li>
              <li class="border-bottom">
                <div class="form-check form-check-inline d-flex align-items-center">
                  <span class="badge bg-secondary p-2 rounded-0"> </span>
                  <label class="form-check-label flex-grow-1 text-start" for="colorID4">خاکستری</label>
                  <input class="form-check-input" type="checkbox" id="colorID4">
                </div>
            </li>
            <li class="border-bottom">
              <div class="form-check form-check-inline d-flex align-items-center">
                <span class="badge bg-success p-2 rounded-0"> </span>
                <label class="form-check-label flex-grow-1 text-start" for="colorID5">سبز</label>
                <input class="form-check-input" type="checkbox" id="colorID5">
              </div>
          </li>
          <li class="border-bottom">
            <div class="form-check form-check-inline d-flex align-items-center">
              <span class="badge bg-light border p-2 rounded-0"> </span>
              <label class="form-check-label flex-grow-1 text-start" for="colorID6">سفید</label>
              <input class="form-check-input" type="checkbox" id="colorID6">
            </div>
        </li>
        <li class="border-bottom">
          <div class="form-check form-check-inline d-flex align-items-center">
            <span class="badge bg-orange p-2 rounded-0"> </span>
            <label class="form-check-label flex-grow-1 text-start" for="colorID7">نارنجی</label>
            <input class="form-check-input" type="checkbox" id="colorID7">
          </div>
      </li>
      <li class="border-bottom">
        <div class="form-check form-check-inline d-flex align-items-center">
          <span class="badge bg-pink p-2 rounded-0"> </span>
          <label class="form-check-label flex-grow-1 text-start" for="colorID8">صورتی</label>
          <input class="form-check-input" type="checkbox" id="colorID8">
        </div>
    </li>
                  </ul>
                  </div>
                  <div class="d-flex overflow-hidden border-top">
                    <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                    <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                  </div>
                </form>
                </div>
                <div class="dropdown d-inline-block mt-1">
                  <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    قیمت
                  </button>
                  <form class="dropdown-menu p-0 rounded-0">
                    <div class="content-filter overflow-y-scroll overflow-x-hidden">
                      <div class="range-slider m-3">
                        <span class="rangeValues"></span>
                        <input value="50000" min="1000" max="50000" step="500" type="range">
                        <input value="1000" min="1000" max="50000" step="500" type="range">
                      </div>
                    <ul class="list-unstyled pt-2">
                      <li class="border-bottom">
                        <div class="form-check form-check-inline form-switch d-flex align-items-center">
                          <label class="form-check-label flex-grow-1 text-start" for="priceID1">حراجی</label>
                          <input class="form-check-input" type="checkbox" role="switch" id="priceID1">
                        </div>
                    </li>
                    <li class="border-bottom">
                      <div class="form-check form-check-inline form-switch d-flex align-items-center">
                        <label class="form-check-label flex-grow-1 text-start" for="priceID2">ارسال رایگان</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="priceID2">
                      </div>
                      <small class="ms-5">برای سفارشات بیش از 500.000 تومان </small>
                  </li>
                    </ul>
                    </div>
                    <div class="d-flex overflow-hidden border-top">
                      <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                      <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                    </div>
                  </form>
                  </div>
                  <div class="dropdown d-inline-block mt-1">
                    <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                      نوع جنس
                    </button>
                    <form class="dropdown-menu p-0 rounded-0">
                      <div class="content-filter overflow-y-scroll overflow-x-hidden">
                      <ul class="list-unstyled pt-2">
                        <li class="border-bottom">
                          <div class="form-check form-check-inline d-flex align-items-center">
                            <label class="form-check-label flex-grow-1 text-start" for="materialID1">کتان</label>
                            <input class="form-check-input" type="checkbox" id="materialID1">
                          </div>
                      </li>
                        <li class="border-bottom">
                          <div class="form-check form-check-inline d-flex align-items-center">
                            <label class="form-check-label flex-grow-1 text-start" for="materialID2">پشم گوسفند</label>
                            <input class="form-check-input" type="checkbox" id="materialID2">
                          </div>
                      </li>
                      <li class="border-bottom">
                        <div class="form-check form-check-inline d-flex align-items-center">
                          <label class="form-check-label flex-grow-1 text-start" for="materialID3">چرم</label>
                          <input class="form-check-input" type="checkbox" id="materialID3">
                        </div>
                      </li>
                      <li class="border-bottom">
                        <div class="form-check form-check-inline d-flex align-items-center">
                          <label class="form-check-label flex-grow-1 text-start" for="materialID4">کشباف</label>
                          <input class="form-check-input" type="checkbox" id="materialID4">
                        </div>
                      </li>
                      <li class="border-bottom">
                        <div class="form-check form-check-inline d-flex align-items-center">
                          <label class="form-check-label flex-grow-1 text-start" for="materialID5">کشتی</label>
                          <input class="form-check-input" type="checkbox" id="materialID5">
                        </div>
                      </li>
                      <li class="border-bottom">
                        <div class="form-check form-check-inline d-flex align-items-center">
                          <label class="form-check-label flex-grow-1 text-start" for="materialID6">بافت</label>
                          <input class="form-check-input" type="checkbox" id="materialID6">
                        </div>
                      </li>
                      <li class="border-bottom">
                        <div class="form-check form-check-inline d-flex align-items-center">
                          <label class="form-check-label flex-grow-1 text-start" for="materialID7">مش</label>
                          <input class="form-check-input" type="checkbox" id="materialID7">
                        </div>
                      </li>
                      </ul>
                      </div>
                      <div class="d-flex overflow-hidden border-top">
                        <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                        <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                      </div>
                    </form>
                    </div>
                    <div class="dropdown d-inline-block mt-1">
                      <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        فصل
                      </button>
                      <form class="dropdown-menu p-0 rounded-0">
                        <div class="content-filter">
                        <ul class="list-unstyled pt-2">
                          <li class="border-bottom">
                            <div class="form-check form-check-inline d-flex align-items-center">
                              <label class="form-check-label flex-grow-1 text-start" for="seasonID1">بهاره/تابستانه</label>
                              <input class="form-check-input" type="checkbox" id="seasonID1">
                            </div>
                        </li>
                          <li class="border-bottom">
                            <div class="form-check form-check-inline d-flex align-items-center">
                              <label class="form-check-label flex-grow-1 text-start" for="seasonID2">پاییزه/تابستانه</label>
                              <input class="form-check-input" type="checkbox" id="seasonID2">
                            </div>
                        </li>
                        </ul>
                        </div>
                        <div class="d-flex overflow-hidden border-top">
                          <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                          <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                        </div>
                      </form>
                      </div>
                      <div class="dropdown d-inline-block mt-1">
                        <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                          بالای شلوار
                        </button>
                        <form class="dropdown-menu p-0 rounded-0">
                          <div class="content-filter">
                          <ul class="list-unstyled pt-2">
                            <li class="border-bottom">
                              <div class="form-check form-check-inline d-flex align-items-center">
                                <label class="form-check-label flex-grow-1 text-start" for="trouserRiseID1">کوتاه</label>
                                <input class="form-check-input" type="checkbox" id="trouserRiseID1">
                              </div>
                          </li>
                            <li class="border-bottom">
                              <div class="form-check form-check-inline d-flex align-items-center">
                                <label class="form-check-label flex-grow-1 text-start" for="trouserRiseID2">معمولی</label>
                                <input class="form-check-input" type="checkbox" id="trouserRiseID2">
                              </div>
                          </li>
                          <li class="border-bottom">
                            <div class="form-check form-check-inline d-flex align-items-center">
                              <label class="form-check-label flex-grow-1 text-start" for="trouserRiseID3">بلند</label>
                              <input class="form-check-input" type="checkbox" id="trouserRiseID3">
                            </div>
                        </li>
                          </ul>
                          </div>
                          <div class="d-flex overflow-hidden border-top">
                            <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                            <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                          </div>
                        </form>
                        </div>
                        <div class="dropdown d-inline-block mt-1">
                          <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            فیت
                          </button>
                          <form class="dropdown-menu p-0 rounded-0">
                            <div class="content-filter">
                              <h6 class="m-3 font-x-s">بر اساس موارد تنگ تر یا شل تر مرور کنید</h6>
                            <ul class="list-unstyled pt-2">
                              <li class="border-bottom">
                                <div class="form-check form-check-inline d-flex align-items-center">
                                  <label class="form-check-label flex-grow-1 text-start" for="fitID1">لاغری</label>
                                  <input class="form-check-input" type="checkbox" id="fitID1">
                                </div>
                            </li>
                              <li class="border-bottom">
                                <div class="form-check form-check-inline d-flex align-items-center">
                                  <label class="form-check-label flex-grow-1 text-start" for="fitID2">باریک</label>
                                  <input class="form-check-input" type="checkbox" id="fitID2">
                                </div>
                            </li>
                            <li class="border-bottom">
                              <div class="form-check form-check-inline d-flex align-items-center">
                                <label class="form-check-label flex-grow-1 text-start" for="fitID3">منظم</label>
                                <input class="form-check-input" type="checkbox" id="fitID3">
                              </div>
                          </li>
                          <li class="border-bottom">
                            <div class="form-check form-check-inline d-flex align-items-center">
                              <label class="form-check-label flex-grow-1 text-start" for="fitID4">آرام/شل</label>
                              <input class="form-check-input" type="checkbox" id="fitID4">
                            </div>
                        </li>
                        <li class="border-bottom">
                          <div class="form-check form-check-inline d-flex align-items-center">
                            <label class="form-check-label flex-grow-1 text-start" for="fitID5">بزرگ</label>
                            <input class="form-check-input" type="checkbox" id="fitID5">
                          </div>
                      </li>
                            </ul>
                            </div>
                            <div class="d-flex overflow-hidden border-top">
                              <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                              <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                            </div>
                          </form>
                          </div>
                          <div class="d-inline-block mt-1">
                            <button type="button" class="btn btn-outline-dark border-1 rounded-0 lh-lg fw-semibold" id="btn_showDiv" onclick="showDiv()">
                              نمایش همه فیلترها
                              <svg class="zds-icon RC794g X9n9TI DlJ4rT _5Yd-hZ iXbgaG nXkCf3 DlJ4rT _9l1hln mx_ksa fzejeK" height="1.4em" width="1.4em" focusable="false" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M.75 8.25h11.326A4.491 4.491 0 0 0 16.5 12a4.496 4.496 0 0 0 4.424-3.75h2.326a.75.75 0 0 0 0-1.5h-2.326C20.566 4.624 18.728 3 16.5 3s-4.066 1.624-4.424 3.75H.75a.75.75 0 0 0 0 1.5zM16.5 4.5a3 3 0 1 1 0 6 3 3 0 0 1 0-6zM23.25 15.75H11.924C11.566 13.624 9.728 12 7.5 12s-4.066 1.624-4.424 3.75H.75a.75.75 0 0 0 0 1.5h2.326A4.491 4.491 0 0 0 7.5 21a4.496 4.496 0 0 0 4.424-3.75H23.25a.75.75 0 0 0 0-1.5zM7.5 19.5a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"></path></svg>
                            </button>
                          </div>
                          <!-- show another filter -->
                          <div id="show_div">
                            <div class="dropdown d-inline-block mt-1">
                              <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                شکل
                              </button>
                              <form class="dropdown-menu p-0 rounded-0">
                                <div class="content-filter">
                                  <h6 class="m-3 font-x-s">بر اساس شکل و سیلوئت مرور کنید</h6>
                                <ul class="list-unstyled pt-2">
                                  <li class="border-bottom">
                                    <div class="form-check form-check-inline d-flex align-items-center">
                                      <label class="form-check-label flex-grow-1 text-start" for="shapeID1">سر راست</label>
                                      <input class="form-check-input" type="checkbox" id="shapeID1">
                                    </div>
                                </li>
                                  <li class="border-bottom">
                                    <div class="form-check form-check-inline d-flex align-items-center">
                                      <label class="form-check-label flex-grow-1 text-start" for="shapeID2">چسبان</label>
                                      <input class="form-check-input" type="checkbox" id="shapeID2">
                                    </div>
                                </li>
                                <li class="border-bottom">
                                  <div class="form-check form-check-inline d-flex align-items-center">
                                    <label class="form-check-label flex-grow-1 text-start" for="shapeID3">مخروطی</label>
                                    <input class="form-check-input" type="checkbox" id="shapeID3">
                                  </div>
                              </li>
                              <li class="border-bottom">
                                <div class="form-check form-check-inline d-flex align-items-center">
                                  <label class="form-check-label flex-grow-1 text-start" for="shapeID4">پیله</label>
                                  <input class="form-check-input" type="checkbox" id="shapeID4">
                                </div>
                            </li>
                                </ul>
                                </div>
                                <div class="d-flex overflow-hidden border-top">
                                  <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                                  <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                                </div>
                              </form>
                              </div>
                                <div class="dropdown d-inline-block mt-1">
                                  <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    اندازه های تخصصی
                                  </button>
                                  <form class="dropdown-menu p-0 rounded-0">
                                    <div class="content-filter">
                                    <ul class="list-unstyled pt-2">
                                      <li class="border-bottom">
                                        <div class="form-check form-check-inline d-flex align-items-center">
                                          <label class="form-check-label flex-grow-1 text-start" for="specialID1">استاندارد</label>
                                          <input class="form-check-input" type="checkbox" id="specialID1">
                                        </div>
                                    </li>
                                      <li class="border-bottom">
                                        <div class="form-check form-check-inline d-flex align-items-center">
                                          <label class="form-check-label flex-grow-1 text-start" for="specialID2">سایز پلاس</label>
                                          <input class="form-check-input" type="checkbox" id="specialID2">
                                        </div>
                                    </li>
                                    </ul>
                                    </div>
                                    <div class="d-flex overflow-hidden border-top">
                                      <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                                      <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                                    </div>
                                  </form>
                                  </div>
                                  <div class="dropdown d-inline-block mt-1">
                                    <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                      الگو
                                    </button>
                                    <form class="dropdown-menu p-0 rounded-0">
                                      <div class="content-filter">
                                      <ul class="list-unstyled pt-2">
                                        <li class="border-bottom">
                                          <div class="form-check form-check-inline d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-start" for="patternID1">چاپ حیوانی</label>
                                            <input class="form-check-input" type="checkbox" id="patternID1">
                                          </div>
                                      </li>
                                        <li class="border-bottom">
                                          <div class="form-check form-check-inline d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-start" for="patternID2">سوختن</label>
                                            <input class="form-check-input" type="checkbox" id="patternID2">
                                          </div>
                                      </li>
                                      <li class="border-bottom">
                                        <div class="form-check form-check-inline d-flex align-items-center">
                                          <label class="form-check-label flex-grow-1 text-start" for="patternID3">ارتشی</label>
                                          <input class="form-check-input" type="checkbox" id="patternID3">
                                        </div>
                                    </li>
                                    <li class="border-bottom">
                                      <div class="form-check form-check-inline d-flex align-items-center">
                                        <label class="form-check-label flex-grow-1 text-start" for="patternID4">گرادیان رنگ</label>
                                        <input class="form-check-input" type="checkbox" id="patternID4">
                                      </div>
                                  </li>
                                  <li class="border-bottom">
                                    <div class="form-check form-check-inline d-flex align-items-center">
                                      <label class="form-check-label flex-grow-1 text-start" for="patternID5">رنگارنگ</label>
                                      <input class="form-check-input" type="checkbox" id="patternID5">
                                    </div>
                                </li>
                                      </ul>
                                      </div>
                                      <div class="d-flex overflow-hidden border-top">
                                        <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                                        <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                                      </div>
                                    </form>
                                    </div>
                                    <div class="dropdown d-inline-block mt-1">
                                      <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                        جدید
                                      </button>
                                      <form class="dropdown-menu p-0 rounded-0">
                                        <div class="content-filter">
                                        <ul class="list-unstyled pt-2">
                                          <li class="border-bottom">
                                            <div class="form-check form-check-inline d-flex align-items-center">
                                              <label class="form-check-label flex-grow-1 text-start" for="newID1">این هفته</label>
                                              <input class="form-check-input" type="checkbox" id="newID1">
                                            </div>
                                        </li>
                                          <li class="border-bottom">
                                            <div class="form-check form-check-inline d-flex align-items-center">
                                              <label class="form-check-label flex-grow-1 text-start" for="newID2">هفته گذشته</label>
                                              <input class="form-check-input" type="checkbox" id="newID2">
                                            </div>
                                        </li>
                                        <li class="border-bottom">
                                          <div class="form-check form-check-inline d-flex align-items-center">
                                            <label class="form-check-label flex-grow-1 text-start" for="newID3">ماه گذشته</label>
                                            <input class="form-check-input" type="checkbox" id="newID3">
                                          </div>
                                      </li>
                                        </ul>
                                        </div>
                                        <div class="d-flex overflow-hidden border-top">
                                          <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                                          <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                                        </div>
                                      </form>
                                      </div>
                                      <div class="dropdown d-inline-block mt-1">
                                        <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                          ارسال
                                        </button>
                                        <form class="dropdown-menu p-0 rounded-0">
                                          <div class="content-filter">
                                          <ul class="list-unstyled pt-2">
                                            <li class="border-bottom">
                                              <div class="form-check form-check-inline form-switch d-flex align-items-center">
                                                <label class="form-check-label flex-grow-1 text-start" for="deliveryID1">ارسال شده توسط تن جامه</label>
                                                <input class="form-check-input" type="checkbox" role="switch" id="deliveryID1">
                                              </div>
                                              <h6 class="ms-5 font-x-s">موارد با گزینه های تحویل اضافی را مشاهده کنید.</h6>
                                          </li>
                                          <li class="border-bottom">
                                            <div class="form-check form-check-inline form-switch d-flex align-items-center">
                                              <label class="form-check-label flex-grow-1 text-start" for="deliveryID2">فروخته شده توسط تن جامه</label>
                                              <input class="form-check-input" type="checkbox" role="switch" id="deliveryID2">
                                            </div>
                                            <h6 class="ms-5 font-x-s">برای کوپن های محدود به مواردی که مستقیماً توسط تن جامه فروخته می شود</h6>
                                        </li>
                                          </ul>
                                          </div>
                                          <div class="d-flex overflow-hidden border-top">
                                            <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                                            <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                                          </div>
                                        </form>
                                        </div>
                                        <div class="dropdown d-inline-block mt-1">
                                          <button type="button" class="btn btn-outline-dark border-1 rounded-0 dropdown-toggle lh-lg" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                            کمپین ها
                                          </button>
                                          <form class="dropdown-menu p-0 rounded-0">
                                            <div class="content-filter">
                                            <ul class="list-unstyled pt-2">
                                              <li class="border-bottom">
                                                <div class="form-check form-check-inline d-flex align-items-center">
                                                  <label class="form-check-label flex-grow-1 text-start" for="campaignsID1">قطره داغ</label>
                                                  <input class="form-check-input" type="checkbox" id="campaignsID1">
                                                </div>
                                            </li>
                                              <li class="border-bottom">
                                                <div class="form-check form-check-inline d-flex align-items-center">
                                                  <label class="form-check-label flex-grow-1 text-start" for="campaignsID2">انتخاب دونده</label>
                                                  <input class="form-check-input" type="checkbox" id="campaignsID2">
                                                </div>
                                            </li>
                                            </ul>
                                            </div>
                                            <div class="d-flex overflow-hidden border-top">
                                              <button type="submit" class="btn btn-secondary p-3 rounded-0 flex-grow-1">اعمال</button>
                                              <button type="reset" class="btn btn-light p-3 rounded-0 flex-grow-1">پاک</button>
                                            </div>
                                          </form>
                                          </div>
                          </div>
     </div>
     <div class="hstack gap-2 text-muted my-3">
      <h6>۴،۹۱۲ محصول</h6>
      <a href="#" class="text-body-tertiary lh-sm fs-5" data-bs-toggle="modal" data-bs-target="#help_items"><i class="fa-regular fa-circle-question"></i></a>
      <div class="modal fade" id="help_items" tabindex="-1">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="fw-semibold">چرا ابتدا این موارد را می بینید؟</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-animate b-purple">
              <p>موتور جستجوی ما و نحوه رتبه بندی اقلام را کاوش کنید
              <a href="#" class="d-inline-block text-decoration-none text-mediumpurple">اطلاعات بیشتر</a>
            </p>
            </div>
          </div>
        </div>
      </div>
     </div>
<!-- products -->
<div class="row row-cols-2 row-cols-sm-3 g-3">
  <div class="col card rounded-0 border-0">
    <div class="position-relative d-inline-block product">
      <div class="position-absolute top-0 z-1 mt-2">
        <!-- add class like or dislike -->
        <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5" ><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
      </div>
     <a href="product-detail.html" class="text-decoration-none"> 
      <div class="card text-dark rounded-0 border-0 bg-transparent">
        <div class="position-relative placeholder-glow">
          <div class="product-img position-relative pt-144 bg-dark-subtle w-100 placeholder">
          <img class="card-img rounded-0 position-absolute top-0 lazy-image" data-src='media/product/product-a1.webp' onmouseover="this.src='media/product/product-a2.webp';" onmouseout="this.src='media/product/product-a1.webp';" alt="">
          </div>
          <div class="position-absolute bottom-0 end-0 hstack gap-1">
            <div class="text-bg-light p-1 mb-2"><small>جدید</small></div>
            <div class="text-bg-danger p-1 mb-2"><small>تا ۳۰٪ تخفیف</small></div>
          </div>
              <div class="wrapper position-absolute bottom-0 w-100 bg-body">
                <ul class="product-size d-flex scroll-y-nowrap list-unstyled gap-3 text-body mb-0 pt-1">
                  <li>s</li>
                  <li>m</li>
                  <li>l</li>
                  <li>xl</li>
                  <li>xxl</li>
                </ul>
                <div class="product-box d-flex placeholder-glow">
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a1.webp" data-size="s m l xl xxl" data-price="۳,۴۰۰,۰۰۰" data-detail="tshirt - سفید">
                    <img data-src='media/product/box-a1.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a2.webp" data-size="s m" data-price="۳,۴۰۰,۰۰۰" data-detail="tshirt - آبی">
                    <img data-src='media/product/box-a2.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a3.webp" data-size="همه سایز موجود هست" data-price="۳,۴۰۰,۰۰۰" data-detail="tshirt - طوسی">
                    <img data-src='media/product/box-a3.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a4.webp" data-size="xl xxl" data-price="۳,۱۰۰,۰۰۰" data-detail="tshirt - مشکی">
                    <img data-src='media/product/box-a4.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a5.webp" data-size="s m l xl xxl" data-price="۳,۱۵۰,۰۰۰" data-detail="tshirt - قرمز">
                    <img data-src='media/product/box-a5.webp' class="lazy-image w-100" alt="">
                  </a>
                </div>
              </div>
        </div>
        <div class="card-body p-0 py-2">
          <h6 class="m-0 text-truncate">تیشرت نایک</h6>
          <h6 class="m-0 text-truncate product-detail">tshirt - سفید</h6>
        </div>
        <section>
            <h6 class="fw-semibold text-danger"><span class="product-price">۳،۴۰۰،۰۰۰</span> تومان</h6><h6><del>۵،۴۰۰،۰۰۰ تومان</del></h6>
        </section>
      </div>
     </a>
    </div>
  </div>
  <div class="col card rounded-0 border-0">
    <div class="position-relative d-inline-block product">
      <div class="position-absolute top-0 z-1 mt-2">
        <!-- add class like or dislike -->
        <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5" ><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
      </div>
     <a href="product-detail.html" class="text-decoration-none"> 
      <div class="card text-dark rounded-0 border-0 bg-transparent">
        <div class="position-relative placeholder-glow">
          <div class="product-img position-relative pt-144 bg-dark-subtle w-100 placeholder">
          <img class="card-img rounded-0 position-absolute top-0 lazy-image" data-src='media/product/product-a1.webp' onmouseover="this.src='media/product/product-a2.webp';" onmouseout="this.src='media/product/product-a1.webp';" alt="">
          </div>
          <div class="position-absolute bottom-0 end-0 hstack gap-1">
            <div class="text-bg-light p-1 mb-2"><small>performance</small></div>
          </div>
              <div class="wrapper position-absolute bottom-0 w-100 bg-body">
                <ul class="product-size d-flex scroll-y-nowrap list-unstyled gap-3 text-body mb-0 pt-1">
                  <li>s</li>
                  <li>m</li>
                  <li>l</li>
                  <li>xl</li>
                  <li>xxl</li>
                </ul>
                <div class="product-box d-flex placeholder-glow">
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a1.webp" data-size="s m l xl xxl" data-price="۳,۴۰۰,۰۰۰" data-detail="tshirt - سفید">
                    <img data-src='media/product/box-a1.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a2.webp" data-size="s m" data-price="۳,۴۰۰,۰۰۰" data-detail="tshirt - آبی">
                    <img data-src='media/product/box-a2.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a3.webp" data-size="همه سایز موجود هست" data-price="۳,۴۰۰,۰۰۰" data-detail="tshirt - طوسی">
                    <img data-src='media/product/box-a3.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a4.webp" data-size="xl xxl" data-price="۳,۱۰۰,۰۰۰" data-detail="tshirt - مشکی">
                    <img data-src='media/product/box-a4.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1 d-inline-block placeholder" data-img="media/product/product-a5.webp" data-size="s m l xl xxl" data-price="۳,۱۵۰,۰۰۰" data-detail="tshirt - قرمز">
                    <img data-src='media/product/box-a5.webp' class="lazy-image w-100" alt="">
                  </a>
                  <a href="product-detail.html" class="text-decoration-none p-1" data-size="برای نمایش موارد بیشتر، کلیک کنید">
                    <span class="bg-body-secondary d-flex align-items-center p-2 text-body w-100 h-100">+2</span>
                  </a>
                </div>
              </div>
        </div>
        <div class="card-body p-0 py-2">
          <h6 class="m-0 text-truncate">تیشرت نایک</h6>
          <h6 class="m-0 text-truncate product-detail">tshirt - سفید</h6>
        </div>
        <section>
          <div class="hstack text-truncate gap-3"><h6 class="fw-semibold"><span class="product-price">۵،۳۵۰،۰۰۰</span> تومان</h6></div>
        </section>
      </div>
     </a>
    </div>
  </div>
  <div class="col card rounded-0 border-0">
    <div class="position-relative d-inline-block product">
      <div class="position-absolute top-0 z-1 mt-2">
        <!-- add class like or dislike -->
        <button type="button" class="btn btn-light rounded-0 btn-heart dislike lh-1 p-2 fs-5" ><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
      </div>
     <a href="outfits.html" class="text-decoration-none"> 
      <div class="card text-dark rounded-0 border-0 bg-transparent">
        <div class="position-relative placeholder-glow">
          <div class="product-img position-relative pt-144 bg-dark-subtle w-100 placeholder">
          <img class="card-img rounded-0 position-absolute top-0 lazy-image" data-src='media/product/product-b1.webp' alt="">
          </div>
          <div class="position-absolute bottom-0 end-0 hstack gap-1">
            <div class="text-bg-light p-1 mb-2"><small>طراح</small></div>
          </div>
        </div>
        <div class="card-body hstack gap-2 p-0 py-2 placeholder-glow">
          <a href="creator.html" class="width-42 position-relative placeholder">
            <img class="lazy-image rounded-0 w-100" data-src='media/product/box-b1.webp' alt="">
          </a>
          <div class="b-animate b-dark">
            <a href="creator.html" class="m-0 text-truncate text-decoration-none text-dark d-block">flix</a href="#">
          <h6 class="m-0 text-truncate">۴ محصول</h6>
          </div>
        </div>
      </div>
     </a>
    </div>
  </div>
</div> 
<!-- baner -->
<div class="row bg-gold text-dark mt-3 pt-0 pt-md-4 ps-4 ps-md-0 position-relative placeholder-glow">
  <div class="col-12 col-md-6 py-3">
                      <h3 class="fw-semibold">لباس خیابانی راحت</h3>
                      <h4 class="mb-4">مورد علاقه لباس های بیرونی زمستانی</h4>
          <a href="collections.html" class="text-decoration-none text-dark fw-semibold stretched-link">اکنون کشف کنید <i class="fa-solid fa-arrow-left"></i></a>
  </div>
  <div class="col-12 col-md-6 card p-0 rounded-0 border-0">
<div class="position-relative pt-48 bg-dark-subtle placeholder"> 
      <img class="lazy-image position-absolute top-0 w-100" data-src="media/product/product-baner1.webp" alt="">
      </div> 
  </div>
</div>
<!-- pagination -->
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center mt-5">
    <li class="page-item disabled">
      <a class="page-link border-0 bg-white text-body-tertiary"><i class="fa-solid fa-chevron-right"></i></a>
    </li>
    <li class="page-item d-flex align-items-center mx-4">صفحه ۱ از ۲۲</li>
    <li class="page-item">
      <a class="page-link border-0 text-reset" href="#"><i class="fa-solid fa-chevron-left"></i></a>
    </li>
  </ul>
</nav>
<!-- feedback -->
<div class="row bg-body-secondary p-2 feedback">
 <form id="feedback_form" role="form" method="post">
  <div id="feedback_one">
    <h6 class="fw-semibold">یک ثانیه صبر کنید.</h6>
 <h6>آیا این صفحه به شما در کشف ایده های مد امروز کمک می کند؟</h6>
 <input type="radio" class="btn-check" name="feedback" id="feedback1" autocomplete="off">
 <label class="btn fs-4" for="feedback1"><i class="fa-regular fa-face-smile-beam"></i></label>

 <input type="radio" class="btn-check" name="feedback" id="feedback2" autocomplete="off">
 <label class="btn fs-4" for="feedback2"><i class="fa-regular fa-face-smile"></i></label>

 <input type="radio" class="btn-check" name="feedback" id="feedback3" autocomplete="off">
 <label class="btn fs-4" for="feedback3"><i class="fa-regular fa-face-meh"></i></label>

 <input type="radio" class="btn-check" name="feedback" id="feedback4" autocomplete="off">
 <label class="btn fs-4" for="feedback4"><i class="fa-regular fa-face-frown-open"></i></label>

 <input type="radio" class="btn-check" name="feedback" id="feedback5" autocomplete="off">
 <label class="btn fs-4" for="feedback5"><i class="fa-regular fa-face-frown"></i></label>

 <p class="font-x-s b-animate b-purple">لطفاً برای اطلاعات بیشتر در مورد نحوه استفاده و پردازش داده های شما به <a href="#" class="text-decoration-none text-mediumpurple d-inline-block">خط مشی رازداری ما</a> مراجعه کنید.</p>
  </div>
  <div id="feedback_two">
    <h6 class="fw-semibold">عالیه!</h6>
 <h6>فکر کنید، به ما بگویید چه چیزی در این صفحه مفید بود؟</h6>
 <input id="feedback_comment" class="form-control border-dark rounded-0" type="text" aria-label="default input">
 <p class="font-x-s b-animate b-purple mt-4">برای ناشناس ماندن بازخورد خود، لطفاً نام یا اطلاعات تماس خود را در اینجا وارد نکنید. به پاسخ ما نیاز دارید؟ لطفاً از طریق صفحه <a href="#" class="text-decoration-none text-mediumpurple d-inline-block">راهنما و سؤالات متداول</a> با ما تماس بگیرید.</p>
 <button type="button" id="feedback_send" class="btn btn-dark px-2 btn-sm rounded-0 float-end">ارسال<i class="fa-solid fa-arrow-left-long ms-4"></i></button>  
</div>
<div id="feedback_three">
  <h6 class="fw-semibold">با تشکر، خوب است بدانید!</h6>
<h6>و در نهایت، چه چیزی شما را امروز به اینجا آورده است؟</h6>
<fieldset>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="feedbackOption" id="feedbackoption1">
    <label class="form-check-label " for="feedbackoption1">
      من به دنبال یک مورد خاص هستم
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="feedbackOption" id="feedbackoption2">
    <label class="form-check-label" for="feedbackoption2">
      من اینجا هستم تا به سایت نگاه کنم
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="feedbackOption" id="feedbackoption3">
    <label class="form-check-label" for="feedbackoption3">
      من تصور تقریبی از آنچه می خواهم دارم
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="feedbackOption" id="feedbackoption4">
    <label class="form-check-label" for="feedbackoption4">
      من می خواهم تصمیم بگیرم که امروز چه چیزی بخرم
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="feedbackOption" id="feedbackoption5">
    <label class="form-check-label" for="feedbackoption5">
      من نمی دانم
    </label>
  </div>
</fieldset>
<button type="submit" id="feedback_submit" class="btn btn-dark px-2 btn-sm rounded-0 float-end">ارسال<i class="fa-solid fa-arrow-left-long ms-4"></i></button>  
</div>
 </form>
 <div id="feedback_end">
  <h6 class="fw-semibold">هورا، متشکریم!</h6>
<h6>ما از این برای کمک به بهبود تجربه خرید شما استفاده خواهیم کرد.</h6>
 </div>
</div>
  </div>
</div>


<!-- end section -->


</div>
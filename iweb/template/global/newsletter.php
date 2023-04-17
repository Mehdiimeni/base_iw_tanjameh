<?php
///template/global/newsletter.php
?>
<div class="bg-body-secondary pt-3">
<div class="container-md">
  <div class="row">
  <div class="col-12 col-md-5">
<h5 class="fw-bold">اینباکس شما</h5>
<h5 class="mb-3">خالی از مد هست</h5>
<h6>برای دریافت آخرین استایل هایی که تن جامه میسازد، ایمیلتان را ثبت کنید</h6>
  </div>
  <div class="col-12 col-md-7">
    <div class="card px-md-5 py-md-2 rounded-0 border-0">
      <form class="form-validation card-body" role="form" data-toggle="validator" novalidate>
        <div class="col">
          <label for="validationEmail" class="form-label m-0 p-1 border border-bottom-0 border-dark">ایمیل شما:</label>
          <div class="input-group has-validation">
            <input type="email" class="form-control rounded-0 border-dark" placeholder="example@email.com" id="validationEmail" required>
            <div class="invalid-feedback">
              لطفا ایمیل خود را وارد نمایید
            </div>
          </div>
        </div>
        <fieldset class="row my-4">
          <legend class="col-form-label col-md-6 pt-0">
            <h6 class="fw-bold">ترجیحات خود را مدیریت کنید</h6>
            <h6>بیشتر به چه چیزی علاقه دارید؟</h6>
          </legend>
          <div class="col-md-6">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" required>
              <label class="form-check-label fs-5" for="gridRadios1">
                مد زنانه
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2" required>
              <label class="form-check-label fs-5" for="gridRadios2">
                مد مردانه
              </label>
              <div class="invalid-feedback">
                لطفا ترجیهات خود را انتخاب نمایید
              </div>
            </div>
          </div>
        </fieldset>
    <div class="accordion" id="accordionNewsletter">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            گزینه بیشتر
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionNewsletter">
          <div class="accordion-body">
            <div class="row row-cols-1 row-cols-md-2">
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                  <label class="form-check-label" for="flexCheckDefault">
                    هشدارهای مورد شما
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                  <label class="form-check-label" for="flexCheckChecked">
                    اصلاح مد شما
                  </label>
                </div>
              </div>
              <div class="col">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                  <label class="form-check-label" for="flexCheckDefault">
                    برندهایی که دنبال می کنید
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                  <label class="form-check-label" for="flexCheckChecked">
                    نظرسنجی ها
                  </label>
                </div>
              </div>
            </div>
            <a href="#" class="text-decoration-none font-x-s text-mediumpurple">مشاهده بیشتر (باید وارد سیستم شوید)</a>
          </div>
        </div>
      </div>
    </div>
          <button class="btn w-100 my-3 text-bg-dark rounded-0" type="submit" onclick="validateForm()">Submit form</button>
          <small class="text-muted">برای آشنایی با نحوه پردازش داده های شما، از اعلامیه <a href="#" class="text-dark text-decoration-none">حریم خصوصی</a> ما دیدن کنید. شما می توانید در هر زمان و بدون هزینه <a href="#" class="text-dark text-decoration-none">اشتراک</a> خود را لغو کنید.</small>
      </form>
    </div>
  </div>
</div>
</div>
</div>
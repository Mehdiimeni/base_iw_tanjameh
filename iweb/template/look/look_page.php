<?php
///template/look/look_page.php

if (isset($_POST['look_page'])) {
    $user_look_page_result = @user_look_page($_FILES,$_POST);
    if ($user_look_page_result->stat) {

        switch ($user_look_page_result->stat_detials) {
            case '20':
                JavaTools::JsAlertWithRefresh(_LANG['user_look_page_add'], 0, './?user=myaccount_look');
                break;    

        }

    } else {

        switch ($user_look_page_result->stat_detials) {
            case '12':
                echo "<script>alert('" . _LANG['user_look_form_null'] . "');</script>";
                break;
                
            case '13':
                echo "<script>alert('" . _LANG['user_look_error_exist'] . "');</script>";
                break;

            case '14':
                echo "<script>alert('" . _LANG['enter_format_file_error'] . "');</script>";
                break;

            case '15':
                echo "<script>alert('" . _LANG['enter_size_file_error'] . "');</script>";
                break;
        }

    }


}
?>

<div class="col-12 col-lg-9">
    <form class="needs-validation" method="post" action="" enctype="multipart/form-data" novalidate>
        <div class="my-5 col-12 col-sm-10 col-md-8 col-lg-6 m-auto">
        <?php if(!empty(user_look_page_info()->look_page_name)) { ?>
            <div class="mb-4 b-animate b-purple">
                
                <a href="./?look=<?php echo(user_look_page_info()->id); ?>&name=<?php  echo(user_look_page_info()->look_page_name); ?>" class="btn btn-dark w-100 rounded-0 py-2 fw-bold" ><h4 >مشاهده صفحه</h4></a>
            
            </div>
            <?php } ?>
            <?php if(!empty(is_look_reg_page()->admin_comment)){?>
            <div class="mb-4 w-100">
                <label for="personalNumber" class="form-label m-0 p-1 border border-bottom-0 border-dark">
                    <span>  توضیحات مدیر لطفا به موارد دقت کامل داشته باشید </span>
                </label>
                <div class="input-group position-relative">
                <textarea readonly  class="form-control" rows="3"><?php echo is_look_reg_page()->admin_comment; ?></textarea>
      
                    
                </div>
            </div>
            <?php } ?>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">نام صفحه  
                    </label>
                <div class="input-group">
                    <input type="text" name="look_page_name" value="<?php if(!empty(user_look_page_info()->look_page_name)) echo(user_look_page_info()->look_page_name); ?>"
                        class="form-control form-control-lg fs-6 rounded-0 border-dark" id="personalFamily" required>
                    <div class="invalid-feedback">
                           نام صفحه
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">متن صفحه  
                    </label>
                <div class="input-group">
                    <textarea type="text" name="look_page_description"
                        class="form-control form-control-lg fs-6 rounded-0 border-dark" id="personalFamily" required><?php if(!empty(user_look_page_info()->look_page_description)) echo(user_look_page_info()->look_page_description); ?></textarea>
                    <div class="invalid-feedback">
                           متن صفحه
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalFamily" class="form-label m-0 p-1 border border-bottom-0 border-dark">تصویر  پروفایل
                    </label>
                <div class="input-group">
                    <input type="file" name="look_page_profile"
                        class="form-control form-control-lg fs-6 rounded-0 border-dark" id="personalFamily" required>
                    <div class="invalid-feedback">
                        تصویر   پروفایل
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalEmail" 
                    class="form-label m-0 p-1 border border-bottom-0 border-dark"> تصویر بنر 
                    </label>
                <div class="input-group">
                    <input type="file" name="look_page_banner" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="personalEmail" required>
                    <div class="invalid-feedback">
                          تصویر بنر 
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalEmail" 
                    class="form-label m-0 p-1 border border-bottom-0 border-dark"> رنگ بنر 
                    </label>
                <div class="input-group">
                    <input type="color" value="<?php if(!empty(user_look_page_info()->look_page_color)) echo(user_look_page_info()->look_page_color); ?>" name="look_page_color" class="form-control form-control-lg fs-6 rounded-0 border-dark"
                        id="personalEmail" required>
                    <div class="invalid-feedback">
                          رنگ بنر 
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="personalEmail" 
                    class="form-label m-0 p-1 border border-bottom-0 border-dark">  کمد من 
                    </label>
                <div class="input-group">
                    <?php $checked = ''; if(!empty(user_look_page_info()->closet)) if(user_look_page_info()->closet == 1){ $checked = 'checked' ;} ?>
                <input class="form-check-input" name="closet" value="1"  <?php echo($checked); ?> required type="checkbox"
                                    id="reciveCheckbox">
                    <div class="invalid-feedback">
                         تمایل دارم کمد انتخابی من نمایش داده شود
                    </div>
                </div>
            </div>

            

            <button type="submit" name="look_page" value="1"
                class="btn btn-dark btn-lg fw-bold fs-6 py-3 rounded-0 d-flex align-items-center">
                <i class="fa-add fa-envelope me-2 fs-4"></i>
                <span>ثبت</span>
            </button>



        </div>
    </form>
</div>
</div>
</div>
<?php
///template/GlobalPage/MenuProfileQuickInfo.php
if(isset($stdProfile->Name)){
?>
<div class="profile clearfix">
    <div class="profile_pic">

        <?php echo $AdminProfileImage; ?>
    </div>
    <div class="profile_info">
        <span><?php echo $strAdminGroupName; ?></span>
        <h2><?php echo $stdProfile->Name; ?></h2>
    </div>
</div>
<?php } ?>
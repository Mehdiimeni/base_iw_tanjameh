<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IW Panel</title>

    <!-- Bootstrap -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css"
          rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/font-awesome/css/font-awesome.min.css"
          rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>build/css/custom.css" rel="stylesheet">
</head>

<body class="login">
<div id="particles-js">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>
    <a class="hiddenanchor" id="reset"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="post" action="">
                    <h1><?php echo FA_LC["user_panel"]; ?></h1>
                    <div>
                        <input name="UsernameL" id="username" type="text" class="form-control"
                               placeholder="<?php echo FA_LC["username"]; ?>" required
                               oninvalid="this.setCustomValidity('<?php echo FA_LC["required"] ?>')"
                               oninput="setCustomValidity('')"/>
                    </div>
                    <div>
                        <input name="PasswordL" id="password" type="password" class="form-control"
                               placeholder="<?php echo FA_LC["password"]; ?>" required
                               oninvalid="this.setCustomValidity('<?php echo FA_LC["required"] ?>')"
                               oninput="setCustomValidity('')"/>
                    </div>
                    <div>
                        <button class="btn btn-default submit" name="SubmitL"
                                type="submit" value="N"><?php echo FA_LC["enter"]; ?></button>
                        <a class="reset_pass" href="#reset"><?php echo FA_LC["forget_password_tip"]; ?></a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">
                            <a href="#signup" class="to_register"> <?php echo FA_LC["signup_tip"]; ?> </a>
                        </p>

                    </div>

                </form>
            </section>
        </div>
        <div id="register" class="animate form registration_form">
            <section class="login_content">
                <form method="post" action="">
                    <h1><?php echo FA_LC["signup"]; ?></h1>
                    <div>
                        <input name="Name" class="date-picker form-control col-md-7 col-xs-12"
                               required="required" type="text" placeholder="<?php echo FA_LC["full_name"]; ?>">
                    </div>
                    <div>
                        <input type="email" name="Email" class="form-control"
                               placeholder="<?php echo FA_LC["email"]; ?>" required="required"/>
                    </div>
                    <div>
                        <input name="CellNumber" class="date-picker form-control col-md-7 col-xs-12"
                               type="text" maxlength="15" placeholder="<?php echo FA_LC["mobile"]; ?>"
                               required="required">
                    </div>
                    <div>
                        <input name="Username" class="date-picker form-control col-md-7 col-xs-12"
                                type="text" placeholder="<?php echo FA_LC["username"]; ?> " required="
                               required" >
                    </div>
                    <div>
                        <input type="password" name="Password" class="form-control"
                               placeholder="<?php echo FA_LC["password"]; ?>" required="required"/>
                    </div>

                    <div>
                        <button class="btn btn-default submit" name="RegisterL"
                                type="submit" value="N"><?php echo FA_LC["send"]; ?></button>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link"><?php echo FA_LC["signup_tip"]; ?>
                            <a href="#signin" class="to_register"> <?php echo FA_LC["enter"]; ?> </a>
                        </p>


                    </div>
                </form>
            </section>
        </div>
        <div id="rest_pass" class="animate form rest_pass_form">
            <section class="login_content">
                <!-- /password recovery -->

                <form method="post" action="">
                    <h1><?php echo FA_LC["forget_password"]; ?></h1>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" required name="Email" placeholder="<?php echo FA_LC["email"]; ?>" />
                        <div class="form-control-feedback">
                            <i class="fa fa-envelope-o text-muted"></i>
                        </div>
                    </div>

                    <button type="submit" name="SubmitForget" value="F" class="btn btn-default btn-block"><?php echo FA_LC["send"]; ?></button>
                    <div class="clearfix"></div>
                    <br/>

                    <div>
                        <p><?php echo FA_LC["user_forget_tip"]; ?></p>
                    </div>

                </form>

                <!-- Password recovery -->
            </section>
        </div>
    </div>
</div>
</div>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>build/js/particle/particles.min.js"></script>
<script src="<?php echo(IW_PANEL_THEME_FROM_PANEL); ?>build/js/particle/app.js"></script>
</body>
</html>

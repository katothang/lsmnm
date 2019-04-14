<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex,nofollow" />
    <title>WordPress &rsaquo; Cài Đặt Tập Tin Cấu Hình</title>
    <link rel='stylesheet' id='buttons-css' href='http://localhost/mnm/wp-includes/css/buttons.min.css?ver=5.1.1'
        type='text/css' media='all' />
    <link rel='stylesheet' id='install-css' href='http://localhost/mnm/wp-admin/css/install.min.css?ver=5.1.1'
        type='text/css' media='all' />
</head>

<body class="wp-core-ui">
    <p id="logo"><a href="https://wordpress.org/">WordPress</a></p>
    <h1 class="screen-reader-text">Thiết lập kết trang web</h1>
    <form method="post" action="install-config.php?step=2">
        <p>Bạn cần nhập thông tin chi tiết để kết nối với cơ sở dữ liệu của bạn. Nếu bạn không biết, hãy liên hệ với nhà
            cung cấp dịch vụ máy chủ của bạn.</p>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="dbname">Tên website</label></th>
                <td><input name="dbname" id="dbname" type="text" size="25" value="zshop" autofocus /></td>
                <td>Tên cơ sở dữ liệu mà bạn muốn sử dụng với WordPress</td>
            </tr>
            <tr>
                <th scope="row"><label for="uname">Tên người dùng</label></th>
                <td><input name="uname" id="uname" type="text" size="25" value="admin" /></td>
                <td>Tài khoản Database</td>
            </tr>
            <tr>
                <th scope="row"><label for="pwd">Mật khẩu</label></th>
                <td><input name="pwd" id="pwd" type="text" size="25" value="*****" autocomplete="off" /></td>
                <td>Mật khẩu Database</td>
            </tr>
            <tr>
                <th scope="row"><label for="dbhost">Database Host</label></th>
                <td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
                <td>
                    Bạn sẽ có thể nhận được thông tin từ máy chủ web của bạn, nếu <code>localhost</code> không làm việc.
                </td>
            </tr>
        </table>
        <input type="hidden" name="language" value="vi" />
        <p class="step"><input name="submit" type="submit" value="Gửi" class="button button-large" /></p>
    </form>
    <script type='text/javascript' src='http://localhost/mnm/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>
    <script type='text/javascript' src='http://localhost/mnm/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'>
    </script>
    <script type='text/javascript' src='http://localhost/mnm/wp-admin/js/language-chooser.min.js?ver=5.1.1'></script>
</body>

</html>
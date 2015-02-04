<?php
if (!defined("ADMIN") && !defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<?php
$csdl = new mysqli('localhost', 'root', '','aptech');
$csdl->set_charset('utf8');
$csdl->query("SET time_zone = '+07:00'");
?>
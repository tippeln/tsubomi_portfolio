<?php

require_once "admin/util.inc.php";
session_start();

if (isset($_SESSION)) {
 $name = $_SESSION["name"];
 $kana = $_SESSION["kana"];
 $mail = $_SESSION["mail"];
 $tel  = $_SESSION["tel"];
 $msg  = $_SESSION["msg"];
}

if ($_POST[send] == "送信する"){

// Qdmailを使ったメール送信
require_once "libs/qd/qdsmtp.php";
require_once "libs/qd/qdmail.php";
// SMTPの設定
$param = array(
 "host" => "w1.sim.zdrv.com", //w1は数字の1
 "port" => 25,
 "from" => "zd3G15@sim.zdrv.com", //formではなくfrom
 "protocol" => "SMTP"
);
// メールの送信
$mail = new Qdmail();
$mail->errorDisplay(FALSE);
$mail->smtpObject()->error_display = FALSE;
$mail->from("zd3G15@sim.zdrv.com", "問い合わせフォーム");
$mail->to("zd3G15@sim.zdrv.com", "三角直美");
$mail->subject("問い合わせフォーム");
$mail->text();
$mail->smtp(TRUE);
$mail->smtpServer($param);
$flag = $mail->send();
if ($flag == TRUE) {
 echo "メールを送信しました。";
  header("Location: contact_done.php");
}
else {
 echo "メールの送信に失敗しました。";
 header("Location: contact_error.php");
}
} elseif ($_POST[back] == "修正する") {
    header("Location: contact.php");

}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="クレセントシューズは靴の素材と履き心地にこだわる方に満足をお届けする東京の靴屋です。後悔しない靴選びはぜひクレセントシューズにお任せください。">
  <meta name="keyword" content="Crescent,shoes,クレセントシューズ,東京,新宿区,メンズシューズ,レディースシューズ,キッズシューズ,ベビーシューズ">

  <title>Contact | Crescent Shoes</title>

  <link rel="shortcut icon" href="images/favicon.ico">
  <link rel="stylesheet" href="css/styles.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <!--[if lt IE 9]>
    <script src="http://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv-printshiv.min.js"></script>
    <script src="http://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!--[if lt IE 8]>
    <![endif]-->
  </head>
  <body class="pageTop" id="pageTop">
    <header class="navbar navbar-default navbar-fixed-top" role="banner">
      <div class="container">
        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <h1 class="navbar-header">
          <a href="index.html" class="navbar-brand"><img src="images/logo01.png" alt="LOGO"></a>
        </h1><!-- /.navbar-header -->
        <nav class="navbar-collapse collapse" id="navigation" role="navigation">
          <ul class="nav navbar-nav">
            <li><a href="index.html">ホーム<span>HOME</span></a></li>
            <li><a href="about.html">会社概要<span>ABOUT</span></a></li>
            <li><a href="news.php">ニュース<span>NEWS</span></a></li>
            <li><a href="shop.html">ショップ<span>ONLINE SHOP</span></a></li>
            <li><a href="contact.php">お問い合わせ<span>CONTACT</span></a></li>
          </ul>
          <form class="navbar-form" role="search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="keyword">
              <span class="input-group-btn"><button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button></span>
            </div><!-- /.input-group -->
          </form>
        </nav>
      </div>
    </header>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <nav>
            <h1 class="page-header">Contact</h1>
            <ol class="breadcrumb">
              <li><a href="index.html">Home</a></li>
              <li><a href="contact.php">Contact</a></li>
              <li class="active">送信内容確認</li>
            </ol>
          </nav>
        </div>
      </div>
        <div class="row">
          <div class="col-md-4 hidden-sm hidden-xs">
            <div class="contact-img">
            <img src="images/contact.jpg">
            </div>
          </div>
          <div class="col-md-8">
            <h3 class="page-header">Message Confirmation</h3>
            <p>内容を修正される場合は「修正する」ボタンを、送信される場合は「送信する」ボタンを押してください。</p>
            <table class="table table-hover table-bordered">
              <tr>
                <th>お名前</th>
                <td><?php echo h($name); ?></td>
              </tr>
              <tr>
                <th>フリガナ</th>
                <td><?php echo h($kana); ?></td>
              </tr>
              <tr>
                <th>メールアドレス</th>
                <td><?php echo h($mail); ?>.com</td>
              </tr>
              <tr>
                <th>電話番号</th>
                <td><?php echo h($tel); ?></td>
              </tr>
              <tr>
                <th>お問い合わせ内容</th>
                <td><?php echo h($msg); ?></td>
              </tr>
            </table>
            <form class="form-horizontal">
                <div class="form-group">
                <div class="col-sm-10">
                  <button type="submit" name="send" class="btn btn-success btn-lg">送信する</button>
                  <button type="submit" name="back" class="btn btn-success btn-lg">修正する</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="pagetop margin-top-md">
        <a href="#pageTop" class="center-block text-center" onclick="$('html,body').animate({scrollTop: 0}); return false;"><i class="fa fa-chevron-up center-block "></i>Page Top</a>
      </div>
      <footer class="margin-top-md" role="contentinfo">
        <div class="container">
          <div class="row">
            <div class="text-center">
              <ul class="list-inline">
                <li><a href="index.html">HOME</a></li>
                <li><a href="about.html">ABOUT</a></li>
                <li><a href="news.php">NEWS</a></li>
                <li><a href="shop.html">ONLINE SHOP</a></li>
                <li><a href="contact.php">CONTACT</a></li>
              </ul>
              <small>&copy; Crescent Shoes.All Rights Reserved.</small>
            </div><!-- /.text-center -->
          </div><!-- /.row -->
        </div><!-- /.container -->
      </footer>
      <script src="js/jquery-2.1.4.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/main.js"></script>
      <script>
      $(document).ready(function(){
        $('th').css({
            width: '20%',
            minWidth: '80px'
        });
        $('.contact-img').css({
            marginTop:'40px',
            overflow: 'hidden',
            height: $('.col-md-8').height() - 55
        });
      });
      </script>
    </body>
</html>
<?php
require_once "util.inc.php";
require_once "libs/qd/qdsmtp.php";
require_once "libs/qd/qdmail.php";
session_start();

if (isset($_SESSION["contact"])) {
 $contact = $_SESSION["contact"];
 $name    = $contact["name"];
 $kana    = $contact["kana"];
 $mail    = $contact["mail"];
 $tel     = $contact["tel"];
 $inquiry = $contact["inquiry"];
 $token   = $contact["token"];
}
if ($_POST[send] == "send") {
if($token !== getToken()) {
exit('処理を正常に完了できませんでした');
header("Location:contact.php");
}

$body = <<<EOT
■お名前
{$name}

■フリガナ
{$kana}

■メールアドレス
{$mail}

■電話番号
{$tel}

■問い合わせ内容
{$inquiry}
EOT;
// var_dump($body);

// SMTPの設定
$param = array(
 "host" => "ssl://smtp.gmail.com", //w1は数字の1
 "port" => 465,
 "from" => "tippeln@gmail.com", //formではなくfrom
 "protocol" => "SMTP_AUTH",
 "user" => "tippeln@gmail.com", // Gmailアカウントのユーザ名
 "pass" => "pwmoigxigrkgjgyj", // Gmailアカウントのパスワード
);
// メールの送信
$mail = new Qdmail();
$mail->errorDisplay(FALSE);
$mail->smtpObject()->error_display = FALSE;
$mail->from("tippeln@gmail.com", "Crescent Shoes Web");
$mail->to("tippeln@gmail.com","Crescent Shoes 管理者（受信者名）");
$mail->subject("Crescent Shoes 問い合わせ（タイトル）");
$mail->text($body);
$mail->smtp(TRUE);
$mail->smtpServer($param);
$flag = $mail->send();
// var_dump($mail);
// var_dump($flag);
// exit;

if($flag == TRUE){//もし送信に成功したならば
    unset($_SESSION["contact"]);//セッション変数を破棄
    header("Location: contact_done.php");
}
else{//送信失敗した場合は、セッション変数はそのままで
   header("Location: contact_error.php");
}

} elseif ($_POST[back] == "back") {
   header("Location: contact.php");
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Petal* | tippeln's Portfolio</title>
        <meta name="keywords" content="Portfolio">
        <meta name="description" content="Portfolio">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:title" content="" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="/" />
        <meta property="og:site_name" content="" />
        <meta property="og:description" content="。" />
        <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap_min.css">
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/common.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body class="delayed-image">
    <div class="warpper">
        <header>
            <section id="g-nav" class="section">
                <nav>
                    <div class="g-nav pc-mode">
                        <div>

                        </div>
                        <div class="menu"><a href="index.html" alt="">Home</a></div>
                        <div class="menu"><a href="about.html" alt="">About</a></div>
                        <div class="menu"><a href="portfolio.html" alt="">Portfolio</a></div>
                        <!-- <div class="menu"><a href="Blog" alt="">Blog</a></div> -->
                        <div class="menu"><a href="contact.php" alt="">Contact</a></div>
                    </div>
                    <div class="g-nav-m m-mode">
                        <div class="cp_offcm01">
                            <input type="checkbox" id="cp_toggle01">
                            <label for="cp_toggle01"><span></span></label>
                            <div class="cp_menu">
                                <ul>
                                    <li class="menu-m"><a href="index.html" alt="">Home</a></li>
                                    <li class="menu-m"><a href="about.html" alt="">About</a></li>
                                    <li class="menu-m"><a href="portfolio.html" alt="">Portfolio</a></li>
                                    <!-- <li class="menu-m"><a href="blog" alt="">Blog</a></li> -->
                                    <li class="menu-m"><a href="contact" alt="">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-contents">
                            <h1></h1>
                        </div>
                    </div>
                </nav>
            </section>
        </header>
        <main>
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
                <td><?php echo h($inquiry); ?></td>
              </tr>              <tr>

            </table>
            <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                <div class="col-sm-10">
                  <button type="submit" name="send" class="btn btn-success btn-lg" value="send">送信する</button>
                  <button type="submit" name="back" class="btn btn-success btn-lg" value="back">修正する</button>
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
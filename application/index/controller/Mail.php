<?php
namespace app\index\controller;
use  think\Controller;
use  PHPMailer\PHPMailer;
class Mail extends Controller
{
    function __construct(){
        parent::__construct();
    }

    public function index(){
        $sendmail = 'tonyyam@yeah.net'; //发件人邮箱
        $sendmailpswd = "Applemima1"; //客户端授权密码,而不是邮箱的登录密码！
        $send_name = 'tonyyam';// 设置发件人信息，如邮件格式说明中的发件人，
        $toemail = input('email');//定义收件人的邮箱
        $to_name = input('email');//设置收件人信息，如邮件格式说明中的收件人
        $mail = new PHPMailer();
        $mail->isSMTP();// 使用SMTP服务
        $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = "smtp.yeah.net";// 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;// 是否使用身份验证
        $mail->Username = $sendmail;//// 发送方的
        $mail->Password = $sendmailpswd;//客户端授权密码,而不是邮箱的登录密码！
        $mail->SMTPSecure = "tls";// 使用ssl协议方式
        $mail->Port = 25;//  qq端口465或587）
        $mail->setFrom($sendmail,$send_name);// 设置发件人信息，如邮件格式说明中的发件人，
        $mail->addAddress($toemail,$to_name);// 设置收件人信息，如邮件格式说明中的收件人，
        $mail->addReplyTo($sendmail,$send_name);// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
        //$mail->addCC("xxx@qq.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址(这个人也能收到邮件)
        //$mail->addBCC("xxx@qq.com");// 设置秘密抄送人(这个人也能收到邮件)
        //$mail->addAttachment("bug0.jpg");// 添加附件
        $mail->Subject = "Yammy激活链接";// 邮件标题
        $mail->Body = "请点击以下的链接激活账号：http://www.tonyyam.cn/index/index/emailvali?username=".input('username');// 邮件正文
        //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用
        if(!$mail->send()){// 发送邮件
            echo "Message could not be sent.";
            echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
        }else{
            if(session('username') == null) {
                session('username',input('username'));
                return $this->success('注册成功！验证邮件已发往您的邮箱中！', 'Index/index');
            }else{
                return $this->success('发送成功！验证邮件已发往您的邮箱中！', 'Index/index');
            }
        }
    }
}
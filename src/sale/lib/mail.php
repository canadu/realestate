<?php
class Mail
{
    // public string $to = '';
    // public string $subject = '';
    // public string $boyd = '';
    // public string $from = '';
    // public string $fromName = '';

    // function __construct($to, $subject, $body, $from, $fromName)
    // {
    //     $this->to = $to;
    //     $this->subject = $subject;
    //     $this->body = $body;
    //     $this->from = $from;
    //     $this->fromName = $fromName;
    // }

    function send_mail($to, $subject, $message, $headers = '', $language = 'Japanese', $encoding = 'UTF-8') {
        
        //toの読み込み
        if (!is_array($to)) {
            //カンマ区切りで分割する
            $to = explode(',', $to);
        }

        //文字の変換あるいは部分文字列の置換を行う
        $message = strtr($message, ["\r\n" => "\n", "\r" => "\n"]);// to all LF

        $add_params = '';
        
        if (empty($headers)) {
            $header_str = '';
        } else
        if (!is_array($headers)) {
            $header_str = $headers;
        } else {
            array_walk($headers, function($_val, $_key) use (&$header_str) {
                //フォーマットされた文字列を返す  $key：$val + CRLF
                $header_str .= sprintf("%s: %s \r\n", $_key, $_val);
                if ('Return-Path' === $_key) {
                    $return_path = trim($_val);
                }
            } );
        }
        
        if (isset($return_path) && ! empty($return_path)) {
            $add_params = "-f" . $return_path;
        }

        mb_language($language);
        mb_internal_encoding($encoding);
        $failure_sent = 0;

        //toの件数分処理を繰り返す
        foreach ($to as $send_to) {
            $send_to = trim($send_to);
            if (mb_send_mail($send_to, $subject, $message, $header_str, $add_params)) {
                //成功
                //$result = sprintf('[%s] An email has been sent to "%s".' . "\n", date( 'c' ), $send_to);
            } else {
                //失敗
                //$result = sprintf('[%s] Failed to send email to "%s".' . "\n", date( 'c' ), $send_to);
                $failure_sent++;
            }
            //error_log($result, 3, MAIL_LOG_PATH);
        }
        if ($failure_sent > 0 && $failure_sent == count($to)) {
            return false;
        } else {
            return true;
        }
    }
}

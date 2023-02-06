<?php
/**
 * @author FoskyM <i@mouse123.cn>
 * @time <2022-12-21 10:43>
 */

 #参考 https://zhuanlan.zhihu.com/p/561592982

$song_mid_list = [
    '003vEiDN3Pxu7W'
];

$data = '{"comm":{"cv":4747474,"ct":24,"format":"json","inCharset":"utf-8","outCharset":"utf-8","notice":0,"platform":"yqq.json","needNewCode":1,"uin":0,"g_tk_new_20200303":1736041243,"g_tk":1736041243},"req_1":{"module":"vkey.GetVkeyServer","method":"CgiGetVkey","param":{"guid":"3976520259","songmid":' . json_encode($song_mid_list) . ',"songtype":[0],"uin":"0","loginflag":1,"platform":"20"}}}';

print(qq_music_sign($data) . PHP_EOL);

# 请求 URL: https://u.y.qq.com/cgi-bin/musics.fcg?_=1671587493842&sign=zzb83fca38bgx9lcyxwfas4nmbazyftuqe5237d41
# 请求方法: POST
# 表单数据 {"comm":{"cv":4747474,"ct":24,"format":"json","inCharset":"utf-8","outCharset":"utf-8","notice":0,"platform":"yqq.json","needNewCode":1,"uin":0,"g_tk_new_20200303":1736041243,"g_tk":1736041243},"req_1":{"module":"vkey.GetVkeyServer","method":"CgiGetVkey","param":{"guid":"3976520259","songmid":["003vEiDN3Pxu7W"],"songtype":[0],"uin":"0","loginflag":1,"platform":"20"}}}

$data = '{"comm":{"cv":4747474,"ct":24,"format":"json","inCharset":"utf-8","outCharset":"utf-8","notice":0,"platform":"yqq.json","needNewCode":1,"uin":0,"g_tk_new_20200303":5381,"g_tk":5381},"req_1":{"method":"GetCommentCount","module":"music.globalComment.GlobalCommentRead","param":{"request_list":[{"biz_type":1,"biz_id":"102631743","biz_sub_type":0}]}},"req_2":{"module":"music.globalComment.CommentRead","method":"GetNewCommentList","param":{"BizType":1,"BizId":"102631743","LastCommentSeqNo":"","PageSize":25,"PageNum":0,"FromCommentId":"","WithHot":1,"PicEnable":1,"LastTotal":0,"LastTotalVer":"0"}},"req_3":{"module":"music.globalComment.CommentRead","method":"GetHotCommentList","param":{"BizType":1,"BizId":"102631743","LastCommentSeqNo":"","PageSize":15,"PageNum":0,"HotType":2,"WithAirborne":1,"PicEnable":1}},"req_4":{"module":"music.globalComment.CommentAsset","method":"GetCmBgCard","param":{}}}';
print(qq_music_sign($data) . PHP_EOL);

# 请求 URL: https://u.y.qq.com/cgi-bin/musics.fcg?_=1671587493842&sign=zzba13f8dbfzhph8pdimvsrhiqh1ltf8g517584b8
# 请求方法: POST
# 表单数据 {"comm":{"cv":4747474,"ct":24,"format":"json","inCharset":"utf-8","outCharset":"utf-8","notice":0,"platform":"yqq.json","needNewCode":1,"uin":0,"g_tk_new_20200303":5381,"g_tk":5381},"req_1":{"method":"GetCommentCount","module":"music.globalComment.GlobalCommentRead","param":{"request_list":[{"biz_type":1,"biz_id":"102631743","biz_sub_type":0}]}},"req_2":{"module":"music.globalComment.CommentRead","method":"GetNewCommentList","param":{"BizType":1,"BizId":"102631743","LastCommentSeqNo":"","PageSize":25,"PageNum":0,"FromCommentId":"","WithHot":1,"PicEnable":1,"LastTotal":0,"LastTotalVer":"0"}},"req_3":{"module":"music.globalComment.CommentRead","method":"GetHotCommentList","param":{"BizType":1,"BizId":"102631743","LastCommentSeqNo":"","PageSize":15,"PageNum":0,"HotType":2,"WithAirborne":1,"PicEnable":1}},"req_4":{"module":"music.globalComment.CommentAsset","method":"GetCmBgCard","param":{}}}

/**
 * Summary of qq_music_sign
 * @param string $data
 * @return string sign
 */
function qq_music_sign($data = '') {
    $k1 = ['0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, 'A' => 10, 'B' => 11, 'C' => 12,
    'D' => 13, 'E' => 14, 'F' => 15];
    $l1 = [212, 45, 80, 68, 195, 163, 163, 203, 157, 220, 254, 91, 204, 79, 104, 6];
    $t = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

    $md5 = strtoupper(md5($data));

    $t1 = $md5[21] . $md5[4] . $md5[9] . $md5[26] . $md5[16] . $md5[20] . $md5[27] . $md5[30];
    $t3 = $md5[18] . $md5[11] . $md5[3] . $md5[2] . $md5[1] . $md5[7] . $md5[6] . $md5[25];

    $ls2 = [];

    for ($i=0; $i < 16; $i++) { 
        $x1 = $k1[$md5[$i * 2]];
        $x2 = $k1[$md5[$i * 2 + 1]];
        $x3 = (($x1 * 16) ^ $x2) ^ $l1[$i];
        $ls2[] = $x3;
    }

    $ls3 = [];
    for ($i=0; $i < 6; $i++) { 
        if ($i == 5) {
            $ls3[] = $t[end($ls2) >> 2];
            $ls3[] = $t[(end($ls2) & 3) << 4];
        } else {
            $x4 = $ls2[$i * 3] >> 2;
            $x5 = ($ls2[$i * 3 + 1] >> 4) ^ (($ls2[$i * 3] & 3) << 4);
            $x6 = ($ls2[$i * 3 + 2] >> 6) ^ (($ls2[$i * 3 + 1] & 15) << 2);
            $x7 = 63 & $ls2[$i * 3 + 2];
            array_push($ls3, $t[$x4], $t[$x5], $t[$x6], $t[$x7]);
        }
    }
    $t2 = preg_replace('/[\\/+]/', '', implode($ls3));
    $sign = 'zzb' . strtolower($t1 . $t2 . $t3);

    return $sign;
}

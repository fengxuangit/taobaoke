<?php
class EncodeUtils {

    
    /*
     * URL��ȫ��Base64������������URL��ʽ����Base64�������ĳ�����
     * �ñ��뷽ʽ�Ļ����������Ƚ�������Base64��ʽ����Ϊ�ַ�����
     * Ȼ����ý���ַ��������ַ����еļӺ�+�����л���-�����ҽ�б��/�����»���_��ͬʱβ��ȥ���Ⱥ�padding��
    */
    public static function encodeWithURLSafeBase64($arg)
    {
        if ($arg === null || empty($arg)) {
            return null;
        }
        $result = preg_replace(array("/\r/", "/\n/"), "", rtrim(base64_encode($arg), '=' )); 
        return $result;
    }  

}

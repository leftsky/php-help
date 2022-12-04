<?php

const ERR_SUCCESS = 0xFFFF0000;
// 普通失败
const ERR_FAILED = 0xFFFF1000;
// 请先登录
const ERR_NOT_LOGIN = 0xFFFF1001;
// 非所有者
const ERR_NOT_OWNER = 0xFFFF1002;
// 权限不匹配
const ERR_COMPETENCE = 0xFFFF1003;
// 参数错误
const ERR_ARGV = 0xFFFF1100;
// 参数不足
const ERR_ARGV_NO_ENOUGH = 0xFFFF1101;
// 请刷新
const ERR_NEED_FLUSH = 0xFFFF1102;

/**
 * 权限认证 ERR
 */
// API TOKEN 认证失败
const ERR_API_TOKEN = 0xFFFE0000;
// API 权限 认证失败
const ERR_API_AUTH = 0xFFFE0001;

if (!function_exists('define_to_message')) {
    function define_to_message(int $code): string
    {
        switch ($code) {
            case  ERR_SUCCESS:
                return '操作成功';
            case   ERR_FAILED :
                return '失败';
            case   ERR_NOT_LOGIN :
                return '请先登录';
            case  ERR_NOT_OWNER :
                return '非所有者';
            case  ERR_COMPETENCE :
                return '权限不匹配';
            case ERR_ARGV :
                return '参数错误';
            case ERR_ARGV_NO_ENOUGH :
                return '参数不足';
            case  ERR_API_TOKEN :
                return 'API TOKEN 认证失败';
            case ERR_API_AUTH :
                return 'API 权限 认证失败';
            case ERR_NEED_FLUSH :
                return '请刷新后重试';
            default :
                return '未知';
        }
    }
}

if (!function_exists('define_to_status_code')) {
    function define_to_status_code(int $code): int
    {
        switch ($code) {
            case ERR_NOT_LOGIN:
            case ERR_API_TOKEN:
            case ERR_API_AUTH:
                return 401;
            default:
                return 200;
        }
    }
}

if (!function_exists('is_json')) {
    /**
     * 判断是否是json
     * @param $string
     * @return bool
     */
    function is_json($string): bool
    {
        // 如果不是 String 类型就返回 false
        if (!is_string($string)) return false;
        try {
            json_decode($string);
        } catch (\Exception $e) {
            return false;
        }
        if ($string == "null") return false;
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

if (!function_exists('explode_or_empty')) {
    /**
     * 判断是否是字符串并且切割
     * @param string $string
     * @return array
     */
    function explode_or_empty(string $string): array
    {
        if (!$string || !is_string($string) || strlen($string) <= 0) return [];
        return explode(",", $string);
    }
}

if (!function_exists("get_xingzuo")) {
    function get_xingzuo(int $month, int $day): string
    {
        $xingzuo = '';
        // 检查参数有效性
        if ($month < 1 || $month > 12 || $day < 1 || $day > 31) {
            return $xingzuo;
        }
        if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
            $xingzuo = "水瓶";
        } else if (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) {
            $xingzuo = "双鱼";
        } else if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) {
            $xingzuo = "白羊";
        } else if (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
            $xingzuo = "金牛";
        } else if (($month == 5 && $day >= 21) || ($month == 6 && $day <= 21)) {
            $xingzuo = "双子";
        } else if (($month == 6 && $day >= 22) || ($month == 7 && $day <= 22)) {
            $xingzuo = "巨蟹";
        } else if (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
            $xingzuo = "狮子";
        } else if (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
            $xingzuo = "处女";
        } else if (($month == 9 && $day >= 23) || ($month == 10 && $day <= 23)) {
            $xingzuo = "天秤";
        } else if (($month == 10 && $day >= 24) || ($month == 11 && $day <= 22)) {
            $xingzuo = "天蝎";
        } else if (($month == 11 && $day >= 23) || ($month == 12 && $day <= 21)) {
            $xingzuo = "射手";
        } else if (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) {
            $xingzuo = "摩羯";
        }
        return $xingzuo;
    }
}

if (!function_exists("decode_shuxiang")) {
    function decode_shuxiang(int $year): string
    {
        $array = ['猴', '鸡', '狗', '猪', '鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊'];
        foreach ($array as $key => $value)
            if (intval(ceil($year % 12)) === $key) return $value;
        return "未知";
    }
}

if (!function_exists("get_chinese_zodiac_year")) {

    /**
     * 根据年份获取生肖年
     *
     * @param int $year 正数公元元年之后，负数公元前，0非法。
     * @return string|null 正确返回生肖，错误返回 null
     */
    function get_chinese_zodiac_year(int $year): ?string
    {
        if ($year === 0) return null;
        $array = ['猴', '鸡', '狗', '猪', '鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊'];
        $point = $year > 0 ? $year % 12 : ($year + 1) % 12;
        $point = $point >= 0 ? $point : $point + 12;
        return $array[$point];
    }
}

if (!function_exists("check_extensions")) {
    /**
     * 校验是否加载了扩展，全部加载则返回true；未加载直接返回未加载的扩展
     * @param array $extensions
     * @return string|bool
     */
    function check_extensions(array $extensions)
    {
        foreach ($extensions as $extension) {
            if (!extension_loaded($extension)) {
                return $extension;
            }
        }
        return true;
    }
}


if (!function_exists('random_code')) {
    /**
     * 随机指定长度的字符串
     * @param int $len
     * @param bool $hasNumber
     * @param bool $hasUpCase
     * @return string
     */
    function random_code(int $len = 10, bool $hasNumber = false, bool $hasUpCase = false): string
    {
        $arr = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q",
            "r", "s", "t", "u", "v", "w", "x", "y", "z"];
        if ($hasUpCase)
            $arr = array_merge($arr, ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L",
                "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
            ]);
        if ($hasNumber)
            $arr = array_merge($arr, ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]);
        $str = "";
        while (strlen($str) < $len) $str .= $arr[rand(0, sizeof($arr) - 1)];
        return $str;
    }
}

if (!function_exists("decode_citycode")) {
    /**
     * 解析城市代码
     * @param string $code
     * @return string
     */
    function decode_citycode(string $code): string
    {
        $arr = json_decode(file_get_contents(__DIR__ . "/jsons/cityCode.json"), true);
        $cities = $arr["cities"] ?? [];
        return $cities[$code] ?? "未知";
    }
}

if (!function_exists('camelize')) {
    /**
     * 蛇形转驼峰
     */
    function camelize(string $uncamelized_words): string
    {
        $uncamelized_words = str_replace('_', " ", strtolower($uncamelized_words));
        return str_replace(" ", "", ucwords($uncamelized_words));
    }
}

if (!function_exists('camelize_small')) {
    /**
     * 蛇形转小驼峰
     */
    function camelize_small(string $uncamelized_words): string
    {
        $separator = "_";
        $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
    }
}

if (!function_exists('uncamelize')) {
    /**
     * 驼峰命名转蛇形命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     */
    function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}

if (!function_exists("cover_up_string")) {
    /**
     * 用覆盖符覆盖字符串的一部分
     * @param string $string 字符串
     * @param int $start 开始
     * @param int $len 长度
     * @param string $separator 覆盖符，默认是*
     * @return string
     */
    function cover_up_string(string $string, int $start, int $len, string $separator = "*"): string
    {
        if (strlen($string) < $start + $len)
            $len = strlen($string) - $start;
        $str = substr($string, 0, $start);
        $i = 0;
        while ($i++ < $len) {
            $str .= $separator;
        }
        $str .= substr($string, $start + $len);
        return $str;
    }
}

if (!function_exists("has_chinese_words")) {
    /**
     * 判断字符串中是否存在中文字符
     * @param string $str
     * @return bool
     */
    function has_chinese_words(string $str): bool
    {
        return preg_replace("/[^\x{4E00}-\x{9FFF}]+/u",
                '', $str) != "";
    }
}


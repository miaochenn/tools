<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportWord {
    
    public static $excelFile = '/Users/zhangyan/Desktop/words.xlsx';
    public static $exportFile = '/Users/zhangyan/Desktop/words_csv.txt';
    
    public function __construct()
    {
        
        $inputExcelConfig = [
            [
               "欺负",
               "欺骗"
           ],
           [
               "先知主宰",
               "暗影主宰"
           ],
           [
               "花背心",
               "花棉袄"
           ],
           [
               "复工",
               "复学"
           ],
           [
               "厦门",
               "海南"
           ],
           [
               "肥皂泡",
               "肥皂水"
           ],
           [
               "短寸发",
               "短碎发"
           ],
           [
               "水杯",
               "水壶"
           ],
           [
               "手套",
               "套袖"
           ],
           [
               "纸抽",
               "卷纸"
           ],
           [
               "苹果",
               "华为"
           ],
           [
               "苹果",
               "鸭梨"
           ],
           [
               "苹果",
               "小米"
           ],
           [
               "小米",
               "大米"
           ],
           [
               "小米",
               "华为"
           ],
           [
               "小米",
               "联想"
           ],
           [
               "oppo",
               "vivo"
           ],
           [
               "华为",
               "荣耀"
           ],
           [
               "奔驰",
               "宝马"
           ],
           [
               "奥迪",
               "宝马"
           ],
           [
               "奥迪",
               "奔驰"
           ],
           [
               "宝马",
               "宾利"
           ],
           [
               "玛莎拉蒂",
               "兰博基尼"
           ],
           [
               "法拉利",
               "迈巴赫"
           ],
           [
               "劳斯莱斯",
               "玛莎拉蒂"
           ],
           [
               "劳斯莱斯",
               "兰博基尼"
           ],
           [
               "爱玛",
               "雅迪"
           ],
           [
               "马斯克",
               "乔布斯"
           ],
           [
               "张杰谢娜",
               "海涛吴昕"
           ],
           [
               "潘婷",
               "飘柔"
           ],
           [
               "沙宣",
               "清扬"
           ],
           [
               "百雀羚",
               "郁美净"
           ],
           [
               "海飞丝",
               "夏士莲"
           ],
           [
               "中华牙膏",
               "黑妹牙膏"
           ],
           [
               "云南白药",
               "冷酸灵"
           ],
           [
               "冰美式",
               "冰拿铁"
           ],
           [
               "蜂蜜柚子",
               "蜂蜜雪梨"
           ],
           [
               "香蕉牛奶",
               "草莓牛奶"
           ],
           [
               "健力宝",
               "加多宝"
           ],
           [
               "得意忘形",
               "喜出望外"
           ],
           [
               "火冒三丈",
               "怒发冲冠"
           ],
           [
               "痛哭流涕",
               "悲痛欲绝"
           ],
           [
               "热泪盈眶",
               "泪如雨下"
           ],
           [
               "白素贞",
               "聂小倩"
           ],
           [
               "香港",
               "台湾"
           ],
           [
               "甄嬛传",
               "红楼梦"
           ],
           [
               "大白兔",
               "金丝猴"
           ],
           [
               "筷子",
               "牙签"
           ],
           [
               "肉夹馍",
               "汉堡包"
           ],
           [
               "滑冰",
               "滑雪"
           ],
           [
               "吹牛",
               "撒谎"
           ],
           [
               "黑豆",
               "红豆"
           ],
           [
               "绿豆",
               "黄豆"
           ],
           [
               "缝衣针",
               "绣花针"
           ],
           [
               "剪刀",
               "剪钳"
           ],
           [
               "白菜",
               "青菜"
           ],
           [
               "莴笋",
               "竹笋"
           ],
           [
               "奶昔",
               "奶茶"
           ],
           [
               "烤鸭",
               "烧鹅"
           ],
           [
               "涮羊肉",
               "打边炉"
           ],
           [
               "红薯",
               "土豆"
           ],
           [
               "篮球",
               "排球"
           ],
           [
               "李白",
               "杜甫"
           ],
           [
               "绿豆糕",
               "豌豆黄"
           ],
           [
               "炸酱面",
               "打卤面"
           ],
           [
               "柠檬",
               "芒果"
           ],
           [
               "方便面",
               "干脆面"
           ],
           [
               "诸葛亮",
               "司马懿"
           ],
           [
               "煲仔饭",
               "手抓饭"
           ],
           [
               "黄光",
               "丝瓜"
           ],
           [
               "草莓",
               "杨梅"
           ],
           [
               "高压锅",
               "电饭锅"
           ],
           [
               "面粉",
               "淀粉"
           ],
           [
               "胡椒",
               "花椒"
           ],
           [
               "秋裤",
               "毛裤"
           ],
           [
               "鼻毛",
               "腋毛"
           ],
           [
               "万圣节",
               "圣诞节"
           ],
           [
               "春节",
               "元旦"
           ],
           [
               "肯德基",
               "德克士"
           ],
           [
               "必胜客",
               "汉堡王"
           ],
           [
               "天线",
               "网线"
           ],
           [
               "暧昧",
               "暗恋"
           ],
           [
               "眼睛",
               "眼球"
           ],
           [
               "男厕",
               "女厕"
           ],
           [
               "蒙牛",
               "伊利"
           ],
           [
               "羽毛球",
               "网球"
           ],
           [
               "雪糕",
               "冰激凌"
           ],
           [
               "开包",
               "开封"
           ],
           [
               "加多宝",
               "王老吉"
           ],
           [
               "围巾",
               "围脖"
           ],
           [
               "朋友圈",
               "微博"
           ],
           [
               "矿泉水",
               "纯净水"
           ],
           [
               "DVD",
               "VCD"
           ],
           [
               "小矮人",
               "葫芦娃"
           ],
           [
               "枕头",
               "抱枕"
           ],
           [
               "王昭君",
               "杨玉环"
           ],
           [
               "生活费",
               "零花钱"
           ],
           [
               "图书馆",
               "图书店"
           ],
           [
               "泡泡堂",
               "棒棒糖"
           ],
           [
               "果粒橙",
               "鲜橙多"
           ],
           [
               "雪碧",
               "七喜"
           ],
           [
               "芬达",
               "美年达"
           ],
           [
               "过山车",
               "碰碰车"
           ],
           [
               "福尔摩斯",
               "工藤新一"
           ],
           [
               "红烧牛肉面",
               "香辣牛肉面"
           ],
           [
               "浴缸",
               "浴池"
           ],
           [
               "麦当劳",
               "肯德基"
           ],
           [
               "魔术师",
               "魔法师"
           ],
           [
               "树枝",
               "树干"
           ],
           [
               "扫把",
               "拖把"
           ],
           [
               "门诊",
               "急诊"
           ],
           [
               "粉丝",
               "米线"
           ],
           [
               "小笼包",
               "灌汤包"
           ],
           [
               "土豆粉",
               "酸辣粉"
           ],
           [
               "猴子",
               "猩猩"
           ],
           [
               "汤圆",
               "元宵"
           ],
           [
               "东瓜",
               "西瓜"
           ],
           [
               "洗发露",
               "护发素"
           ],
           [
               "盗墓笔记",
               "鬼吹灯"
           ],
           [
               "电影",
               "电视"
           ],
           [
               "蜜蜂",
               "蜻蜓"
           ],
           [
               "猕猴桃",
               "牛油果"
           ],
           [
               "面包",
               "面饼"
           ],
           [
               "炒面",
               "意面"
           ],
           [
               "矿泉水",
               "纯净水"
           ],
           [
               "围脖",
               "围巾"
           ],
           [
               "领带",
               "领结"
           ],
           [
               "西服",
               "制服"
           ],
           [
               "望远镜",
               "放大镜"
           ],
           [
               "毛巾",
               "毛毯"
           ],
           [
               "大衣",
               "风衣"
           ],
           [
               "出租车",
               "网约车"
           ],
           [
               "机场",
               "机库"
           ],
           [
               "鞭炮",
               "烟花"
           ],
           [
               "晨光",
               "真彩"
           ],
           [
               "AC米兰",
               "国际米兰"
           ],
           [
               "风扇",
               "空调"
           ],
           [
               "龙凤胎",
               "双胞胎"
           ],
           [
               "包子",
               "饺子"
           ],
           [
               "保安",
               "保镖"
           ],
           [
               "抱枕",
               "枕头"
           ],
           [
               "壁纸",
               "贴画"
           ],
           [
               "蝙蝠侠",
               "蜘蛛侠"
           ],
           [
               "饼干",
               "薯片"
           ],
           [
               "玻璃",
               "镜子"
           ],
           [
               "橙子",
               "橘子"
           ],
           [
               "唇膏",
               "口红"
           ],
           [
               "地铁",
               "公交"
           ],
           [
               "第一",
               "冠军"
           ],
           [
               "电脑",
               "iPad"
           ],
           [
               "董永",
               "许仙"
           ],
           [
               "动物",
               "植物"
           ],
           [
               "鹅毛",
               "鸡毛"
           ],
           [
               "灌汤包",
               "小笼包"
           ],
           [
               "光棍节",
               "情人节"
           ],
           [
               "杭州",
               "苏州"
           ],
           [
               "盒子",
               "箱子"
           ],
           [
               "胡子",
               "眉毛"
           ],
           [
               "蝴蝶",
               "飞蛾"
           ],
           [
               "皇帝",
               "太子"
           ],
           [
               "黄蜂",
               "蜜蜂"
           ],
           [
               "灰姑娘",
               "丑小鸭"
           ],
           [
               "婚纱",
               "喜服"
           ],
           [
               "鸡蛋",
               "鸭蛋"
           ],
           [
               "吉他",
               "琵琶"
           ],
           [
               "奖牌",
               "金牌"
           ],
           [
               "结婚",
               "订婚"
           ],
           [
               "警察",
               "捕快"
           ],
           [
               "卷发",
               "直发"
           ],
           [
               "烤肉",
               "涮肉"
           ],
           [
               "扩音器",
               "麦克风"
           ],
           [
               "辣椒",
               "芥末"
           ],
           [
               "脸盆",
               "水桶"
           ],
           [
               "零花钱",
               "生活费"
           ],
           [
               "楼梯",
               "电梯"
           ],
           [
               "裸婚",
               "闪婚"
           ],
           [
               "绿茶",
               "苦茶"
           ],
           [
               "妈妈",
               "娘娘"
           ],
           [
               "满天星",
               "薰衣草"
           ],
           [
               "玫瑰",
               "月季"
           ],
           [
               "孟非",
               "乐嘉"
           ],
           [
               "米线",
               "米粉"
           ],
           [
               "魔法师",
               "魔术师"
           ],
           [
               "那英",
               "韩红"
           ],
           [
               "牛肉",
               "驴肉"
           ],
           [
               "葡萄",
               "提子"
           ],
           [
               "前男友",
               "男朋友"
           ],
           [
               "若曦",
               "晴川"
           ],
           [
               "森马",
               "以纯"
           ],
           [
               "剩女",
               "御姐"
           ],
           [
               "酸辣粉",
               "土豆粉"
           ],
           [
               "铁观音",
               "碧螺春"
           ],
           [
               "同桌",
               "同学"
           ],
           [
               "童话",
               "神话"
           ],
           [
               "图书店",
               "图书馆"
           ],
           [
               "谢娜",
               "李湘"
           ],
           [
               "新年",
               "跨年"
           ],
           [
               "英格兰",
               "苏格兰"
           ],
           [
               "油条",
               "麻花"
           ],
           [
               "赵敏",
               "黄蓉"
           ],
           [
               "遮阳帽",
               "鸭舌帽"
           ],
           [
               "纸巾",
               "手帕"
           ],
           [
               "周立波",
               "郭德纲"
           ],
           [
               "作家",
               "编剧"
           ],
           [
               "作文",
               "论文"
           ],
           [
               "座机",
               "手机"
           ],
           [
               "小品",
               "话剧"
           ],
           [
               "木糖醇",
               "口香糖"
           ],
           [
               "气泡",
               "水泡"
           ],
           [
               "水煮鱼",
               "酸菜鱼"
           ],
           [
               "牛奶",
               "豆浆"
           ],
           [
               "白菜",
               "生菜"
           ],
           [
               "老天爷",
               "老佛爷"
           ],
           [
               "金庸",
               "古龙"
           ],
           [
               "面包",
               "蛋糕"
           ],
           [
               "高富帅",
               "富二代"
           ],
           [
               "丝袜",
               "秋裤"
           ],
           [
               "恐龙",
               "母老虎"
           ],
           [
               "呵呵",
               "嘿嘿"
           ],
           [
               "菊花",
               "桃花"
           ],
           [
               "人妖",
               "妖怪"
           ],
           [
               "妻管严",
               "吃软饭"
           ],
           [
               "螺狮粉",
               "臭豆腐"
           ],
           [
               "母老虎",
               "母夜叉"
           ],
           [
               "买一送一",
               "再来一瓶"
           ],
           [
               "暗恋",
               "备胎"
           ],
           [
               "情敌",
               "前任"
           ],
           [
               "失恋",
               "离婚"
           ],
           [
               "相亲",
               "约会"
           ],
           [
               "女友",
               "老婆"
           ],
           [
               "分居",
               "离婚"
           ],
           [
               "表白",
               "求婚"
           ],
           [
               "我想你",
               "我爱你"
           ],
           [
               "吃软饭",
               "倒插门"
           ],
           [
               "口罩",
               "面具"
           ],
           [
               "眉毛",
               "胡须"
           ],
           [
               "双人床",
               "高低床"
           ],
           [
               "高跟鞋",
               "增高鞋"
           ],
           [
               "明道",
               "阮经天"
           ],
           [
               "范冰冰",
               "李冰冰"
           ],
           [
               "迪丽热巴",
               "古力娜扎"
           ],
           [
               "王者荣耀",
               "英雄联盟"
           ],
           [
               "魔兽争霸",
               "星际争霸"
           ],
           [
               "仙剑奇侠传",
               "古剑奇谭"
           ],
           [
               "第五人格",
               "堡垒之夜"
           ],
           [
               "魂斗罗",
               "马里奥"
           ],
           [
               "荒野行动",
               "绝地求生"
           ],
           [
               "金刚狼",
               "黑寡妇"
           ],
           [
               "甄嬛传",
               "芈月传"
           ],
           [
               "老友记",
               "武林外传"
           ],
           [
               "家有儿女",
               "我爱我家"
           ],
           [
               "元芳",
               "展昭"
           ],
           [
               "麻雀",
               "乌鸦"
           ],
           [
               "端午节",
               "中秋节"
           ],
           [
               "摩托车",
               "电动车"
           ],
           [
               "汉堡包",
               "肉夹馍"
           ],
           [
               "蜘蛛侠",
               "蜘蛛精"
           ],
           [
               "班主任",
               "辅导员"
           ],
           [
               "初吻",
               "初恋"
           ],
           [
               "九阴白骨爪",
               "降龙十八掌"
           ],
           [
               "包青天",
               "狄仁杰"
           ],
           [
               "快乐大本营",
               "天天向上"
           ],
           [
               "夜店",
               "夜市"
           ],
           [
               "Man",
               "Strong"
           ],
           [
               "百事可乐",
               "可口可乐"
           ],
           [
               "手术",
               "解剖"
           ],
           [
               "清明节",
               "重阳节"
           ],
           [
               "美容",
               "整容"
           ],
           [
               "铜",
               "铁"
           ],
           [
               "张国立",
               "张铁林"
           ],
           [
               "张铁林",
               "唐国强"
           ],
           [
               "龙虾",
               "螃蟹"
           ],
           [
               "体育彩票",
               "福利彩票"
           ],
           [
               "芒果",
               "菠萝"
           ],
           [
               "火柴",
               "筷子"
           ],
           [
               "筷子",
               "叉子"
           ],
           [
               "猕猴桃",
               "火龙果"
           ],
           [
               "菠萝",
               "凤梨"
           ],
           [
               "茉莉花",
               "栀子花"
           ],
           [
               "诸葛亮",
               "司马懿"
           ],
           [
               "侦探",
               "间谍"
           ],
           [
               "巧克力",
               "朱古力"
           ],
           [
               "咖啡",
               "可可"
           ],
           [
               "抹茶",
               "绿茶"
           ],
           [
               "水饺",
               "馄饨"
           ],
           [
               "烧鸡",
               "烤鸡"
           ],
           [
               "酱牛肉",
               "卤牛肉"
           ],
           [
               "战士",
               "勇士"
           ],
           [
               "烙饼",
               "烧饼"
           ],
           [
               "可口可乐",
               "百事可乐"
           ],
           [
               "英雄联盟",
               "王者荣耀"
           ],
           [
               "游泳",
               "潜水"
           ],
           [
               "行侠仗义",
               "打抱不平"
           ],
           [
               "奔跑",
               "奔腾"
           ],
           [
               "滑冰",
               "滑板"
           ],
           [
               "笑话",
               "段子"
           ],
           [
               "奶茶",
               "拿铁"
           ],
           [
               "奶油",
               "奶酪"
           ],
           [
               "披萨",
               "肉饼"
           ],
           [
               "威士忌",
               "白兰地"
           ],
           [
               "砖头",
               "石头"
           ],
           [
               "美妆蛋",
               "化妆棉"
           ],
           [
               "被子",
               "褥子"
           ],
           [
               "吊床",
               "躺椅"
           ],
           [
               "水彩",
               "水粉"
           ],
           [
               "馒头",
               "窝头"
           ],
           [
               "炒意面",
               "炒拉条"
           ],
           [
               "香蕉",
               "芭蕉"
           ],
           [
               "卫生巾",
               "卫生棉"
           ],
           [
               "王菲",
               "那英"
           ],
           [
               "姜文",
               "夏雨"
           ],
           [
               "甄子丹",
               "李连杰"
           ],
           [
               "黄飞鸿",
               "方世玉"
           ],
           [
               "男朋友",
               "男闺蜜"
           ],
           [
               "口香糖",
               "木糖醇"
           ],
           [
               "双胞胎",
               "龙凤胎"
           ],
           [
               "小沈阳",
               "宋小宝"
           ],
           [
               "海豚",
               "海豹"
           ],
           [
               "郭德纲",
               "岳云鹏"
           ],
           [
               "牛肉干",
               "牛板筋"
           ],
           [
               "孜然",
               "胡椒"
           ],
           [
               "电视游戏",
               "电脑游戏"
           ],
           [
               "花生",
               "栗子"
           ]
       ];
        foreach ($inputExcelConfig as $inputConfig) {            
                $word = [];
                $word['word_1'] = $inputConfig[0];
                $word['word_2'] = $inputConfig[1];
                $word['hash_id'] = self::getHash([$inputConfig[0], $inputConfig[1]]);
                $word['status'] = 1;
                $word['created_at'] = date('Y-m-d H:i:s');
                $word['updated_at'] = date('Y-m-d H:i:s');
                
                file_put_contents(self::$exportFile,
                    $word['word_1'] . "," .
                    $word['word_2'] . "," .
                    $word['hash_id'] . "," .
                    $word['status'] . "," .
                    $word['created_at'] . "," .
                    $word['updated_at'] . PHP_EOL, FILE_APPEND
                );
        }
            
        echo 'success >> /Users/zhangyan/Desktop/words_csv.txt' . PHP_EOL;
    }

    public static function getHash(array $words)
    {
        $list = [];
        foreach ($words as $word)
        {
            $list[md5($word)] = $word;
        }

        ksort($list);

        return md5(implode($list));
    }
}
new ImportWord();

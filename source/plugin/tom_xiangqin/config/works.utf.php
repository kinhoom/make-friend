<?php
/*
 * 源码出处：大-叔-来
 * 官方网址: www.dashulai.com
 * 备用网址: https://dwz.cn/q4scNR7Q(请收藏备用!)
 * 本资源来源于网络收集,仅供个人学习研究欣赏，请勿用于商业用途，并于下载24小时后删除!
 * 技术支持/更新维护：官网 https://www.dashulai.com
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$worksArray = array(
    '1' => '学生',
    '2' => '高层管理',
    '3' => '私营业主',
    '4' => '销售',
    '5' => '策划',
    '6' => '研发/技术',
    '7' => '设计',
    '8' => '财务',
    '9' => '人事行政',
    '10' => '客服',
    '11' => '文秘助理',
    '12' => '咨询培训',
    '13' => '职员',
    '14' => '部门主管',
    '15' => '公务员',
    '16' => '机关干部',
    '17' => '教师',
    '18' => '工人',
    '19' => '农民',
    '20' => '军人',
    '21' => '警察',
    '22' => '医生',
    '23' => '护士',
    '24' => '艺术',
    '25' => '演艺',
    '26' => '模特',
    '27' => '记者编辑',
    '28' => '体育',
    '29' => '律师',
    '30' => '专业人士',
    '31' => '自由职业',
    '32' => '家庭主妇',
    '33' => '待业',
    '34' => '退休',
    '127' => '其它',
);

$eduArray = array(
    '1' => '小学',
    '2' => '初中',
    '3' => '高中/中专',
    '4' => '专科',
    '5' => '本科',
    '6' => '硕士',
    '7' => '博士',
    '8' => '博士后',
    '9' => '其他',
);

$payArray = array(
    '1' => '2000以下',
    '2' => '2000-5000',
    '3' => '5000-8000',
    '4' => '8000-10000',
    '5' => '10000-20000',
    '6' => '20000-50000',
    '7' => '50000以上',
);

$maritalArray = array(
    '1' => '未婚',
    '2' => '离异',
    '3' => '丧偶',
);

$ageArray = array(
    '1' => '18',
	'2' => '19',
    '3' => '20',
    '4' => '21',
    '5' => '22',
    '6' => '23',
	'7' => '24',
    '8' => '25',
    '9' => '26',
    '10' => '27',
    '11' => '28',
	'12' => '29',
    '13' => '30',
    '14' => '31',
    '15' => '32',
    '16' => '33',
	'17' => '34',
    '18' => '35',
    '19' => '36',
    '20' => '37',
    '21' => '38',
	'21' => '39',
    '23' => '40',
    '24' => '41',
    '25' => '42',
    '26' => '43',
	'27' => '44',
    '28' => '45',
    '29' => '46',
    '30' => '47',
    '31' => '48',
	'32' => '49',
    '33' => '50',
   
);

$childArray = array(
    '1' => '无小孩',
	'2' => '有小孩归自己',
    '3' => '有小孩归对方',
);

$houseArray = array(
    '1' => '暂无购房',
	'2' => '需要时购置',
    '3' => '已购房-有贷款',
    '4' => '已购房-无贷款',
    '5' => '与人合租',
    '6' => '独自租房',
    '7' => '与父母同住',
    '8' => '住亲朋家',
    '9' => '住单位房',
);

$carArray = array(
    '1' => '暂无购车',
	'2' => '已购车-经济型',
    '3' => '已购车-中档型',
    '4' => '已购车-豪华型',
    '5' => '单位用车',
    '6' => '需要时购置',
);

$minzuArray = array(
    '1' => '汉族',
    '2' => '蒙古族',
    '3' => '回族',
    '4' => '藏族',
    '5' => '维吾尔族',
    '6' => '苗族',
    '7' => '彝族',
    '8' => '壮族',
    '9' => '布依族',
    '10' => '朝鲜族',
    '11' => '满族',
    '12' => '侗族',
    '13' => '瑶族',
    '14' => '白族',
    '15' => '土家族',
    '16' => '哈尼族',
    '17' => '哈萨克族',
    '18' => '傣族',
    '19' => '黎族',
    '20' => '僳僳族',
    '21' => '畲族',
    '22' => '高山族',
    '23' => '拉祜族',
    '24' => '水族',
    '25' => '东乡族',
    '26' => '纳西族',
    '27' => '景颇族',
    '28' => '柯尔克孜族',
    '29' => '土族',
    '30' => '达斡尔族',
    '31' => '仫佬族',
    '32' => '羌族',
    '33' => '布朗族',
    '34' => '撒拉族',
    '35' => '毛南族',
    '36' => '仡佬族',
    '37' => '锡伯族',
    '38' => '阿昌族',
    '39' => '普米族',
    '40' => '塔吉克族',
    '41' => '乌孜别克族',
    '42' => '俄罗斯族',
    '43' => '鄂温克族',
    '44' => '德昂族',
    '45' => '保安族',
    '46' => '裕固族',
    '47' => '塔塔尔族',
    '48' => '独龙族',
    '49' => '鄂伦春族',
    '50' => '赫哲族',
    '51' => '门巴族',
    '52' => '珞巴族',
    '53' => '基诺族',
    '54' => '京族',
    '55' => '布朗族',
    '56' => '怒族',
    
);

$xuexingArray = array(
    '1' => 'A',
	'2' => 'B',
    '3' => 'AB',
    '4' => 'O',
);

$shuxiangArray = array(
    '1' => '鼠',
	'2' => '牛',
    '3' => '虎',
    '4' => '兔',
    '5' => '龙',
    '6' => '蛇',
    '7' => '马',
    '8' => '羊',
    '9' => '猴',
    '10' => '鸡',
    '11' => '狗',
    '12' => '猪',
    
);

$xingzuoArray = array(
    '17' => '白羊',
	'18' => '金牛',
    '19' => '双子',
    '20' => '巨蟹',
    '21' => '狮子',
    '22' => '处女',
    '23' => '天蝎',
    '24' => '射手',
    '25' => '摩羯',
    '26' => '水平',
    '27' => '双鱼',
    '111' => '天秤',
    
);

$weightArray = array(
    '1' => '40',
	'2' => '42',
    '3' => '44',
    '4' => '46',
    '5' => '48',
    '6' => '50',
    '7' => '52',
    '8' => '54',
    '9' => '56',
    '10' => '58',
    '11' => '60',
    '12' => '62',
    '13' => '64',
	'14' => '66',
    '15' => '68',
    '16' => '70',
    '17' => '75',
    '18' => '80',
    '19' => '85',
    '20' => '90',
    '21' => '95',
    '22' => '100',
    
);

$heightArray = array(
    '1' => '150',
	'2' => '151',
    '3' => '152',
    '4' => '153',
    '5' => '154',
    '6' => '155',
    '7' => '156',
    '8' => '157',
    '9' => '158',
    '10' => '159',
    '11' => '160',
    '12' => '161',
    '13' => '162',
	'14' => '163',
    '15' => '164',
    '16' => '165',
    '17' => '166',
    '18' => '167',
    '19' => '168',
    '20' => '169',
    '21' => '170',
    '22' => '171',
    '23' => '172',
    '24' => '173',
    '25' => '174',
    '26' => '175',
    '27' => '176',
    '28' => '177',
    '29' => '178',
    '30' => '179',
    '31' => '180',
    '32' => '181',
    '33' => '182',
    '34' => '183',
    '35' => '184',
    '36' => '185',
    '37' => '186',
    '38' => '187',
    '39' => '188',
    '40' => '189',
    '41' => '190',
    '42' => '191',
    '43' => '192',
    '44' => '193',
    '45' => '194',
    '46' => '195',
    '47' => '196',
    '48' => '197',
    '49' => '198',
    '50' => '199',

);

$heightSearchArray = array(
    '1' => '155cm以下',
	'2' => '156-160cm',
    '3' => '161-165cm',
    '4' => '166-170cm',
    '5' => '171-175cm',
    '6' => '176-180cm',
    '7' => '180cm以上',
   
);
$paySearchArray = array(
    '1' => '5k以下',
    '2' => '5k-10k',
    '3' => '10k-20k',
    '4' => '20k-30k',
    '5' => '30k-50k',
    '6' => '50k以上',
);

$eduSearchArray = array(
    '1' => '高中或中专',
    '2' => '专科',
    '3' => '本科',
    '4' => '硕士',
    '5' => '博士',
    '6' => '博士后',
);

$ageSearchArray = array(
    '1' => '18-22岁',
	'2' => '23-25岁',
    '3' => '26-30岁',
    '4' => '31-35岁',
    '5' => '36岁以上',
);
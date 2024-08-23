<?php

/**
 * AddMenu
 * 
 * @package AddMenu
 * @author yikafu
 * @version 1.0.0
 * @link http://github.com/yikafu/AddMenu_Plugin
 */
class AddMenu_Plugin implements Typecho_Plugin_Interface
{
    /* 激活插件方法 */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->render = array('AddMenu_Plugin', 'render');
    }

    /* 禁用插件方法 */
    public static function deactivate() {}

    /* 插件配置方法 */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        // json格式
        $json = new Typecho_Widget_Helper_Form_Element_Textarea('json', NULL, NULL, _t('菜单配置'), _t('请按照json格式配置菜单'));
        $form->addInput($json);
        $rad = new Typecho_Widget_Helper_Form_Element_Radio('rad', array('0' => '否', '1' => '是'), '0', _t('是否使用本地json'), _t('默认否，否则使用插件目录下的sample.json'));
        $form->addInput($rad);
    }

    /* 个人用户的配置方法 */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

    /* 插件实现方法 */
    public static function render()
    {
        $html = '';
        $rad = Typecho_Widget::widget('Widget_Options')->plugin('AddMenu')->rad;
        // 读取本地json
        if ($rad == 1) {
            $json = file_get_contents(__DIR__ . '/sample.json');
        } else {
            $json = Typecho_Widget::widget('Widget_Options')->plugin('AddMenu')->json;
        }
        // 遍历json
        $menu = json_decode($json, true);
        foreach ($menu as $item) {
            if (isset($item['children'])) {
                $html .= '<span class="dropdown">' . $item['name'] . '<ul>';
                foreach ($item['children'] as $child) {
                    $html .= '<li><a href="' . $child['url'] . '">' . $child['name'] . '</a></li>';
                }
                $html .= '</ul></span>';
            } else {
                $html .= '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';
            }
        }
        echo $html;
    }
}

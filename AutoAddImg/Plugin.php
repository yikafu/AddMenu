<?php

namespace TypechoPlugin\AutoAddImg;

use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;
use Typecho\Widget\Helper\Form\Element\Text;
use Widget\Options;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 通过js自动添加图片
 *
 * @package AutoAddImg
 * @author none
 * @version 1.0.0
 * @link http://typecho.org
 */
class Plugin implements PluginInterface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     */
    public static function activate()
    {
        \Typecho\Plugin::factory('admin/menu.php')->navBar = __CLASS__ . '::render';
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @param Form $form 配置面板
     */
    public static function config(Form $form)
    {
    }

    /**
     * 个人用户的配置面板
     *
     * @param Form $form
     */
    public static function personalConfig(Form $form)
    {
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render()
{
    // 判断当前页面是否包含 admin/write-post.php
    if (strpos($_SERVER['REQUEST_URI'], 'admin/write-post.php') !== false) {
        echo '<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        echo '<script>
            function addImg() {
                let s = document.querySelector("#slug").value;
                let slug = 100000 + Number.parseInt(s);
                let imgurl = "https://yikafu.us.kg/pic/" + slug + ".jpg";
                let bannerInput = document.querySelector(\'input[name="fields[banner]"]\');
                if (bannerInput) {
                    bannerInput.value = imgurl;
                } else {
                    console.error("Banner input not found.");
                }
            }
            window.onload = function() {
                // 添加按钮
                let d = document.createElement("div");
                d.innerHTML = "添加图片";
                d.style = "cursor: pointer; width: 80px ; text-align: center; background: #d6e9ff; color: #000; border: 1px solid #000; ";   
                d.onclick = addImg;
                
                let bannerParent = document.querySelector(\'input[name="fields[banner]"]\');
                if (bannerParent) {
                    bannerParent.parentNode.appendChild(d);
                } else {
                    console.error("Banner parent element not found.");
                }   
            }
        </script>';
    }
}

}

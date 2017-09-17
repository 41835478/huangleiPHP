<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Clothing Shop 管理中心 - 修改 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/clothing_shop/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/clothing_shop/Public/Styles/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        window.UEDITOR_HOME_URL = '/clothing_shop/Public/Data/';
        window.onload = function(){
            window.UEDITOR_CONFIG.toolbars= [[

                'bold', 'italic', 'underline', '|', 'forecolor', 'backcolor',  '|', 'fontfamily', 'fontsize', '|',

                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|','insertimage'

            ]];
            UE.getEditor('editor');
        }
    </script>
    <script type="text/javascript" src="/clothing_shop/Public/Data/ueditor.config.js"></script>
    <script type="text/javascript" src="/clothing_shop/Public/Data/ueditor.all.min.js"> </script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/clothing_shop/index.php/Home/Goods/lst">列表</a></span>
    <span class="action-span1"><a href="#">Clothing Shop 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 修改 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
<!-- /clothing_shop/index.php/Home/goods/save/id/22.html:当前方法 -->
    <form method="POST" action="/clothing_shop/index.php/Home/goods/save/id/22.html" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <input type="hidden" name="oldlogo" value="<?php echo $data['goods_image']; ?>">
            <tr>
                <td class="label">商品图片：</td>
                <td>
                    <img src="/clothing_shop/Uploads/<?php echo $data['goods_image']; ?>" width="80">
                    <input type="file" name="goods_image" size="35" />
                </td>
            </tr>
            <tr>
                <td class="label">商品名称：</td>
                <td><input type="text" name="goods_name" value="<?php echo $data['goods_name'];?>" size="30" />
                </td>
            </tr>
            <tr>
                <td class="label">商品分类：</td>
                <td>
                    <select name="cat_id">
                        <option value="0">请选择商品分类...</option>
                        <?php foreach($catData as $v): if($v['id'] == $data['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
                        <option <?php echo $select; ?> value="<?php echo $v['id']?>"><?php echo str_repeat('-',$v['level']*8).$v['cat_name']?></option>
                        <?php endforeach;?>
                    </select>

                </td>
            </tr>
            <tr>
                <td class="label">商品型号：</td>
                <td>
                <input type="checkbox" <?php echo strpos($data['goods_size'],'S码') !==false ? "checked='checked'" : '';?> name="size[]" value="S码" size="30" />S码
                <input type="checkbox" <?php echo strpos($data['goods_size'],'M码') !==false ? "checked='checked'" : '';?> name="size[]" value="M码" size="30" />M码
                <input type="checkbox" <?php echo strpos($data['goods_size'],'L码') !==false ? "checked='checked'" : '';?> name="size[]" value="L码" size="30" />L码
                <input type="checkbox" <?php echo strpos($data['goods_size'],'XL码') !==false ? "checked='checked'" : '';?> name="size[]" value="XL码" size="30" />XL码
                <input type="checkbox" <?php echo strpos($data['goods_size'],'XXL码') !==false ? "checked='checked'" : '';?> name="size[]" value="XXL码" size="30" />XXL码
                <input type="checkbox" <?php echo strpos($data['goods_size'],'XXXL码') !==false ? "checked='checked'" : '';?> name="size[]" value="XXXL码" size="30" />XXXL码
            </td>


            </tr>
            <tr>
                <td class="label">商品价格：</td>
                <td><input type="text" name="goods_price" value="<?php echo $data['goods_price']; ?>" size="30" />元
                </td>
            </tr>
            <tr>
                <td class="label">商品详情：</td>
                <td><textarea id="editor" style="width:600px;height:200px;" name="goods_info" ><?php echo $data['goods_info'];?></textarea></td>

            </tr>
            <td colspan="2" align="center"><br />
                <input type="submit" class="button" value=" 确定 " />
                <input type="reset" class="button" value=" 重置 " />
            </td>
            </tr>
        </table>
    </form>
</div>
<div id="footer">
    CopyRight &copy; 版权归 Clothing Shop 所有。
</div>
</body>
</html>
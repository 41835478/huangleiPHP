<?php
namespace Goods\Model;
use Think\Model;
class TypeModel extends Model
{


    public function _before_delete($data){

        $model = M('attribute');
        $model->where('type_id='.$data['where']['id'])->delete();

    }

}
<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class CategoryController extends CommonController
{
	//level的作用，区分经销商 物业 业主
	public function add(){
		$admin = D('category');
		$this->data = $admin->catTree();
		if(IS_POST){
			$arr = array(
				'parent_id' => $_POST['parent_id'],
				'cat_name' => $_POST['cat_name'],
			);
			$arr['level'] = 3;
			if($arr['parent_id'] == 0){
				$arr['level'] = 1;
			}else{
				$b = $admin->select();
				foreach($b as $v){
					if($v['parent_id']==0 && $v['id']==$arr['parent_id']){
						$arr['level'] = 2;
					}
				}
			}
			if($admin->data($arr)->add()){
				$this->success('添加成功',U(MODULE_NAME.'/Category/lst'));
			}else{
				$this->error('添加失败,请重试！');
			}

		}else{
			$this->display();
		}
	}
	public function save(){
		$id = $_GET['id'];
		$admin = D('category');
		if(IS_POST){
			
			if($admin->create()){
				
				if($admin->save() !== false){
					$this->success('修改成功',U(MODULE_NAME.'/Category/lst'));
					exit;
				}else{
					$this->error('修改失败,请重试！');
				}

			}else{
				//获取错误信息
				$this->error($admin->getError());
			}
		}else{
			$this->catData = $admin->catTree();
			$this->data = $admin->find($id);
			$this->display();
		}
	}
	public function lst(){
		$admin = D('category');
		//model中的自定义方法，实现无限极分类
		$this->data = $admin->catTree();
		$this->display();
	}
	public function del(){
		$id = $_GET['id'];
		$admin = D('category');
		$admin->delete($id);
		$this->success('删除成功');

	}
	public function bdel(){
		$dels = $_POST['dels'];
		if($dels){	
			$del = implode(',',$dels);
			$admin = D('category');
			$admin->delete($del);
		}
		$this->success('删除成功！');
	}
}
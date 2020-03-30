<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback; //引用模型
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class FeelbackController extends Controller {
	use ModelForm;

	public function index() {
		return Admin::content(function (Content $content) {

			$content->header('反馈管理');

			$content->body($this->grid());
		});
	}

	public function create() {
		return Admin::content(function (Content $content) {

			$content->header('反馈管理');
			$content->body($this->form());

		});
	}

	public function edit($id) {
		return Admin::content(function (Content $content) use ($id) {
			$content->header('反馈管理');
			$content->description();
			$content->body($this->form()->edit($id));
		});
	}

	protected function grid() {

		return Admin::grid(Feedback::class, function (Grid $grid) {

			$grid->id('ID')->sortable();
			$grid->getUser()->nickname('用户名');
			$grid->message('反馈信息');
			$grid->column('state', '状态')
				->select(Feedback::getState());
			$grid->created_at();
			$grid->updated_at();
		});

	}

	protected function form() {
		return Admin::form(Feedback::class, function (Form $form) {
			$form->text('user_id', '用户Id');
			$form->text('message', '反馈信息');
			$form->radio('status', '状态')->options([0 => '未处理', 1 => '处理中', 2 => '处理完成']);

			$form->display('created_at', 'Created At');
			$form->display('updated_at', 'Updated At');
		});
	}

}
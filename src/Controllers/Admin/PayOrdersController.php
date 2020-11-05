<?php

namespace Qihucms\Payment\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\Models\User;
use Qihucms\Payment\Models\PayOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PayOrdersController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '支付订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PayOrder);

        $grid->disableCreateButton();

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('user_id', __('payment::pay_order.user_id'));
            $filter->equal('driver', __('payment::pay_order.driver'));
            $filter->equal('gateway', __('payment::pay_order.gateway'));
            $filter->equal('type', __('payment::pay_order.type'));
            $filter->like('subject', __('payment::pay_order.subject'));
            $filter->equal('status', __('payment::pay_order.status.label'))
                ->select(__('payment::pay_order.status.value'));
        });

        $grid->column('id', __('payment::pay_order.id'));
        $grid->column('driver', __('payment::pay_order.driver'));
        $grid->column('gateway', __('payment::pay_order.gateway'));
        $grid->column('type', __('payment::pay_order.type'));
        $grid->column('user_nickname', __('user.nickname'))->display(function () {
            return $this->user->nickname ?? '非本站会员';
        });
        $grid->column('subject', __('payment::pay_order.subject'));
        $grid->column('total_amount', __('payment::pay_order.total_amount'));
        $grid->column('status', __('payment::pay_order.status.label'))
            ->using(__('payment::pay_order.status.value'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PayOrder::findOrFail($id));

        $show->field('id', __('payment::pay_order.id'));
        $show->field('user_id', __('payment::pay_order.user_id'))->as(function () {
            return $this->user->nickname ?? '非本站会员';
        });
        $show->field('driver', __('payment::pay_order.driver'));
        $show->field('gateway', __('payment::pay_order.gateway'));
        $show->field('type', __('payment::pay_order.type'));
        $show->field('subject', __('payment::pay_order.subject'));
        $show->field('total_amount', __('payment::pay_order.total_amount'));
        $show->field('params', __('payment::pay_order.params'));
        $show->field('result', __('payment::pay_order.result'));
        $show->field('status', __('payment::pay_order.status.label'))
            ->using(__('payment::pay_order.status.value'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PayOrder);
        $form->select('user_id', __('payment::pay_order.user_id'))
            ->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->username];
                }
            })
            ->ajax(route('api.article.select.users.q'))
            ->required();
        $form->text('driver', __('payment::pay_order.driver'))->required();
        $form->text('gateway', __('payment::pay_order.gateway'))->required();
        $form->text('type', __('payment::pay_order.type'))->required();
        $form->text('subject', __('payment::pay_order.subject'))->required();
        $form->currency('total_amount', __('payment::pay_order.total_amount'))
            ->symbol('¥')->default(0);
        $form->select('status', __('payment::pay_order.status.label'))
            ->options(__('payment::pay_order.status.value'));

        return $form;
    }
}

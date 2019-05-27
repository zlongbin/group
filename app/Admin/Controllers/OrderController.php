<?php

namespace App\Admin\Controllers;

use App\Model\OrderModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrderModel);

        $grid->oid('Oid');
        $grid->order_sn('Order sn');
        $grid->user_id('User id');
        $grid->addtime('Addtime');
        $grid->add_price('Add price');
        $grid->pay_amount('Pay amount');
        $grid->pay_time('Pay time');
        $grid->is_delete('Is delete');
        $grid->is_pay('Is pay');
        $grid->plat('Plat');

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
        $show = new Show(OrderModel::findOrFail($id));

        $show->oid('Oid');
        $show->order_sn('Order sn');
        $show->user_id('User id');
        $show->addtime('Addtime');
        $show->add_price('Add price');
        $show->pay_amount('Pay amount');
        $show->pay_time('Pay time');
        $show->is_delete('Is delete');
        $show->is_pay('Is pay');
        $show->plat('Plat');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OrderModel);

        $form->number('oid', 'Oid');
        $form->text('order_sn', 'Order sn');
        $form->number('user_id', 'User id');
        $form->number('addtime', 'Addtime');
        $form->number('add_price', 'Add price');
        $form->text('pay_amount', 'Pay amount');
        $form->number('pay_time', 'Pay time');
        $form->switch('is_delete', 'Is delete')->default(1);
        $form->switch('is_pay', 'Is pay')->default(1);
        $form->switch('plat', 'Plat');

        return $form;
    }
}

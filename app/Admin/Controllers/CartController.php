<?php

namespace App\Admin\Controllers;

use App\Model\CartModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CartController extends Controller
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
        $grid = new Grid(new CartModel);

        $grid->id('Id');
        $grid->goods_id('Goods id');
        $grid->user_id('User id');
        $grid->add_price('Add price');
        $grid->buy_number('Buy number');
        $grid->is_del('Is del');
        $grid->create_time('Create time');
        $grid->update_time('Update time');
        $grid->updated_at('Updated at');

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
        $show = new Show(CartModel::findOrFail($id));

        $show->id('Id');
        $show->goods_id('Goods id');
        $show->user_id('User id');
        $show->add_price('Add price');
        $show->buy_number('Buy number');
        $show->is_del('Is del');
        $show->create_time('Create time');
        $show->update_time('Update time');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CartModel);

        $form->number('goods_id', 'Goods id');
        $form->number('user_id', 'User id');
        $form->text('add_price', 'Add price');
        $form->number('buy_number', 'Buy number');
        $form->number('is_del', 'Is del')->default(1);
        $form->number('create_time', 'Create time');
        $form->number('update_time', 'Update time');

        return $form;
    }
}

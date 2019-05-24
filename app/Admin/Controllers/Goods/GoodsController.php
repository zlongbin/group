<?php

namespace App\Admin\Controllers\Goods;

use App\Model\GoodsModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodsController extends Controller
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
        $grid = new Grid(new GoodsModel);

        $grid->goods_id('Goods id');
        $grid->goods_name('Goods name');
        $grid->goods_selfprice('Goods selfprice');
        $grid->goods_marketprice('Goods marketprice');
        $grid->goods_up('Goods up');
        $grid->goods_new('Goods new');
        $grid->goods_best('Goods best');
        $grid->goods_hot('Goods hot');
        $grid->goods_num('Goods num');
        $grid->goods_integral('Goods integral');
        $grid->goods_img('Goods img')->image('/goodsimg');
        $grid->goods_imgs('Goods imgs');
        $grid->goods_desc('Goods desc');
        $grid->cate_id('Cate id');
        $grid->brand_id('Brand id');
        $grid->goods_salenum('Goods salenum');
        $grid->create_time('Create time');
        $grid->goods_recommend('Goods recommend');
        $grid->click_id('Click id');

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
        $show = new Show(GoodsModel::findOrFail($id));

        $show->goods_id('Goods id');
        $show->goods_name('Goods name');
        $show->goods_selfprice('Goods selfprice');
        $show->goods_marketprice('Goods marketprice');
        $show->goods_up('Goods up');
        $show->goods_new('Goods new');
        $show->goods_best('Goods best');
        $show->goods_hot('Goods hot');
        $show->goods_num('Goods num');
        $show->goods_integral('Goods integral');
        $show->goods_img('Goods img');
        $show->goods_imgs('Goods imgs');
        $show->goods_desc('Goods desc');
        $show->cate_id('Cate id');
        $show->brand_id('Brand id');
        $show->goods_salenum('Goods salenum');
        $show->create_time('Create time');
        $show->goods_recommend('Goods recommend');
        $show->click_id('Click id');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GoodsModel);

        $form->number('goods_id', 'Goods id');
        $form->text('goods_name', 'Goods name');
        $form->decimal('goods_selfprice', 'Goods selfprice');
        $form->decimal('goods_marketprice', 'Goods marketprice');
        $form->switch('goods_up', 'Goods up');
        $form->switch('goods_new', 'Goods new')->default(2);
        $form->switch('goods_best', 'Goods best')->default(2);
        $form->switch('goods_hot', 'Goods hot')->default(2);
        $form->number('goods_num', 'Goods num');
        $form->number('goods_integral', 'Goods integral');
        $form->image('goods_img', 'Goods img')->move(date('Ymd'));
        $form->image('goods_imgs', 'Goods imgs');
        $form->textarea('goods_desc', 'Goods desc');
        $form->number('cate_id', 'Cate id');
        $form->number('brand_id', 'Brand id');
        $form->number('goods_salenum', 'Goods salenum');
        $form->number('create_time', 'Create time');
        $form->text('goods_recommend', 'Goods recommend');
        $form->number('click_id', 'Click id')->default(100);

        return $form;
    }
}

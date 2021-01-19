<?php
declare (strict_types = 1);
namespace app\api\controller;
use think\exception\ValidateException;
use think\facade\Validate;
use think\Request;
use app\model\User as UserModel;
use app\validate\User as UserValidate;

class User extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //获取数据列表
        $data = UserModel::field('id, username, gender, email')
                            ->page($this->page, $this->pageSize)
                            ->select();

        //判断是否有值
        if ($data->isEmpty()) {
            return $this->create([], '无数据', 204);
        } else {
            return $this->create($data, '数据请求成功', 200);
        }

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //获取数据
        $data = $request->param();

        //验证返回
        try {
            //验证
            validate(UserValidate::class)->check($data);
        } catch (ValidateException $exception) {
            //错误返回
            return $this->create([], $exception->getError(), 400);
        }

        //密码
        $data['password'] = sha1($data['password']);

        //写入并返回id
        $id = UserModel::create($data)->getData('id');

        //判断是否有值
        if (empty($id)) {
            return $this->create([], '注册失败~', 400);
        } else {
            return $this->create($id, '注册成功~', 200);
        }

    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //判断id是否整型
        if (!Validate::isInteger($id)) {
            return $this->create([], 'id参数不合法~', 400);
        }

        //获取数据
        $data = UserModel::field('id,username,gender,email')->find($id);

        //判断是否有值
        if (empty($data)) {
            return $this->create([], '无数据', 204);
        } else {
            return $this->create($data, '数据请求成功', 200);
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //获取数据
        $data = $request->param();

        //验证返回
        try {
            //验证
            validate(UserValidate::class)->scene('edit')->check($data);
        } catch (ValidateException $exception) {
            //错误返回
            return $this->create([], $exception->getError(), 400);
        }

        //获取数据库里的数据
        $updateData = UserModel::find($id);

        //邮箱修改时不可以一致
        if ($updateData->email === $data['email']) {
            return $this->create([], '修改的邮箱和原来的一致~', 400);
        }

        //修改
        $id = UserModel::update($data)->getData('id');

        //判断是否有值
        if (empty($id)) {
            return $this->create([], '修改失败~', 400);
        } else {
            return $this->create($id, '修改成功~', 200);
        }

    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //判断id是否整型
        if (!Validate::isInteger($id)) {
            return $this->create([], 'id参数不合法~', 400);
        }

        //删除
        try {
            UserModel::find($id)->delete();
            return $this->create([], '删除成功~', 200);
        } catch (\Error $e) {
            return $this->create([], '错误或无法删除~', 400);
        }

    }


    public function hobby($id)
    {
        //判断id是否整型
        if (!Validate::isInteger($id)) {
            return $this->create([], 'id参数不合法~', 400);
        }

        //喜好数据集
        $data = UserModel::find($id)->hobby()->field('id,content')->select();

        //判断是否有值
        if ($data->isEmpty()) {
            return $this->create([], '无数据', 204);
        } else {
            return $this->create($data, '数据请求成功', 200);
        }

    }

    public function login(Request $request)
    {
        $data = $request->param();

        //验证用户密码
        $result = Validate::rule([
            'username'  =>  'unique:user,username^password'
        ])->check([
            'username'  =>  $data['username'],
            'password'  =>  sha1($data['password'])
        ]);

        //判断，反向
        if (!$result) {
            session('admin', $data['username']);
            return $this->create(true, '登录成功~', 200);
        } else {
            return $this->create([], '用户名或密码错误~', 400);
        }

    }
}

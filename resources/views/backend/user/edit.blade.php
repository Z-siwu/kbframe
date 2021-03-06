@extends('backend.layouts.base')

@section('content')
    <div class="layui-card-body" style="background-color: #fff;">
            <form class="layui-form" action="" method="post" id="layui-layer" lay-filter="component-form-element">
                <input type="hidden" name="id" value="{{$user->id}}">
                {{csrf_field()}}
                @widget('Text', [
                    'title'=>'用户名',
                    'type'=>'text',
                    'name'=>'username',
                    'value'=>$user->username,
                    'placeholder'=>'请输入用户名',
                    'verify'=>'required'
                ])
                @widget('Text', [
                    'title'=>'昵称',
                    'type'=>'text',
                    'name'=>'nickname',
                    'value'=>$user->nickname,
                    'placeholder'=>'请输入昵称',
                    'verify'=>'required'
                ])
                @widget('Text', [
                    'title'=>'密码',
                    'type'=>'password',
                    'name'=>'password',
                    'value'=>'',
                    'placeholder'=>'请输入密码'
                ])
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">角色</label>
                        <div class="layui-input-inline">
                            <select name="role" xm-select="role" xm-select-skin="normal" xm-select-type="2" lay-filter="role">
                                <option value="">请选择角色</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="roles" value="{{$roleVal}}" class="layui-input">
                @widget('Text', [
                    'title'=>'手机号',
                    'type'=>'text',
                    'name'=>'mobile',
                    'value'=>$user->mobile,
                    'placeholder'=>'请输入手机号',
                    'required'=>'phone',
                    'verify'=>'phone'
                ])
                @widget('Radio', [
                    'title'=>'性别',
                    'name'=>'gender',
                    'data'=>[
                        '男'=>'1',
                        '女'=>'2',
                        '未知'=>'0'
                    ],
                    'value'=>$user->gender,
                ])
                @widget('Picture', [
                    'id'=>'upload-head-portrait',
                    'uuid'=>'head-portrait',
                    'title'=>'头像',
                    'key'=>'上传图片',
                    'name'=>'head_portrait',
                    'value'=>$user->head_portrait,
                ])
                @widget('Text', [
                    'title'=>'QQ',
                    'type'=>'text',
                    'name'=>'qq',
                    'value'=>$user->qq,
                    'placeholder'=>'请输入QQ'
                ])
                @widget('Text', [
                    'title'=>'邮箱',
                    'type'=>'email',
                    'name'=>'email',
                    'value'=>$user->email,
                    'placeholder'=>'请输入Email'
                ])
                @widget('Text', [
                    'id'=>'birthday',
                    'title'=>'生日',
                    'type'=>'text',
                    'name'=>'birthday',
                    'value'=>$user->birthday,
                    'placeholder'=>'yyyy-MM-dd'
                ])
                @widget('Radio', [
                    'title'=>'状态',
                    'name'=>'status',
                    'data'=>[
                        '启用'=>'1',
                        '禁用'=>'0'
                    ],
                    'value'=>$user->status,
                ])
                @widget('Submit', [
                    'id'=>'LAY-user-backend-submit',
                    'value'=>'确认',
                    'filter'=>'LAY-user-backend-submit',
                    'hide'=>'',
                ])
            </form>
    </div>
    <script>
        layui.config({
            base: '/static/libs'    //此处写的相对路径, 实际以项目中的路径为准
        }).extend({
            formSelects: 'formSelects-v3'
        }).use(['laydate','form','upload', 'formSelects'], function(){
            var form = layui.form
                ,laydate = layui.laydate
                ,upload = layui.upload
                ,formSelects = layui.formSelects;

            formSelects.render({
                name: 'role',         //xm-select的值
                type: 2,                 //等效xm-select-type, 选择样式
                max: 10,                  //最大多选值
                init: <?php echo "[".$roleVal."]";?>,               //初始化选择值, 优先级高
                on: function(data, arr){ //监听数据变化
                    var roleList = [];
                    console.log(arr);
                    for(let i =0;i<arr.length;i++){
                        if(roleList.indexOf(arr[i].val) == -1){
                            roleList.push(arr[i].val);
                        }
                    }
                    $('input[name="roles"]').val(roleList);
                },
            });

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload-head-portrait'
                ,url: '/backend/upload/images'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#head-portrait').attr('src', result).css('width', '100px').css('height', '100px').css('margin-left', '110px'); //图片链接（base64）
                    });
                }
                ,done: function(res){
                    //如果上传失败
                    if(res.code == 0){
                        $("input[name='head_portrait']").val(res.data.url);
                        return layer.msg('上传成功', {time: 1000});
                    } else {
                        return layer.msg('上传失败', {time: 1000});
                    }
                    //上传成功
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#test-upload-demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });

            //常规用法
            laydate.render({
                elem: '#birthday'
            });
        });
    </script>
@endsection



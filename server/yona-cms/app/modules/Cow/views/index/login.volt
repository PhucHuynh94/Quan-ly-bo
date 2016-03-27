<form class="ui form segment" method="post" action="{{ url.get() }}user/index/login">
    <h1>Đăng nhập vào ứng dụng</h1>
    {{ flash.output() }}
    <div class="required field">
        <label>Số điện thoại</label>
        <div class="ui icon input">
            {{ form.render('phoneNumber') }}
            <i class="user icon"></i>
        </div>
    </div>
    <div class="required field">
        <label>Mật khẩu</label>
        <div class="ui icon input">
            {{ form.render('password') }}
            <i class="lock icon"></i>
        </div>
    </div>
    <div class="ui error message">
        <div class="header">Errors</div>
    </div>
    <input type="hidden" name="{{ security.getTokenKey() }}"
           value="{{ security.getToken() }}"/>
    <input type="submit" id="submit" class="ui blue submit button" value="Log in">
</form>
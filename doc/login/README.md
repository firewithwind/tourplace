### login

用户**[登入](login_in)[登出](login_out)**

- <a name="login_in">登入</a>

        POST /tourplace/src/login.php
        to: {
          User_ID: #用户ID,
          User_Password: #用户密码
        }
        return：{
          Type: (0|1) #0-登入成功 1-登入失败
          Result: {
          }
        }
        Result <{
          {}#Type=0,successed,
          {
            Errmsg: #错误信息
          }#Type=1, failed
        }
- <a name="login_out">登出</a>
        DELETE /tourplace/src/login.php
        to: {
          Type(int): (0|1) 0-用户登出  1-管理员强制退出
          User_ID(string): #用户ID 当Type=0时，字段为空，表示用户自己退出
        }
        return： {
          Type: (0|1) 0-成功 1-失败
          Result: {
          }
        }
        esult <{
          {}#Type=0,successed,
          {
            Errmsg: #错误信息
          }#Type=1, failed
        }

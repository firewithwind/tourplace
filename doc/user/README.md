### user



用户**[增](user_add)[删](user_delete)[改](user_change)[查](user_search)**

- <a name="user_add">增</a>

      POST /tourplace/src/user.php
      to: {
        Type: (0|1) #增加方式， 0-普通用户注册  1-景区官方注册
        Data: {
          User_name: #用户昵称,
          Usee_Password: #用户密码,
          User_Intro: #用户简介，若未空，则为空字符串,
          User_Type: #用户类型，　0-普通用户　1-景区官方,
        }
      }
      Data <{
        {
          User_name: #用户昵称,
          Usee_Password: #用户密码,
          User_Intro: #用户简介，若未空，则为空字符串,
          User_Type: 0#用户类型，　0-普通用户,
        }#Type为0时，普通用户注册
        {
          User_name: #用户昵称,
          Usee_Password: #用户密码,
          User_Intro: #用户简介，若未空，则为空字符串,
          User_Type: 1#用户类型，　1-景区官方,
          Scenic_Name: #景区名称
          Scenic_License: #景区注册码
        }#Type为1时，景区官方注册
      }
      return:{
        Type: (0|1) #返回状态, 0-成功　1-失败
        Result: {

        }
      }
      Result <{
        {
          User_ID: # Type为0时，返回生成的用户ID
        }
        {
          Errmsg: #Type为１时，返回错误信息
        }
      }
- <a name="user_delete">删</a>

      DELETE /tourplace/src/user.php
      #只有管理员可以进行本操作
      to: {
        User_ID: #用户ID
      }
      return:{
        Type: (0|1) #返回状态, 0-成功　1-失败
        Result: {

        }
      }
      Result <{
        {
          User_ID: # Type为0时，返回删除的用户ＩＤ
        }
        {
          Errmsg: #Type为１时，返回错误信息
        }
      }

- <a name="user_change">改</a>

      PUT /tourplace/src/user.php
      #只有管理员和用户本身可以进行本操作
      to: {
        Type: (0|1) # 操作类型 0-用户本人操作 1-管理员操作
        User_ID: "" #当Type为0时此处允许为空，代表用户本身操作
        #每次更新都必须发送Update所有数据
        Update: {
          User_Name: #用户昵称
          User_Password: #用户密码
          User_Truename: #真实姓名
          User_Intro: #用户介绍
          User_Sex: #用户性别 0-男 1-女
          User_Phone: #用户电话
          User_Birthday: #用户生日（时间戳）
          User_IDCard: #用户身份证号
          User_Level: #用户信用等级
        }
      }
      return:{
        Type: (0|1) 0-成功 1-失败
        Result: {
        }
      }
      Result <{
        {

        },#成功 Type为0
        {
          Errmsg:
        }#失败信息 Type为1
      }
- <a name="user_search">查</a>

      GET /tourplace/src/user.php
      to: {
        Type(int): (0|1)#查找方式，具体开发决定
        Key(string): "User_ID+User_Name+..." #需要获取信息的关键字，
        Page(int): #页码
        PageSize(int): #每页信息数  
        Search(object): {
          User_ID: "id1"
        }
      }
      Search <{
        {
          User_ID: "id" #搜索用户的ID 若为空，则表示用户本身
        }#Type为0时，表示根据ID搜索
        {
          User_Name: "name" #搜索用户name  不允许为空
        }#Type为1时，表示根据昵称搜索
        {
          User_IDCard: "idcard" #根据用户IDCard搜索 不允许为空
        }#Type为2时，表示根据身份证搜索
        {
          Type： 0-搜索所有普通用户 1-搜索所有景区管理员 2-所有用户
        }#Type为3时，表示根据用户类型搜索
      }
      Key <{
        User_ID: #用户ID
        User_Name: #用户昵称
        User_Password: #用户密码
        User_Truename: #真实姓名
        User_Intro: #用户介绍
        User_Sex: #用户性别 0-男 1-女
        User_Phone: #用户电话
        User_Birthday: #用户生日（时间戳）
        User_IDCard: #用户身份证号
        User_Level: #用户信用等级
        User_Type: #用户类型
      }
      return: {
        Type(int): (0|1) # 0-成功 1-失败
        Num(int): #返回的信息数量
        Result(array): [
          {
            User_ID: 0#用户ID
            User_Name: #用户昵称
            User_Password: #用户密码
            User_Truename: #真实姓名
            User_Intro: #用户介绍
            User_Sex: #用户性别 0-男 1-女
            ...
          },
          {
            User_ID: 1#用户ID
            User_Name: #用户昵称
            User_Password: #用户密码
            User_Truename: #真实姓名
            User_Intro: #用户介绍
            User_Sex: #用户性别 0-男 1-女
            ...
          }
        ]
      }

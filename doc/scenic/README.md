### Scenic

景区**[增](scenic_add)[删](scenic_delete)[改](scenic_change)[查](scenic_search)**


- <a name="scenic_add">增</a>

      POST /tourplace/src/scenic.php
      #只有网站管理员可以进行本操作
      to:{
        Type(int): (0|)#添加方式，具体视情况而定
        Data(object): {
          Scenic_Name(string): #景区名称(要求景区注册名称)
          Scenic_Intro(string): #景区介绍,
          Province_ID: #省份ID
          City_ID: #城市ID,
          Scenic_Adress(string): #景区详细地址,
          Scenic_Phone(string): #景区联系方式,
          Scenic_Level(string): #景区水平,
          Scenic_License(string): #景区许可证
          Scenic_Picture(string url): #景区展示图片
		  Scenic_Vedio(string): #景区展示视频
		  Scenic_Type(int): #景区类型
        }
      }
      return: {
        Type(int): (0|1) 0-成功 1-失败
        Result(object):{

        }
      }
      Result <{
        {
          Scensic_ID(string): #景区ID
        }#Type=0 success
        {
          Errmsg(string): #错误信息
        }
      }


- <a name="scenic_delete">删</a>

      DELETE /tourplace/src/scenic.php
      #该操作只允许网站管理员操作
      to: {
        Type(int): (0|)删除方式
        Delete(object): {
          Scenic_ID(string): "id1+id2+..."#景区ID
        }
      }
      return: {
        Type: (0|1)0-成功 1-失败
        Result: {
        }
      }
      Result <{
        {
          Scensic_ID(string): #景区ID
        }#Type=0 success
        {
          Errmsg(string): #错误信息
        }
      }

- <a name="scenic_change">改</a>

      PUT /tourplace/src/scenic.php
      #该操作只允许景区管理员和网站管理员进行
      to: {
        Type: (0|) #修改方式，
        Scenic_ID(string): #景区ID
        Update: {
          Scenic_Name(string): #景区名称(要求景区注册名称)
          Scenic_Intro(string): #景区介绍,
          Province_ID: #省份ID
          City_ID: #城市ID,
          Scenic_Adress(string): #景区详细地址,
          Scenic_Phone(string): #景区联系方式,
          Scenic_Level(string): #景区水平,
          Scenic_License(string): #景区许可证
          Scenic_Picture(string url): #景区展示图片
		  Scenic_Vedio(string): #景区展示视频
		  Scenic_Type(int): #景区类型
        }#修改必须发送所有字段
      }
      return: {
        Type: (0|1) # 0-成功 1-失败
        Result: {}
      }
      Result <{
        {
        }#Type=0 success
        {
          Errmsg: #错误信息
        }#Type=1 fail
      }

- <a name="scenic_search">查</a>

      GET /tourplace/src/scenic.php
      to: {
        Type(int): (0|1)#查询方式,
        Keys(string): "Scenic_ID+Scenic_Name+Scenic_Intro+Scenic_Phone+..."#要求返回信息,
        Page(int): 1 #页码
        PageSize(int): 10
        Search: {
          Scenic_ID: #景区ID
        }
      }
      Keys <{
        Scenic_ID(string): #景区ID
        Scenic_Name(string): #景区名称(要求景区注册名称)
        Scenic_Intro(string): #景区介绍,
        Province_ID: #省份ID
        City_ID: #城市ID,
        Scenic_Adress(string): #景区详细地址,
        Scenic_Phone(string): #景区联系方式,
        Scenic_Level(string): #景区水平,
        Scenic_License(string): #景区许可证
        Scenic_Picture(string url): #景区展示图片
		Scenic_Vedio(string): #景区展示视频
		Scenic_Type(int): #景区类型
      }*   #若为空，则返回全部字段
      Search <{
        {
          Scenic_ID: #景区ID
        }Type为0时   根据景区ID查询，
        {
          Scenic_Name: #景区名称
        }Type为1时   根据景区名称查询
        {
          Scenic_License: #景区许可证
        }Type为2时    根据许可证查询
        {
          Province_ID: #省份ID
          City_ID: #城市ID
          Scenic_Level: #水平
		  Scenic_Type: #类型
        }Type为3时    根据条件查询 为空的字段表示查询該字段全部
      }
      return:{
        Type(int): (0|1)# 0-成功 1-失败
        Size(int): 10 #返回条数
        Result(array):{}
      }
      Result <{
        [
          {
            Scenic_ID(string): #景区ID
            Scenic_Name(string): #景区名称(要求景区注册名称)
            Scenic_Intro(string): #景区介绍,
            Province_ID: #省份ID
            City_ID: #城市ID,
            ...
          }
          {
            Scenic_ID(string): #景区ID
            Scenic_Name(string): #景区名称(要求景区注册名称)
            Scenic_Intro(string): #景区介绍,
            Province_ID: #省份ID
            City_ID: #城市ID,
            ...
          }
        ]#Type为0时,表示成功，返回信息
        {
          Errmsg: #错误信息
        }#Type为1时，表示失败，返回错误信息
      }
�功，返回信息
        {
          Errmsg: #错误信息
        }#Type为1时，表示失败，返回错误信息
      }

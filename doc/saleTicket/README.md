### saleTicket

售票**[增](sale_add)[删](sale_delete)[改](sale_change)[查](sale_search)**

- <a name="sale_add">增</a>

      POST /tourplace/src/saleTicket.php
      to: {
        Type(int): (0|1) #增加方式，
        Data(object): {
          Ticket_ID(string): #票ID,
          UserTicket_Count1: #未出售数量
        }
      }
      Data <{
        {
          Ticket_ID: #票ID,
          User_ID: #售票人ID
          Ticket_Type: 0 #此处固定为0 表示增加库存
          UserTicket_Count: #购买数量,
          UserTicket_Price: #购买价格
        }#Type为0,购票增加
        {
          Ticket_ID: #票ID,
          Ticket_Type: 1 #此处固定为1 表示增加售票
          UserTicket_Count: #售票数量，
          UserTicket_Price: #出售价格
        }Type为1时，售票增加
      }
      return: {
        Type: (0|1) 0-成功 1-失败
        Result: {}
      }
      Result <{
        {}#Type为0
        {
          Errmsg: #错误信息
        }#Type为1时
      }
- <a name="sale_delete">删</a>


- <a name="sale_change">改</a>

      PUT /tourplace/src/saleTicket.php
      #本操作只能票的拥有者更改
      to: {
        Type: (0|) #更改方式
        Update: {
          Ticket_ID: #票ID
          UserTicket_Type: #票当前状态,
          Target_Type: #目标状态,
          UserTicket_Count: #修改数量,
          UserTicket_Price: #修改价格,
        }#每次修改必须拥有全部字段
      }
      return: {
        Type: (0|1) #0-成功 1-失败
        Result: {

        }
      }
      Result <{
        {}#Type为0,成功
        {
          Errmsg: #错误信息
        }#Type为1，失败
      }

- <a name="sale_search">查</a>

      GET /tourplace/src/saleTicket.php
      to: {
        Type: (0|1) #查询方式
        Keys: "Ticket_ID+UserTicket_Price+..." #要求返回的信息
        Page: 0 #页码
        PageSize: 10 #页面信息数量
        Search: {

        }#辅助查询信息
      }
      Keys <{
        Ticket_ID: #票ID,
        Ticket_Picture: #票的图片
        UserTicket_Type: #票的状态 0-未出售  1-正在出售 2-已过期
        UserTicket_Price: #票价格，
        UserTicket_Count: #票数量，
        User_ID: #持票人信息，
        User_Name: #持票人昵称,
        Scenic_ID: #景区ID,
        Scenic_Name: #景区名称
      }*
      Search <{
        {
          Ticket_ID: #票ID 若未空 则搜索此人拥有的全部票
          Ticket_Type: #票种类  若未空  则返回全部种类
        }#Type 为0时 表示用户查看自己仓库
        {
          User_ID: #用户ID 若未空 则返回全部用户
          Ticket_ID: #票ID 若未空  则返回此ID全部表
          Scenic_ID: #景区ID 若未空  则返回全部景区
          Ticket_Type: #门票类型 若未空  则返回全部类型
        }#Type为1时，查看其他人票务信息
      }
      return: {
        Type: (0|1) 0-成功 1-失败
        Num: #返回信息数量
        Result:{

        }
      }
      Result <{
        [
          {
            Ticket_ID: #票ID,
            Ticket_Picture: #票的图片
            UserTicket_Type: #票的状态 0-未出售  1-正在出售 2-已过期
            UserTicket_Price: #票价格，
            UserTicket_Count: #票数量，
            ...
          }
          {
            Ticket_ID: #票ID,
            Ticket_Picture: #票的图片
            UserTicket_Type: #票的状态 0-未出售  1-正在出售 2-已过期
            UserTicket_Price: #票价格，
            UserTicket_Count: #票数量，
            ...
          }
        ],#Type为0 成功  返回数组信息
        {
          Errmsg: #错误信息
        }#Type为1时，返回错误信息
      }

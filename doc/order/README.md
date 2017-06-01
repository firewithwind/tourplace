### Order


order**[增](order_add)[删](order_delete)[改](order_change)[查](order_search)**


- <a name="order_add">增</a>

      POST /tourplace/src/order.php
      #用户购买时会产生订单
      to: {
        User_ID2: 卖家ID,
        Ticket_ID: 票的ID,
        Order_Time: 交易时间，
        Order_Count: 购买数量
      }
      #买家ID不会发送,存储时要自动生成order表里面的其他内容
      return: {
        Type: （0|1）#0-成功 1-失败
        Result: {

        }
      }
      Result <{
        {
          Order_ID: #订单id，
        }#Type=0,成功时，返回订单id   只有当数据库事物完成时才算成功(购买成功时需要同时对两个user的仓库进行调整)
        {
          Errmsg: #错误信息
        }#Type=1,失败时，返回失败信息
      }

- <a name="order_delete">删</a>

      DELETE /tourplace/src/order.php
      #用户删除订单
      to: {
        Order_ID: #订单id，若为空，则清空本人所有订单
      }
      return: {
        {
        }#Type=0,成功
        {
          Errmsg: #错误信息
        }#Type=1,失败时，返回失败信息
      }
- <a name="order_change">改</a>

      PUT /tourplace/src/order.php
      #订单状态变更
      to: {
	    Order_ID #订单ID，不能为空
        Order_State: #订单状态，不能为空
      }
      return: {
        {
        }#Type=0,成功
        {
          Errmsg: #错误信息
        }#Type=1,失败时，返回失败信息
      }

- <a name="order_search">查</a>

      GET /tourplace/src/order.php
      to: {
        Type: (0|)#查询方式
        Keys: "Uer_ID1+User_ID2+Order_ID+..." #查询的信息
        Page: #查询页码
        PageSize: #每页的信息数量
        Search: {
          User_ID: id1+id2+id3
        }
      }
      Keys <{
        User_ID1: #买家ID,
        User_ID2: #卖家ID,
        User_Name2: #买家昵称,
        User_Name1: #买家昵称，
        Order_ID: #订单id,
        Order_Count: #订单数量，
        Ticket_ID: #门票ID,
        Scenic_ID: #对应景区Id,
        Scenic_Name: #对应景区名称
      }* #若为空，则返回該字段的所有信息
      Search  <{
        {
          Order_ID: #订单Id 若为空，返回全部订单
        }#Type = 0
        {
          User_ID: #买家ID 若未空，返回用户本身订单
        }#Type = 1
		{
          Order_State: #订单状态 若未空，返回当前用户所有状态订单
        }#Type = 2
      }
      return: {
        Type： （0|1）#0-成功 1-失败
        Size: #返回条数
        Result: {}
      }
      Result <{
        [
          {
            User_ID1: #买家ID,
            User_ID2: #卖家ID,
            User_Name2: #买家昵称,
            User_Name1: #买家昵称，
            Order_ID: #订单id,
            Order_Count: #订单数量，
            ...
          },
          {
            User_ID1: #买家ID,
            User_ID2: #卖家ID,
            User_Name2: #买家昵称,
            User_Name1: #买家昵称，
            Order_ID: #订单id,
            Order_Count: #订单数量，
            ...
          }
        ]#Type = 0成功,
        {
          Errmsg: #错误信息
        }#Type =  1失败
      }

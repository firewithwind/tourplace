###ticket


门票**[增](ticket_add)[删](ticket_delete)[改](ticket_change)[查](ticket_search)**

- <a name="ticket_add">增</a>

        POST /tourplace/src/ticket.php
        #只允许景区管理员进行本操作，进行景区的票的管理
        to: {
          Type: (0|1)#增加方式，
          Data: {
            Scenic_ID(string): #对应景区，
            Ticket_Time(string 时间戳): #时间
          }
        }
        return: {
          Type(int): (0|1)#0-成功 1-失败,
          Result(object): {

          }
        }
        Result <{
          {}#Type为0
          {
            Errmsg: #错误信息
          }#Type为1时
        }
- <a name="ticket_delete">删</a>

          DELETE /tourplace/src/ticket.php
          #只允许景区管理员和网站管理员进行本操作，进行景区的票的管理
          to: {
            Type(int): (0|1)#删除方式
            Data(object): {
              Ticket_ID(string): #票ID
            }
          }
          Data <{
            {
              Ticket_ID(string): #票ID
            }#Type为0时,根据ID删除，
            {
              Scenic_ID(string): #景区ID
              Ticket_Time(string 时间戳): #票时间，若为空，则删除全部时间段
            }#Type为1时，根据景区和时间删除
          }
- <a name="ticket_change">查</a>

          GET /tourplace/src/ticket.php
          to: {
            Type(int): (0|1)#查询票,
            Keys(string): "Ticket_ID+Scenic_ID+Ticket_Time+Scenic_Name+Ticket_Picture",#查询关键字，需要返回的信息，若为空则返回这些字段，
            Page: 1 #页码
            PageSize: 10 #页面数据条数
            Search(object): {
              Ticket_ID(string): #门票ID
            }#辅助查找的信息
          }
          Keys(string) <{
            "Ticket_ID",
            "Scenic_ID",
            "Ticket_Time",
            "Ticket_Picture",
            "Scenic_Name",
            "User_ID",
            "User_Name"
          }*    #若为空则返回全部
          Search <{
            {
              Ticket_ID: #门票ID 若为空则返回全部门票信息
            }#Type为0时，根据门票ID查找，
            {
              Scenic_ID(string): #景区ID
              Ticket_Time(string): #时间 若为空则查找全部时间段
            }#Type为1时，根据景区ID和时间查找，
            {
              Ticket_Name(string): #景区名称
              Ticket_Time(string): #时间 若为空 则查找全部时间段
            }#Type为2时，根据景区名称和时间查找
          }
          return： {
            Type(int): (0|1) #0-成功 1-失败,
            Num(int): #查询到的信息数量
            Result(array): [
              {}
            ]
          }
          Result <{
            [
              {
                Ticket_ID: #门票id,
                Scenic_ID: #景区id ,
                Ticket_Time: #有效时间,
                ...
              },
              {
                Ticket_ID: #门票id,
                Scenic_ID: #景区id ,
                Ticket_Time: #有效时间,
                ...
              }
            ]#Type为0时,查询成功，返回信息,
            {
              Errmsg: #错误信息
            }#Type为1时,查询失败，返回错误信息
          }

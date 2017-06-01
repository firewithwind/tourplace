### login

省**[增](add)[删](delete)[查](search)**

- <a name="add">增</a>

        POST /tourplace/src/province.php
        to: {
          Province_Name: #省名称
        }
        return：{
          Type: (0|1)
          Result: {
          }
        }
        Result <{
          {
		    Province_ID: #生成的省的ID
		  }#Type=0,successed,
          {
            Errmsg: #错误信息
          }#Type=1, failed
        }
- <a name="delete">删</a>

        DELETE /tourplace/src/province.php
        to: {
          Type: (0|1) 0-按ID 1-名称
		  delete: {
		    Province_ID: #省的ID
		  }
        }
		delete <{
		  {
		    Province_ID: #省的ID
		  }#Type为0时，按省的ID删除
		  {
		    Province_Name: #省的名称
		  }#Type为1时，按省的名称删除
		}
        return： {
          Type: (0|1) 0-成功 1-失败
          Result: {
          }
        }
        result <{
          {}#Type=0,successed,
          {
            Errmsg: #错误信息
          }#Type=1, failed
        }
		
- <a name="search">查</a>

        GET /tourplace/src/province.php
        to: {
          Type: (0|1) 0-按ID 1-名称
		  Page(int): #页码
		  PageSize(int): #每页信息数
		  Search: {
		    Province_ID: #省的ID
		  }
        }
		Search <{
		  {
		    Province_ID: #省的ID  若为空，查看所有
		  }#Type为0时，按省的ID查找
		  {
		    Province_Name: #省的名称  若为空，查看所有
		  }#Type为1时，按省的名称查找
		}
        return： {
          Type: (0|1) 0-成功 1-失败
          Num(int): #返回的信息数量
		  Result(array): {
		    {
			  Province_ID
			  Province_Name
			}
			{
			  Province_ID
			  Province_Name
			}
          }
        }

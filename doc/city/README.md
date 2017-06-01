### login

城市**[增](add)[删](delete)[查](search)**

- <a name="add">增</a>

        POST /tourplace/src/city.php
        to: {
		  Province_ID: #所在省的ID
          City_Name: #城市名称
        }
        return：{
          Type: (0|1)
          Result: {
          }
        }
        Result <{
          {
		    City_ID: #生成的城市的ID
		  }#Type=0,successed,
          {
            Errmsg: #错误信息
          }#Type=1, failed
        }
- <a name="delete">删</a>

        DELETE /tourplace/src/city.php
        to: {
          Type: (0|1) 0-按ID 1-按名称 2-按省
		  delete: {
		    City_ID: #城市的ID
		  }
        }
		delete <{
		  {
		    City_ID: #城市的ID
		  }#Type为0时，按城市的ID删除
		  {
		    City_Name: #城市的名称
		  }#Type为1时，按城市的名称删除
		  {
		    Province_ID: #所在省的名称
		  }#Type为2时，删除该省所有城市
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

        GET /tourplace/src/city.php
        to: {
          Type: (0|1) 0-按ID 1-名称 2-按省
		  Page(int): #页码
		  PageSize(int): #每页信息数
		  Search: {
		    City_ID: #省的ID
		  }
        }
		Search <{
		  {
		    City_ID: #城市的ID  若为空，查看所有
		  }#Type为0时，按城市的ID查找
		  {
		    City_Name: #城市的名称  若为空，查看所有
		  }#Type为1时，按城市的名称查找
		  {
		    Province_ID: #省的ID  若为空，查看所有
		  }#Type为2时，按所在省的ID查找
		}
        return： {
          Type: (0|1) 0-成功 1-失败
          Num(int): #返回的信息数量
		  Result(array): {
		    {
			  City_ID
			  City_Name
			  Province_ID
			}
			{
			  City_ID
			  City_Name
			  Province_ID
			}
          }
        }

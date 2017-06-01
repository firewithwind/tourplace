1. <a name='province'></a> **省份[增](#province_add)、[删](#province_delete)、[改](#province_change)、[查](#province_search)**
	- <a name="province_add">增</a>

			POST /yora/src/v1/place/province.php
			#只有管理员有权限操作
			to:{
				Province_Name:#省份名称
			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				Province_Id:#省份Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Errmsg:#出错原因
			}

	- <a name="province_delete">删</a>

	- <a name="province_change">改</a>

	- <a name="province_search">查</a>  

			GET /yora/src/v1/place/province.php
			to:{
				Type：（0|1|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+Name+Citys...',#需要获取的属性名，每个属性之间用'+'隔开
				Page:1,#当前页数，（可选，Page和PageSize必须同时存在）
				PageSize：10，#每页数据条数（可选，Page和PageSize必须同时存在）
				Search:{
					Province_ID:'1',#搜索记录Id，若为空则搜索全部记录
				}
			}

			Search∈{
				{
					Provnice_ID:'1',#搜索记录Id，若为空则则搜索全部记录
				},#Type为0时
				{
					Provnice_Name:1,#省份名称
				},#Type为1时
			}
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Province_ID(int): ,#省份Id
				Province_Name(string), #姓名
				Citys(arr,json)：[
					{
						City_ID(int)：该省城市1id，
						City_Name(string)：城市名称
					}，
					{
						City_Id(int)：该省城市2id，
						City_Name(string)：城市名称
					}，
					...
				],
				CitysId(arr,int)：[id1,id2,id3,...],该省城市id
			}

			#正确返回时状态码为200
			return{
				Total：10,#未分页时搜索到总数据条数，当Page和PageSize不存在时就是ResultList的长度
				ResultList[
					{
						Id:,
						Name:,
						Citys:,
						...
					},
					{
						Id:,
						Name:,
						Citys:,
						...
					},
					...
				]

			}

			错误时除返回码还要返回错误信息
			return{
				Errmsg:'错误信息'
			}

			错误码：
				401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
				403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。
				404 NOT FOUND - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作，该操作是幂等的。
				406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。
				410 Gone -[GET]：用户请求的资源被永久删除，且不会再得到的。
				500 INTERNAL SERVER ERROR - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。
1. <a name='city'></a> **城市[增](#city_add)、[删](#city_delete)、[改](#city_change)、[查](#city_search)**
	- <a name="city_add">增</a>

			POST /yora/src/v1/place/city.php
			#只有管理员有权限操作
			to:{
				Province_ID：#所属省份Id
				City_Name:#城市名称
			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				City_ID:#城市Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Errmsg:#出错原因
			}

			401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
			422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	- <a name="city_delete">删</a>

	- <a name="city_change">改</a>

	- <a name="city_search">查</a>  

			GET /yora/src/v1/place/city.php
			to:{
				Type：（0|1|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+SchoolsId+ProvinceId...',#需要获取的属性名，每个属性之间用'+'隔开
				Page:1,#当前页数，（可选，Page和PageSize必须同时存在）
				PageSize：10，#每页数据条数（可选，Page和PageSize必须同时存在）
				Search:{
					City_ID:'1',#搜索记录Id，若为空则搜索全部记录
				}
			}

			Search∈{
				{
					City_ID:'1',#搜索记录Id，若为空则则搜索全部记录
				},#Type为0时
				{
					City_Name, #城市名称					
					Province_ID：所属省份Id
				},#Type为1时
			}

			Keys∈{
				City_ID(int): ,#城市Id
				City_Name(string), #城市名称
				ProvinceId(int)：所属省份Id
			}

			#正确返回时状态码为200
			return{
				Total：10,#未分页时搜索到总数据条数，当Page和PageSize不存在时就是ResultList的长度
				ResultList[
					{
						Id:,
						ProvinceId:,
						...
					},
					{
						Id:,
						ProvinceId:,
						...
					},
					...
				]

			}

			错误时除返回码还要返回错误信息
			return{
				Errmsg:'错误信息'
			}

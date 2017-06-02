new Vue({
  el: '#container',
  data: {
    location: '全国',
    placeSelect: false,
    places: [
    ],
    userID: '',
    user: '请登入',
    userPicture: '/tourplace/img/user/00.jpg',
    Scenic: {},
    ScenicID: '',
    ScenicEnglishName: '',
    tickets: [],
    Order_Count: 1,
    showbuy: 0,
    buyIndex: 0,
    maxCount: 0,
    searchInfor: '',
  },
  methods: {
    init: function(){
      var self = this
      self.getUser()
      self.ScenicID = self.getQueryString("id")
      if(self.ScenicID == ''){
        alert("没有該景区")
      }else{
        $.get('/tourplace/src/scenic.php',{
          Type: 0,
          Keys: "Scenic_Name+Scenic_Adress+Scenic_Phone+Scenic_Level+Scenic_Picture+Scenic_Intro+Scenic_Vedio",
          Page: 1,
          PageSize: 1,
          Search:{
            Scenic_ID: self.ScenicID
          }
        })
        .done(function(response){
          var res = JSON.parse(response)
          if(res.Type == 0){
            self.Scenic = res.Result[0]
          }else{
            alert("出错了：" + res.Result.Errmsg)
          }
        })
        .fail(function(){
          alert("出现了未知的错误")
        })
        $.get('/tourplace/src/saleTicket.php',{
          Type: 1,
          Keys: 'Ticket_ID+Ticket_Time+Ticket_Picture+User_ID+User_Name+UserTicket_Price+UserTicket_Count+User_Picture+User_Phone',
          Page: 1,
          PageSize: 0,
          Search: {
            User_ID: '',
            Ticket_ID: '',
            Scenic_ID: self.ScenicID,
            Ticket_Type: 1
          }
        })
        .done(function(response){
          var res = JSON.parse(response)
          if(res.Type == 0){
            self.tickets = res.Result
            for(var i in self.tickets){
              self.tickets[i].salerShow = 0
            }
          }else{
            alert("出错了:"+res.Result.Errmsg)
          }
        })
        .fail(function(){
          alert("发生了未知的错误")
        })
      }
    },
    find: function(){
      var self = this
      var reg = new RegExp("[0-9]{8}")
      if(reg.test(self.searchInfor)){
        window.location = "/tourplace/components/content/userother/userother.html?id="+self.searchInfor+"&card=1"
      }else{
        $.get('/tourplace/src/scenic.php',{
          Type: 1,
          Keys: "Scenic_ID",
          Page: 1,
          PageSize: 1,
          Search: {
            Scenic_Name: self.searchInfor
          }
        })
        .done(function(response){
          var res = JSON.parse(response)
          if(res.Type == 0){
            window.location= "/tourplace/components/content/scenic/scenic.html?id="+res.Result[0].Scenic_ID
          }else{
            alert(res.Result.Errmsg)
          }
        })
        .fail(function(){
          alert("搜索信息有误")
        })
      }
    },
    loginORuser(){
      var self = this
      if(self.userID == ""){
        window.location = '/tourplace/components/content/login/login.html'
      }else{
        window.location = '/tourplace/components/content/user/user.html?id='+self.userID+'&card=1'
      }
    },
    getQueryString(name){
      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
      var r = window.location.search.substr(1).match(reg);
      if (r != null) return unescape(r[2])
      return ''
    },
    getUser: function(){
      var self = this
      $.get('/tourplace/src/user.php',{
        Type: 0,
        Key: 'User_ID+User_Name+User_Picture',
        Page: 1,
        PageSize: 1,
        Search: {
          User_ID: ''
        }
      })
      .done(function(response){
        res = JSON.parse(response)
        if(res.Type == 0){
          self.user = res.Result[0].User_Name
          self.userID = res.Result[0].User_ID
          self.userPicture = res.Result[0].User_Picture
        }else{
          alert("出错了" + res.Result.Errmsg)
        }
      })
      .fail(function(response){
        alert("发生了未知的错误")
      })
    },
    addOrder: function(){
      var self = this
      var id = self.tickets[self.buyIndex].Ticket_ID
      var UserID = self.tickets[self.buyIndex].User_ID
      var price = self.tickets[self.buyIndex].UserTicket_Price
      var date = new Date()
      var y = date.getFullYear()
      var m = date.getMonth()
      var d = date.getDate()
      $.ajax({
        url: '/tourplace/src/order.php',
        type: 'POST',
        data:{
          User_ID2: UserID,
          Ticket_ID: id,
          Order_Time: y+'/'+m+'/'+d,
          Order_Count: self.Order_Count,
          Order_Price: price
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          alert("下单成功，可去我的订单中查看或支付")
        }else{
          alert("出错了: " + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    loginOut: function(){
      $.ajax({
          url: '/tourplace/src/login.php',
          type: 'DELETE',
          data: {
            Type: 0,
            User_ID: ''
          }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          window.location = '/tourplace/components/content/login/login.html'
        }else{
          alert(res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("注销失败 ，请检查网络设置")
      })
    }
  },
  mounted: function(){
    this.init()
  }
})

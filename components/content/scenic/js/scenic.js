new Vue({
  el: '#container',
  data: {
    location: '全国',
    placeSelect: false,
    places: [
    ],
    user: '请登入',
    Scenic: {},
    ScenicID: '',
    ScenicEnglishName: '',
    tickets: [],
    Order_Count: 1
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
          Keys: "Scenic_Name+Scenic_Adress+Scenic_Phone+Scenic_Level+Scenic_Picture+Scenic_Intro",
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
              self.tickets[i].buy = 0
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
    getQueryString(name){
      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
      var r = window.location.search.substr(1).match(reg);
      if (r != null) return unescape(r[2])
      return ''
    },
    getUser: function(){
      $.get('/tourplace/src/user.php',{
        Type: 0,
        Key: 'User_Name',
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
        }else{
          alert("出错了" + res.Result.Errmsg)
        }
      })
      .fail(function(response){
        alert("发生了未知的错误")
      })
    },
    addOrder: function(id, UserID){
      var self = this
      $.ajax({
        url: '/tourplace/src/order.php',
        type: 'POST',
        data:{
          User_ID2: UserID,
          Ticket_ID: id,
          Order_Time: '',
          Order_Count: self.Order_Count
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          alert("下单成功，可取我的订单中查看或支付")
        }else{
          alert("出错了: " + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    }
  },
  mounted: function(){
    this.init()
  }
})

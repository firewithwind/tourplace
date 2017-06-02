new Vue({
  el: '#container',
  data: {
    nowCard: 1  ,
    user: {
      User_Type: 1
    },
    touxiang: '',
    addTicket: 0,
    ticketType: 0,
    Scenic: {},
  },
  methods: {
    init: function(){
      this.nowCard = this.getQueryString("card")
      var self = this
      $.get('/tourplace/src/user.php',{
        Type: 0,
        Key: "",
        Page: 1,
        PageSize: 1,
        mine: {

        },
        Search:{
          User_ID: id
        }
      })
      .done(function(response){
        res = JSON.parse(response)
        if(res.Type == 0){
          self.user = res.Result[0]
        }else{
          alert("出错了：" + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
      $.get('/tourplace/src/user.php',{
        Type: 0,
        Key: "User_Name+User_Picture",
        Page: 1,
        PageSize: 1,
        Search:{
          User_ID: ''
        }
      })
      .done(function(response){
        res = JSON.parse(response)
        if(res.Type == 0){
          self.mine = res.Result[0]
        }else{
          alert("出错了：" + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getQueryString(name){
      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
      var r = window.location.search.substr(1).match(reg);
      if (r != null) return unescape(r[2])
      return ''
    },
    getTicket: function(type){
      var self = this
      $.get('/tourplace/src/saleTicket.php',{
        Type: 0,
        Keys: "Ticket_ID+Ticket_Picture+UserTicket_Price+UserTicket_Count+Ticket_Time+Scenic_Name",
        Page: 1,
        PageSize: 0,
        Search: {
          Ticket_ID: self.user.User_ID,
          Ticket_Type: type
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.tickets = res.Result
          for(var key in self.tickets){
            key.change = 0
          }
        }else{
          alert("出错了： " + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getScenic: function(){
      var self = this
      $.get('/tourplace/src/scenic.php',{
        Type: 4,
        Keys: "Scenic_ID+Scenic_Name+Scenic_Level+Scenic_License+Scenic_Adress+Scenic_Phone+Scenic_Picture+Scenic_Intro+Scenic_Vedio+Scenic_Type",
        Page: 1,
        PageSize: 1,
        Search: {
          User_ID: slef.user.User_ID
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.Scenic = res.Result[0]
        }else{
          alert("出错了： "+ res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    }
  },
  mounted: function(){
    this.user.User_ID = this.getQueryString("id")
    this.init()
  }
})

new Vue({
  el: '#container',
  data: {
    nowCard: 4,
    user: {
      User_Type: 1
    },
    touxiang: '',
    orderType: 1,
    orders:[],
    addTicket: 0,
    ticketType: 0,
    tickets:[
    ],
    Scenic: {},
    newTicketTime: '',
    newTicket_Pic: '',
    ticketPicture: {}
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
        Search:{
          User_ID: ''
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
    },
    getQueryString(name){
      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
      var r = window.location.search.substr(1).match(reg);
      if (r != null) return unescape(r[2])
      return ''
    },
    changeUserPicture: function(docu){
      var file = $("#touxiang")[0].files[0]
      this.user.User_Picture = window.URL.createObjectURL(file)
      this.touxiang = file
    },
    addTicketPicture: function(){
      var file = $("#newTicket")[0].files[0]
      this.newTicket_Pic = window.URL.createObjectURL(file)
      this.ticketPicture = file
    },
    editUser: function(){
      var user = this.user
      var self = this
      $.ajax({
        url: '/tourplace/src/user.php',
        type: 'PUT',
        data: {
          Type: 0,
          User_ID: '',
          Update: {
            User_Name: self.user.User_Name,
            User_Password: self.user.User_Password,
            User_Truename: self.user.User_Truename,
            User_Intro: self.user.User_Intro,
            User_Sex: self.user.User_Sex,
            User_Phone: self.user.User_Phone,
            User_Birthday: self.user.User_Birthday,
            User_IDcard: self.user.User_IDcard,
            User_Level: self.user.User_Level,
            User_File: self.touxiang
          }
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          alert("修改成功")
          self.init()
        }else{
          alert("出错了: " + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getOrder: function(type){
      $.get('/tourplace/src/order.php',{
        Type: 2,
        Keys: "Order_ID+Scenic_Name+Ticket_Time+Order_Time+Order_State",
        Page: 1,
        PageSize: 0,
        Search: {
          Order_State: type
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.orders = res.Result
        }else{
          alert("出错了："+res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    payOrder: function(id){
      var self = this
      $.ajax({
        url: '/tourplace/src/order.php',
        type: 'PUT',
        data:{
          Order_ID: id,
          Order_State: 1
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          alert("支付成功")
          self.getOrder(0)
        }else{
          alert("出错了："+res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getTicket: function(type){
      var self = this
      $.get('/tourplace/src/saleTicket.php',{
        Type: 0,
        Keys: "Ticket_ID+Ticket_Picture+UserTicket_Price+UserTicket_Count+Ticket_Time+Scenic_Name",
        Page: 1,
        PageSize: 0,
        Search: {
          Ticket_ID: '',
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
    changeTicket: function(ticketype,id,price){
      var self = this
      $.ajax({
        url: '/tourplace/src/saleTicket.php',
        type: 'PUT',
        data: {
          Type: 0,
          Update: {
            Ticket_ID: id,
            UserTicket_Type: 1-ticketype,
            Target_Type: ticketype,
            UserTicket_Count: self.changeCount,
            UserTicket_Price: price
          }
        }
      })
    },
    deleteTicket: function(id){

    },
    getScenic: function(){
      var self = this
      $.get('/tourplace/src/scenic.php',{
        Type: 4,
        Keys: "Scenic_ID+Scenic_Name+Scenic_Level+Scenic_License+Scenic_Adress+Scenic_Phone+Scenic_Picture+Scenic_Intro+Scenic_Vedio+Scenic_Type",
        Page: 1,
        PageSize: 1,
        Search: {
          User_ID: ''
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
    },
    addNewTicket(){
      var self = this
      $.ajax({
        url: '/tourplace/src/ticket.php',
        type: 'POST',
        data: {
          Type: 0,
          Data: {
            Scenic_ID: self.Scenic.Scenic_ID,
            Ticket_Time: self.newTicketTime,
            Ticket_Picture: self.ticketPicture
          }
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.addUserTicket(res.Result.Ticket_ID)
        }else{
          alert("出错了： " + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    addUserTicket:function(id){
      var self = this
      $.ajax({
        Type: 0,
        Data: {
          Ticket_ID: id,
          User_ID: user.User_ID,
          Ticket_Type: 0,
          UserTicket_Count: 999999,
          UserTicket_Price: 0,
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          alert("添加成功")
        }else{
          alert("出错了：" + res.Resulst.Errmsg)
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

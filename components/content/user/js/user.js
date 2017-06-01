new Vue({
  el: '#container',
  data: {
    nowCard: 1,
    user: {},
    orderType: 1
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
    editUser: function(){
      var user = this.user
      $.agax({
        url: '/tourplace/src/user.php',
        type: 'PUT',
        data: {
          Type: 0,
          User_ID: '',
          Update: {
            User_Name: user.User_Name,
            User_Password: user.User_Password,
            User_Truename: user.User_Truename,
            User_Intro: user.User_Intro,
            User_Sex: user.User_Sex,
            User_Phone: user.User_Phone,
            User_Birthday: user.User_Birthday,
            User_IDCard: user.User_IDCard,
            User_Level: user.User_Level
          }
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          alert("修改成功")
        }else{
          alert("出错了: " + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getOrder: function(){

    }
  },
  mounted: function(){
    this.user.User_ID = this.getQueryString("id")
    this.init()
  }
})

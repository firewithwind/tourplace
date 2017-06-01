new Vue({
  el: '#container',
  data: {
    nowCard: 1,
    user: {
      User_Name: '小小濠',
      User_ID: ''
    },
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
    }
  },
  mounted: function(){
    this.user.User_ID = this.getQueryString("id")
    this.init()
  }
})

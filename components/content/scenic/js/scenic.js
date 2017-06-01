new Vue({
  el: '#container',
  data: {
    location: '全国',
    placeSelect: false,
    places: [
    ],
    user: '请登入',
    Scenic: {
      Scenic_Name: '泰山风景名胜区',
      Scenic_Phone: '11111111',
      Scenic_Level: '5A',
      Scenic_Adress: '山东省泰安市',
      Scenic_Intro: '泰山风景名胜区（Mount tai scenic spot）：世界自然与文化遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国重点文物保护单位，中华国山，中国非物质文化遗产，全国文明风景旅游区，中国书法第一山。',
      Scenic_Picture: ''
    },
    ScenicID: '',
    ScenicEnglishName: 'Mount tai scenic spot',
    tickets: []
  },
  methods: {
    init: function(){
      var self = this
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
            Scenic_ID: ScenicID
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
              i.salerShow = 0
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
    }
  },
  mounted: function(){
    this.init()
  }
})

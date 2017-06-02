new Vue({
  el: '#container',
  data: {
    location: '全国',
    locatProID: '',
    locatCitID: '',
    placeSelect: false,
    searchInfor: '',
    places: [],
    nowPage: 1,
    active: 'active',
    unactive: '',
    showPic: 0,
    user: '请登入',
    scenicNum: 0,
    userID: '',
    userPicture: '/tourplace/img/user/00.jpg',
    scenicLevel: '',
    locationScenics: [],
    locationScenicUrls:[],
    ScenicVedios: [],
    todayScenics: [],
    interScenics: [],
    ScenicList: [],
    scenicType: 0,
    ScenicListUrls: []
  },
  methods: {
    init(){
      this.getPlace()
      this.getLocationScenic()
      this.getScenicVedio()
      this.getTodayScenic()
      this.getInterScenic()
    },
    gotolast: function(){
      if(this.showPic === 0){
        this.showPic = 4
      }else{
        this.showPic -= 1
      }
    },
    gotonext: function(){
      if(this.showPic === 4){
        this.showPic = 0
      }else{
        this.showPic += 1
      }
    },
    getQueryString(name){
      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
      var r = window.location.search.substr(1).match(reg);
      if (r != null) return unescape(r[2])
      return ''
    },
    changeProvince(id,name){
      this.locatProID = id
      this.location = name
      this.locatCitID = ''
      if(this.nowPage == 1){
        this.getLocationScenic()
      }else if(this.nowPage == 2){
        this.getScenicList(1)
      }
    },
    changeCity(id,name,proID){
      this.locatCitID = id
      this.location = name
      this.locatProID = proID
      if(this.nowPage == 1){
        this.getLocationScenic()
      }else if(this.nowPage == 2){
        this.getScenicList(1)
      }
    },
    getLocationScenic(){
      var self = this
      self.locationScenicUrls = []
      $.get('/tourplace/src/scenic.php',{
        Type: 3,
        Keys: "Scenic_ID+Scenic_Name+Scenic_Picture",
        Page: 1,
        PageSize: 8,
        Search: {
          Province_ID: self.locatProID,
          City_ID: self.locatCitID,
          Scenic_Level: ''
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.locationScenics = res.Result
          for(var key in self.locationScenics){
            self.locationScenicUrls.push('/tourplace/components/content/scenic/scenic.html?id=' + self.locationScenics[key].Scenic_ID)
          }
        }else{
          alert("出错了"+res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getScenicVedio(){
      var self = this
      $.get('/tourplace/src/scenic.php',{
        Type: 0,
        Keys: "Scenic_ID+Scenic_Name+Scenic_Picture+Scenic_Vedio",
        Page: 2,
        PageSize: 8,
        Search: {
          Scenic_ID: ''
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.ScenicVedios = res.Result
        }else{
          alert("出错了"+res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getTodayScenic(){
      var self = this
      $.get('/tourplace/src/scenic.php',{
        Type: 0,
        Keys: "Scenic_ID+Scenic_Name+Scenic_Picture",
        Page: 1,
        PageSize: 10,
        Search: {
          Scenic_ID: ''
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.todayScenics = res.Result
        }else{
          alert("出错了"+res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getInterScenic(){
      var self = this
      $.get('/tourplace/src/scenic.php',{
        Type: 3,
        Keys: "Scenic_ID+Scenic_Name+Scenic_Picture+Scenic_Intro",
        Page: 1,
        PageSize: 10,
        Search: {
          Province_ID: '',
          City_ID: '',
          Scenic_Level: '',
          Scenic_Type: 8
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.interScenics = res.Result
        }else{
          alert("出错了"+res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getScenicList(page){
      var self = this
      $.get('/tourplace/src/scenic.php',{
        Type: 3,
        Keys: "Scenic_ID+Scenic_Name+Scenic_Picture",
        Page: page,
        PageSize: 10,
        Search: {
          Province_ID: self.locatProID,
          City_ID: self.locatCitID,
          Scenic_Level: self.scenicLevel,
          Scenic_Type: self.scenicType
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        self.ScenicListUrls = []
        if(res.Type == 0){
          self.scenicNum = res.sumSize
          self.ScenicList = res.Result
          for(var i in res.Result){
            self.ScenicListUrls.push('/tourplace/components/content/scenic/scenic.html?id=' + self.ScenicList[i].Scenic_ID)
          }
        }else{
          alert("出错了"+res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    getPlace: function(){
      var self = this
      $.get('/tourplace/src/province.php',{
        Type: 0,
        Keys: 'Province_ID+Province_Name+Citys',
        Page: 1,
        PageSize: 0,
        Search: {
          Province_ID: ''
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.places = res.Result
          self.places.unshift({
            Province_ID: '',
            Province_Name: '全国',
            Citys: []
          })
        }else{
          alert("出错了+ " + res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
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
    var self = this
    setInterval(function(){
      self.gotonext()
    },6000)
    self.init()
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
        self.userID = res.Result[0].User_ID
        self.user = res.Result[0].User_Name
        self.userPicture = res.Result[0].User_Picture
      }else{
        alert("出错了" + res.Result.Errmsg)
      }
    })
    .fail(function(response){
      alert("发生了未知的错误")
    })
  }
})

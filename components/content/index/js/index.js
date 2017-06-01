new Vue({
  el: '#container',
  data: {
    location: '全国',
    locatProID: '',
    locatCitID: '',
    placeSelect: false,
    searchInfor: '',
    places: [
      {
        provinceID: 1,
        provinceName: '山东',
        citys: [
          {
            cityID: 1,
            cityName: '济南'
          },
          {
            cityID: 2,
            cityName: '青岛'
          },
          {
            cityID: 3,
            cityName: '威海'
          }
        ]
      },
      {
        provinceID: 2,
        provinceName: '北京',
        citys: [
          {
            cityID: 1,
            cityName: '北京'
          }
        ]
      }
    ],
    nowPage: 1,
    active: 'active',
    unactive: '',
    showPic: 0,
    user: '请登入',
    scenicNum: 0,
    userID: '',
    scenicLevel: '',
    locationScenics: [
      {
        Scenic_Name: '泰山旅游景区',
        Scenic_Picture: ''
      },
      {
        Scenic_Name: '泰山旅游景区',
        Scenic_Picture: ''
      },
      {
        Scenic_Name: '泰山旅游景区',
        Scenic_Picture: ''
      },
      {
        Scenic_Name: '泰山旅游景区',
        Scenic_Picture: ''
      },
      {
        Scenic_Name: '泰山旅游景区',
        Scenic_Picture: ''
      },
      {
        Scenic_Name: '泰山旅游景区',
        Scenic_Picture: ''
      },
      {
        Scenic_Name: '泰山旅游景区',
        Scenic_Picture: ''
      },
      {
        Scenic_Name: '泰山旅游景区',
        Scenic_Picture: ''
      }
    ],
    locationScenicUrls:[],
    ScenicVedios: [
      {
        Scenic_ID: '',
        Scenic_Name: '天上人间',
        Scenic_Picture: '',
        Scenic_Vedio: 'http://www.iqiyi.com/w_19rra6aup9.html'
      },
      {
        Scenic_ID: '',
        Scenic_Name: '天上人间',
        Scenic_Picture: '',
        Scenic_Vedio: 'http://www.iqiyi.com/w_19rra6aup9.html'
      },
      {
        Scenic_ID: '',
        Scenic_Name: '天上人间',
        Scenic_Picture: '',
        Scenic_Vedio: 'http://www.iqiyi.com/w_19rra6aup9.html'
      },
      {
        Scenic_ID: '',
        Scenic_Name: '天上人间',
        Scenic_Picture: '',
        Scenic_Vedio: 'http://www.iqiyi.com/w_19rra6aup9.html'
      },
      {
        Scenic_ID: '',
        Scenic_Name: '天上人间',
        Scenic_Picture: '',
        Scenic_Vedio: 'http://www.iqiyi.com/w_19rra6aup9.html'
      },
      {
        Scenic_ID: '',
        Scenic_Name: '天上人间',
        Scenic_Picture: '',
        Scenic_Vedio: 'http://www.iqiyi.com/w_19rra6aup9.html'
      },
      {
        Scenic_ID: '',
        Scenic_Name: '天上人间',
        Scenic_Picture: '',
        Scenic_Vedio: 'http://www.iqiyi.com/w_19rra6aup9.html'
      },
      {
        Scenic_ID: '',
        Scenic_Name: '天上人间',
        Scenic_Picture: '',
        Scenic_Vedio: 'http://www.iqiyi.com/w_19rra6aup9.html'
      }
    ],
    todayScenics: [
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      },
      {
        Scenic_Name: '泰山实干当',
        Scenic_ID: ''
      }
    ],
    ScenicList: [
      {
        Scenic_ID: '',
        Scenic_Name: '泰山风景区'
      }
    ],
    scenicType: 0,
    ScenicListUrls: []
  },
  methods: {
    init(){
      this.getLocationScenic()
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
        this.getScenicList()
      }
    },
    changeCity(id,name,proID){
      this.locatCitID = id
      this.location = name
      this.locatProID = proID
      if(this.nowPage == 1){
        this.getLocationScenic()
      }else if(this.nowPage == 2){
        this.getScenicList()
      }
    },
    getLocationScenic(){
      var self = this
      self.locationScenicUrls = []
      $.get('/tourplace/src/scenic.php',{
        Type: 3,
        Keys: "Scenic_ID+Scenic_Name+ScenicPicture",
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
          for(var i in Result){
            self.locationScenicUrls.push('/tourplace/components/content/scenic/scenic.html?id=' + i.Scenic_ID)
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
        Keys: "Scenic_ID+Scenic_Name+ScenicPicture+Scenic_Vedio",
        Page: 1,
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
      $.get('/tourplace/src/scenic.php',{
        Type: 0,
        Keys: "Scenic_ID+Scenic_Name",
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
    getScenicList(){
      $.get('/tourplace/src/scenic.php',{
        Type: 3,
        Keys: "Scenic_ID+Scenic_Name+ScenicPicture",
        Page: 1,
        PageSize: 8,
        Search: {
          Province_ID: self.locatProID,
          City_ID: self.locatCitID,
          Scenic_Level: self.scenicLevel,
          Scenic_Type: self.scenicType
        }
      })
      .done(function(response){
        var res = JSON.parse(response)
        if(res.Type == 0){
          self.scenicNum = res.sumSize
          self.locationScenics = res.Result
          for(var i in res.Result){
            self.ScenicListUrls.push('/tourplace/components/content/scenic/scenic.html?id=' + i.Scenic_ID)
          }
        }else{
          alert("出错了"+res.Result.Errmsg)
        }
      })
      .fail(function(){
        alert("发生了未知的错误")
      })
    },
    find: function(){
      window.open("/tourplace/components/content/scenic/scenic.html?id="+this.searchInfor)
    },
    loginORuser(){
      var self = this
      if(self.userID == ""){
        window.location = '/tourplace/components/content/login/login.html'
      }else{
        window.location = '/tourplace/components/content/user/user.html?id='+self.userID+'&card=1'
      }
    }
  },
  mounted: function(){
    var self = this
    setInterval(function(){
      self.gotonext()
    },6000)
    self.userID = self.getQueryString("id")
    if(self.userID != ''){
      $.get('/tourplace/src/user.php',{
        Type: 0,
        Key: 'User_Name',
        Page: 1,
        PageSize: 1,
        Search: {
          User_ID: self.userID
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
    }
    self.init()
  }
})

new Vue({
  el: '#container',
  data: {
    location: '全国',
    placeSelect: false,
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
    user: '请登入'
  },
  methods: {
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
    }
  },
  mounted: function(){
    var self = this
    setInterval(function(){
      self.gotonext()
    },6000)
  }
})

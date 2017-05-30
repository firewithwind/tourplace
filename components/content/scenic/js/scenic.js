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
    user: '请登入',
    ScenicName: '泰山风景名胜区',
    ScenicEnglishName: 'Mount tai scenic spot',
    grade: '5A',
    place: '山东省泰安市',
    intro: '泰山风景名胜区（Mount tai scenic spot）：世界自然与文化遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国重点文物保护单位，中华国山，中国非物质文化遗产，全国文明风景旅游区，中国书法第一山。',
    tickets: [
      {
        salerImg: '/tourplace/img/user/00.jpg',
        salerName: '小小濠',
        salerPhone: '17862702878',
        salerShow: 0,
        time: '2017-05-30',
        price: 40
      }
    ]
  }
})

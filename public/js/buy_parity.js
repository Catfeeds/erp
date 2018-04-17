! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'buyParity'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })

      new Vue({
        el: '#buyParityForm',
        data: {
          dateOption: _schemas.datePickerOption,
          date: '',
          commodities: [],
          currentMaterials: {
            name: '',
            parameter: '暂无数据',
            model: '暂无数据',
            unit: '暂无数据',
            address: '暂无数据'
          },
          timeout: null
        },
        mounted() {
          this.commodities = this.loadAll()
          $('#buyParityForm').removeClass('invisible')
        },
        methods: {

          querySearch(queryString, cb) {
            var commodities = this.commodities
            var results = queryString ? commodities.filter(this.createFilter(queryString)) : commodities;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilter(queryString) {
            return (restaurant) => {
              return (restaurant.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          loadAll() {
            return [{
                "id": 1,
                "name": "三全鲜食（北新泾店）",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号一",
                "unit": "间",
                "address": "长宁区新渔路144号"
              },
              {
                "id": 2,
                "name": "Hot honey 首尔炸鸡（仙霞路）",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号二",
                "unit": "个",
                "address": "上海市长宁区淞虹路661号"
              },
              {
                "id": 3,
                "name": "新旺角茶餐厅",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号三",
                "unit": "只",
                "address": "上海市普陀区真北路988号创邑金沙谷6号楼113"
              },
              {
                "id": 4,
                "name": "泷千家(天山西路店)",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号四",
                "unit": "件",
                "address": "天山西路438号"
              },
              {
                "id": 5,
                "name": "胖仙女纸杯蛋糕（上海凌空店）",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号五",
                "unit": "间",
                "address": "上海市长宁区金钟路968号1幢18号楼一层商铺18-101"
              },
              {
                "id": 6,
                "name": "贡茶",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号六",
                "unit": "间",
                "address": "上海市长宁区金钟路633号"
              },
              {
                "id": 7,
                "name": "豪大大香鸡排超级奶爸",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号七",
                "unit": "间",
                "address": "上海市嘉定区曹安公路曹安路1685号"
              },
              {
                "id": 8,
                "name": "茶芝兰（奶茶，手抓饼）",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号八",
                "unit": "间",
                "address": "上海市普陀区同普路1435号"
              },
            ]
          },
          handleSelect(item) {
            this.currentMaterials = item
          },
        }
      })
    })
}()
Vue.component('demo-grid', {
  template: '#grid-template',
  replace: true,
  data: function () {
    return {
      columnHead: ['name', 'author', 'duetime'],
      columns: [ 'name', 'author', 'duetime'],
      sortKey: '',
      filterKey: '',
      searchQuery: '',
      reversed: {},
      data: {},
      name: { name: '文件名', author: '上传者', duetime: '上传时间'},
      indexPath: [{id: 0, name: 'root', author_id: 0, author_name:'root', duetime: '2015-05-00', is_folder: true}],
      curentIndex: 0,
      deleteIndex: -1,
      deleteFileName: '',
      deleteList: [],
      editList: [],
    }
  },
  created: function() {
    this.init();
  },
  compiled: function () {
    // initialize reverse state
    var self = this;
    this.columns.forEach(function (key) {
      self.reversed.$add(key, false)
    })
  },
  methods: {
    init: function () {
      var urls = window.location.hash.split('/');
      var index = 0;
      if (urls.length >= 2){
        index = urls[1];
      }
      this.indexPath = [{id: 0, name: 'Home', author_id: 0, author_name:'root', duetime: '2015-05-00', is_folder: true}];
      this.data = this.getChildIndex(index);
      for (var i = 0; i < this.data.length; i++) {
        this.generatePic(this.data[i]);
      }
    },

    sortBy: function (key) {
      this.sortKey = key
      this.reversed[key] = !this.reversed[key]
    },

    deleteAt: function (index) {
      this.deleteIndex = index;
      this.deleteFileName = this.data[index].name;
    },

    deleteFile: function () {
      var ele = this;
      if(this.deleteIndex < 0){
        return;
      }
      var row = $('#fileRow'+this.deleteIndex);
      row.fadeOut(500, function() {
        ele.deleteList.push(ele.data[ele.deleteIndex]);
        ele.data.$remove(ele.deleteIndex);
      });
      
    },
    changeDir: function(id) {
      var ele = this;
      var record;
      
      var pathIndex = -1;
      for (var i = 0; i < ele.indexPath.length; i++){
        if (ele.indexPath[i].id == id){
          pathIndex = i;
        }
      }
     
      for (var i = 0; i < ele.data.length; i++) {
        if(ele.data[i].id == id) {
          record = ele.data[i];
          break;
        }
      }
      if (record && !record.is_folder){
        return;
      }
      if(pathIndex < 0){
        ele.indexPath.push(record);
      }
      else{
        ele.indexPath = ele.indexPath.slice(0, pathIndex+1);
      }

      ele.data = ele.getChildIndex(id);
      for (var i = 0; i < ele.data.length; i++) {
        ele.generatePic(ele.data[i]);
      }

    },
    generatePic: function(info) {
      var picMap = {
        'pdf': 'pdf.png',
        'ppt': 'ppt.png',
        'pptx': 'ppt.png',
        'doc': 'word.png',
        'docx': 'word.png',
        'c': 'c.png',
        'h': 'h.png',
        'cpp': 'cpp.png',
        'cs': 'csharp.png',
        'py': 'python.png',
        'rb': 'ruby.png',
        'm': 'matlab.jpg',
        'txt': 'txt.png',
        'html': 'html.png',
        'js': 'js.png',
        'php': 'php.png',
      };
      if (info.is_folder){
        info.picUrl = '../../public/images/folder.png';
      }
      else{
        var nl = info.name.split('.');
        if (nl.length < 2){
          info.picUrl = '../../public/images/undefined.png';
        }
        else if (picMap[nl[1].toLowerCase()] != undefined){
          info.picUrl = '../../public/images/' + picMap[nl[1].toLowerCase()];
        }
        else{
          info.picUrl = '../../public/images/undefined.png';
        }
      }
    },
    getChildIndex: function(pid){
      var tree = {
        // 0 is the virtual folder that the current user can access
        // the first one should be always be the "My Files"
        // "My Files" is total same as other index
        0: [
          {id: 500, name: '我的文件', author_id: 1000, author_name:'one', duetime: '2015-05-28', is_folder:true},
          {id: 1000, name: '计算机', author_id: 9000, author_name:'two', duetime: '2015-05-27', is_folder:true},
          {id: 1001, name: '场波分析', author_id: 7000, author_name:'three', duetime: '2015-05-26', is_folder:true},
          {id: 1002, name: '大学物理', author_id: 8000, author_name:'four', duetime: '2015-05-25', is_folder:true},  
        ],
        1000: [
          {id: 2000, name: '计算机1.pdf', author_id: 1000, author_name:'one', duetime: '2015-05-28', is_folder:false},
          {id: 2001, name: '计算机2.doc', author_id: 9000, author_name:'two', duetime: '2015-05-27', is_folder:false},
          {id: 2002, name: '计算机3.docx', author_id: 7000, author_name:'three', duetime: '2015-05-26', is_folder:false},
          {id: 2003, name: '计算机4.txt', author_id: 8000, author_name:'four', duetime: '2015-05-25', is_folder:false},
        ],
        1001: [
          {id: 2004, name: '场波分析1.py', author_id: 1000, author_name:'one', duetime: '2015-05-28', is_folder:false},
          {id: 2005, name: '场波分析2.html', author_id: 9000, author_name:'two', duetime: '2015-05-27', is_folder:false},
          {id: 2006, name: '场波分析3.ppt', author_id: 7000, author_name:'three', duetime: '2015-05-26', is_folder:false},
          {id: 2007, name: '场波分析4.rb', author_id: 8000, author_name:'four', duetime: '2015-05-25', is_folder:false},
        ],
        1002: [
          {id: 2008, name: '大学物理1.m', author_id: 1000, author_name:'one', duetime: '2015-05-28', is_folder:false},
          {id: 2009, name: '大学物理2.js', author_id: 9000, author_name:'two', duetime: '2015-05-27', is_folder:false},
          {id: 2010, name: '大学物理3.php', author_id: 7000, author_name:'three', duetime: '2015-05-26', is_folder:false},
          {id: 2011, name: '大学物理4', author_id: 8000, author_name:'four', duetime: '2015-05-25', is_folder:false},
        ],
      };
      var res = tree[pid];
      if(res){
        return res;
      }
      else{
        return [];
      }
    }
  }
})

Vue.component('work-grid', {
  template: '#work-template',
  replace: true,
  data: function () {
    return {
      columnHead: ['name', 'lesson', 'dir', 'duetime'],
      columns: [ 'name', 'lesson', 'dir', 'duetime'],
      sortKey: '',
      filterKey: '',
      searchQuery: '',
      reversed: {},
      data: {},
      name: { name: '文件名', lesson: '课程', dir: '目录', duetime: '截止时间'},
      indexPath: [{id: 0, name: 'root', author_id: 0, author_name:'root', duetime: '2015-05-00', is_folder: true}],
      curentIndex: 0,
      deleteIndex: -1,
      deleteFileName: '',
      deleteList: [],
      editList: [],
    }
  },
  created: function() {
    this.init();
  },
  compiled: function () {
    // initialize reverse state
    var self = this;
    this.columns.forEach(function (key) {
      self.reversed.$add(key, false)
    })
  },
  methods: {
    init: function () {
      var urls = window.location.hash.split('/');
      var index = 0;
      if (urls.length >= 2){
        index = urls[1];
      }
      this.indexPath = [{id: 0, name: 'Home', author_id: 0, author_name:'root', duetime: '2015-05-00', is_folder: true}];
      this.data = this.getChildIndex(index);
      for (var i = 0; i < this.data.length; i++) {
        this.generatePic(this.data[i]);
      }
    },

    sortBy: function (key) {
      this.sortKey = key
      this.reversed[key] = !this.reversed[key]
    },

    deleteAt: function (index) {
      this.deleteIndex = index;
      this.deleteFileName = this.data[index].name;
    },

    deleteFile: function () {
      var ele = this;
      if(this.deleteIndex < 0){
        return;
      }
      var row = $('#fileRow'+this.deleteIndex);
      row.fadeOut(500, function() {
        ele.deleteList.push(ele.data[ele.deleteIndex]);
        ele.data.$remove(ele.deleteIndex);
      });
      
    },
    changeDir: function(id) {
      var ele = this;
      var record;
      if (id == 0 && ele.indexPath.length == 1) {
          window.location = '/file'
      }
      
      var pathIndex = -1;
      for (var i = 0; i < ele.indexPath.length; i++){
        if (ele.indexPath[i].id == id){
          pathIndex = i;
        }
      }
     
      for (var i = 0; i < ele.data.length; i++) {
        if(ele.data[i].id == id) {
          record = ele.data[i];
          break;
        }
      }
      if (record && !record.is_folder){
        return;
      }
      if(pathIndex < 0){
        ele.indexPath.push(record);
      }
      else{
        ele.indexPath = ele.indexPath.slice(0, pathIndex+1);
      }

      ele.data = ele.getChildIndex(id);
      for (var i = 0; i < ele.data.length; i++) {
        ele.generatePic(ele.data[i]);
      }

    },
    generatePic: function(info) {
      var picMap = {
        'pdf': 'pdf.png',
        'ppt': 'ppt.png',
        'pptx': 'ppt.png',
        'doc': 'word.png',
        'docx': 'word.png',
        'c': 'c.png',
        'h': 'h.png',
        'cpp': 'cpp.png',
        'cs': 'csharp.png',
        'py': 'python.png',
        'rb': 'ruby.png',
        'm': 'matlab.jpg',
        'txt': 'txt.png',
        'html': 'html.png',
        'js': 'js.png',
        'php': 'php.png',
      };
      if (info.is_folder){
        info.picUrl = '../images/folder.png';
      }
      else{
        var nl = info.name.split('.');
        if (nl.length < 2){
          info.picUrl = '../images/undefined.png';
        }
        else if (picMap[nl[1].toLowerCase()] != undefined){
          info.picUrl = '../images/' + picMap[nl[1].toLowerCase()];
        }
        else{
          info.picUrl = '../images/undefined.png';
        }
      }
    },
    getChildIndex: function(pid){
      var tree = {
        // 0 is the virtual folder that the current user can access
        // the first one should be always be the "My Files"
        // "My Files" is total same as other index
        0: [
          {id: 500, name: '我的文件', author_id: 1000, author_name:'one', duetime: '2015-05-28', is_folder:true},
          {id: 1000, name: '计算机', author_id: 9000, author_name:'two', duetime: '2015-05-27', is_folder:true},
          {id: 1001, name: '场波分析', author_id: 7000, author_name:'three', duetime: '2015-05-26', is_folder:true},
          {id: 1002, name: '大学物理', author_id: 8000, author_name:'four', duetime: '2015-05-25', is_folder:true},  
        ],
        1000: [
          {id: 2000, name: '计算机1.pdf', author_id: 1000, author_name:'one', duetime: '2015-05-28', is_folder:false},
          {id: 2001, name: '计算机2.doc', author_id: 9000, author_name:'two', duetime: '2015-05-27', is_folder:false},
          {id: 2002, name: '计算机3.docx', author_id: 7000, author_name:'three', duetime: '2015-05-26', is_folder:false},
          {id: 2003, name: '计算机4.txt', author_id: 8000, author_name:'four', duetime: '2015-05-25', is_folder:false},
        ],
        1001: [
          {id: 2004, name: '场波分析1.py', author_id: 1000, author_name:'one', duetime: '2015-05-28', is_folder:false},
          {id: 2005, name: '场波分析2.html', author_id: 9000, author_name:'two', duetime: '2015-05-27', is_folder:false},
          {id: 2006, name: '场波分析3.ppt', author_id: 7000, author_name:'three', duetime: '2015-05-26', is_folder:false},
          {id: 2007, name: '场波分析4.rb', author_id: 8000, author_name:'four', duetime: '2015-05-25', is_folder:false},
        ],
        1002: [
          {id: 2008, name: '大学物理1.m', author_id: 1000, author_name:'one', duetime: '2015-05-28', is_folder:false},
          {id: 2009, name: '大学物理2.js', author_id: 9000, author_name:'two', duetime: '2015-05-27', is_folder:false},
          {id: 2010, name: '大学物理3.php', author_id: 7000, author_name:'three', duetime: '2015-05-26', is_folder:false},
          {id: 2011, name: '大学物理4', author_id: 8000, author_name:'four', duetime: '2015-05-25', is_folder:false},
        ],
      };
      var res = tree[pid];
      if(res){
        return res;
      }
      else{
        return [];
      }
    }
  }
})

Vue.component('index-list', {
  template: '#index-template',
  data: function() {
    return{
      indexList: [],
    }
  },
  created: function() {
    this.init();
  },
  methods: { 
    init: function() {
      this.indexList = [
        {id: 500, name: '我的文件', url: '/index/500'},
        {id: 1000, name: '计算机', url: '/index/1000'},
        {id: 1001, name: '场波分析', url: '/index/1001'},
        {id: 1002, name: '大学物理', url: '/index/1002'},
      ];
    },
    refresh: function() {
      window.location.reload(true);
    },
  },
})

Vue.component('upload-pane', {
  template: '#upload-template',
  data: function() {
    return{
      indexList: [],
      currentPath: [],
      pathIds: [0],
    }
  },
  created: function() {
    this.init();
  },
  methods: {
    init: function() {
      this.indexList = [
        {id: 500, name: '我的文件', url: '/index/500'},
        {id: 1000, name: '计算机', url: '/index/1000'},
        {id: 1001, name: '场波分析', url: '/index/1001'},
        {id: 1002, name: '大学物理', url: '/index/1002'},
      ];
      this.currentPath = [];
      this.pathIds = [0];
    },
    getChildIndex: function(pid){
      var tree = {
        // 0 is the virtual folder that the current user can access
        // the first one should be always be the "My Files"
        // "My Files" is total same as other index
        0: [
          {id: 500, name: '我的文件'},
          {id: 1000, name: '计算机'},
          {id: 1001, name: '场波分析'},
          {id: 1002, name: '大学物理'},  
        ],
        1000: [
          {id: 2000, name: '计算机1'},
          {id: 2001, name: '计算机2'},
          {id: 2002, name: '计算机3'},
          {id: 2003, name: '计算机4'},
        ],
        1001: [
          {id: 2004, name: '场波分析1'},
          {id: 2005, name: '场波分析2'},
          {id: 2006, name: '场波分析3'},
          {id: 2007, name: '场波分析4'},
        ],
        1002: [
          {id: 2008, name: '大学物理1'},
          {id: 2009, name: '大学物理2'},
          {id: 2010, name: '大学物理3'},
          {id: 2011, name: '大学物理4'},
        ],
      };
      var res = tree[pid];
      if(res){
        return res;
      }
      else{
        return [];
      }
    },
    expandIndex: function(index) {
      var ele = this;
      var id = this.indexList[index].id;
      var path = this.currentPath;
      path.push({name: this.indexList[index].name})
      ele.pathIds.push(id);
      var childList = this.getChildIndex(id);
      ele.indexList = childList;
    },
    goUp: function() {
      var ele = this;
      var pathIds = this.pathIds;
      if (pathIds.length <= 1){
        return;
      }
      pathIds.pop();
      ele.currentPath.pop();
      var currentPid = pathIds[pathIds.length-1];
      var childList = ele.getChildIndex(currentPid);
      if (childList && childList.length > 0){
        ele.indexList = childList;
      }
    },
  }
})

// bootstrap the demo
var demo = new Vue({
  el: '#fileBody',
  data: {
  }
})
Vue.component('work-grid', {
  template: '#work-template',
  replace: true,
  data: function () {
    return {
      columnHead: ['name', 'author', 'duetime'],
      columns: [ 'name', 'author_name', 'duetime'],
      sortKey: '',
      filterKey: '',
      searchQuery: '',
      reversed: {},
      data: [],
      downloads: [],
      name: { name: '文件名', author: '发布者', duetime: '截止时间'},
      indexPath: [{id: 0, name: 'root', author_id: 0, author_name:'root', duetime: '2015-05-00', is_folder: true}],
      currentIndex: -2,
      // 删除
      deleteIndex: -1,
      deleteFileName: '',
      deleteList: [],
      editList: [],
      // 评分
      commentIndex: -1,
      commentFileName: '',
      // 新建目录信息
      folderName: '',
      folderDescription: '',
      // ajax错误信息
      lastError: '',
      // 用户信息
      userName: '',
      // 0 学生 1 老师 2 admin
      userType: 0,
      userAdmin: false,
      // url前缀
      prefixUrl: '/teaching_system_B4/index.php',
      // 上传记录
      uploadNameRecord: '1',
      uploadIdRecord: '2',
      uploadFlag: 0,
      uploadIndex: -1,
      uploadPath: [],
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
  watch: {
    'uploadFlag': function(val, oldval){
      console.log(val+oldval);
      if (val == 0){
        return;
      }
      this.uploadFlag = 0;
      var todayDate = new Date();
      var timeStr = todayDate.toLocaleString();
      var record = {id: this.uploadIdRecord, name: this.uploadNameRecord, author_name: this.userName, duetime: timeStr, is_folder: false};
      this.generatePic(record);
      this.data.unshift(record);
    } 
  },
  methods: {
    init: function () {
      var ele = this;
      var urls = window.location.hash.split('/');
      var index = 0;
      if (urls.length >= 2){
        index = urls[1];
        ele.currentIndex = index;
      }
      ele.indexPath = [{id: 0, name: 'Home', author_id: 0, author_name:'root', duetime: '2015-05-00', is_folder: true}];
      ele.data = [];
      ele.downloads = [100, 1800, 100, 900];
      ele.uploadRecord = '';
      
      $.ajax({
        url: ele.prefixUrl + '/Index/userinfo',
        type: 'POST',
        dataType: 'JSON',
        data:{

        },
        success: function(res) {
          ele.userName = res.userName;
          ele.userType = res.userType;
          ele.userAdmin = ele.userType == 2;
          ele.getChildIndex(index, function(){
            var storage = window.localStorage;
            var path = storage.getItem('pathKey:'+index);
            if (path != null) {
              ele.indexPath = JSON.parse(path);
            }
          });
          $('.form_datetime').datetimepicker({
              language:  'zh-CN',
              weekStart: 1,
              todayBtn:  1,
              autoclose: 1,
              todayHighlight: 1,
              startView: 2,
              forceParse: 0,
              showMeridian: 1
          });
          var fileUpload = $('#fileupload');
          fileUpload.fileupload({
            url: ele.prefixUrl + '/Index/handinfile',
            dataType: 'json',
            formData:{
              'fid': ele.currentIndex,
              'sid': 1
            },
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo('#files');
                });
                ele.uploadIndex = -1;
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
          }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled'); 
        },
        error: function(res, status, e) {
          ele.errorDlgIn(res.status+' '+e);
        }
      });
    },

    sortBy: function (key) {
      this.sortKey = key
      this.reversed[key] = !this.reversed[key]
    },

    deleteAt: function (index) {
      var ele = this;
      ele.deleteIndex = index;
      ele.deleteFileName = ele.data[index].name;
      ele.deleteDlgIn();
    },

    commentAt: function (index) {
      var ele = this;
      ele.commentIndex = index;
      ele.commentFileName = ele.data[index].name;
      ele.commentDlgIn();
    },

    uploadAt: function (index) {
        var ele = this;
        ele.uploadIndex = ele.data[index].id;
        ele.uploadPath = ele.indexPath.slice();
        ele.uploadPath.push(ele.data[index]);
        ele.uploadDlgIn();
    },

    uploadForm: function() {
      var ele = this;
      var formData = new FormData($('#uploadForm')[0]);
      $.ajax({
          url: ele.prefixUrl + '/Index/uploadfile',
          type: 'POST',
          data: formData,
          success: function(res) {
            ele.data = res;
            ele.uploadDlgOut();
          },
          error: function(res, status, e) {
            ele.errorDlgIn(res.status+' '+e);
          },
          cache: false,
          contentType: false,
          processData: false,
          async: false
      });
          
    },

    deleteFile: function () {
      var ele = this;
      if(this.deleteIndex < 0){
        return;
      }
      if(ele.data[ele.deleteIndex].is_folder) {
        $.ajax({
          url: ele.prefixUrl + '/Index/deldir',
          type: 'POST',
          dataType: 'JSON',
          data: {
            fid: ele.data[ele.deleteIndex].id,
          },
          success: function(res) {
            var row = $('#fileRow'+ele.deleteIndex);
            row.fadeOut(500, function() {
            ele.deleteList.push(ele.data[ele.deleteIndex]);
              ele.data.$remove(ele.deleteIndex);
            });
          },
          error: function(res, status, e) {
            ele.errorDlgIn(res.status+' '+e);
          }
        });
      }
      else{
        $.ajax({
          url: ele.prefixUrl + 'delfile',
          type: 'POST',
          dataType: 'JSON',
          data: {
            fid: ele.data[ele.deleteIndex].id,
          },
          success: function(res) {
            var row = $('#fileRow'+ele.deleteIndex);
            row.fadeOut(500, function() {
            ele.deleteList.push(ele.data[ele.deleteIndex]);
              ele.data.$remove(ele.deleteIndex);
            });
          },
          error: function(res, status, e) {
            ele.errorDlgIn(res.status+' '+e);
          }
        });

      }
    },
    commentHomeWork: function() {
      var ele = this;
      if(this.commentIndex < 0){
        return;
      }
      $.ajax({
        url: '/file/comment',
        type: 'POST',
        dataType: 'JSON',
        data: {
          fid: ele.data[ele.commentIndex].id,
        },
        success: function(res) {
          
        },
        error: function(data, status, e) {
          ele.errorDlgIn(res.status+' '+e);
        }
      })
    },

    changeDir: function(id) {
      var ele = this;
      var record;
      var pathIndex = -1;
      ele.currentIndex = id;
      // search result
      if (id == -1) {
        return;
      }
      for (var i = 0; i < ele.indexPath.length; i++){
        if (ele.indexPath[i].id == id){
          pathIndex = i;
          break;
        }
      }
      var listIndex = -1;
      for (var i = 0; i < ele.data.length; i++) {
        if(ele.data[i].id == id) {
          record = ele.data[i];
          listIndex = i;
          break;
        }
      }
      if (record && !record.is_folder){
        // ele.downloadfile(listIndex);
        return;
      }
      if(pathIndex < 0){
        ele.indexPath.push(record);
      }
      else{
        ele.indexPath = ele.indexPath.slice(0, pathIndex+1);
      }
      var pathStr = '/Home';
      for (var i = 1; i < ele.indexPath.length; ++i){
        pathStr += '/' + ele.indexPath[i].name;
      }
      document.getElementById('pathRecord').value = pathStr;
      ele.searchQuery = '';
      ele.getChildIndex(id, function(){
      });
      window.location.replace(ele.prefixUrl + '/Index/work#/'+id);
      // 存储路径信息
      var storage = window.localStorage;
      storage.setItem('pathKey:'+id, JSON.stringify(ele.indexPath));
    },

    // c 
    // f
     createFolder: function() {
      var ele = this;
      if (ele.currentIndex < 0){
        return;
      }
      var dueTime = $('#dtp_input1').val();
      $.ajax({
        url: ele.prefixUrl + '/Teacher/newhomework',
        type: 'POST',
        dataType: 'JSON',
        data: {
          // path: $('#pathRecord').val(),
          fid: ele.currentIndex,
          name: ele.folderName,
          duetime: dueTime,
        },
        success: function(res){
          var todayDate = new Date();
          var timeStr = todayDate.toLocaleString();
          ele.data = res;
          for (var i = 0; i < res.length; i++){
            ele.generatePic(ele.data[i]);
          }
        },
        error: function(res, status, e){
          ele.errorDlgIn(res.status+' '+e);
        },
      })
    },

    downloadfile: function(index) {
      var ele = this;
      if (ele.data[index].is_folder) {
        return;
      }
      var f = document.createElement("form");
      document.body.appendChild(f);
      var i = document.createElement("input");
      i.type = "hidden";
      f.appendChild(i);
      i.value = ele.data[index].id;
      i.name = "rid";
      f.action = ele.prefixUrl + '/Teacher/downloadfile';
      f.method = 'POST';
      f.submit();
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

    search: function(){
      var ele = this;
      var query = ele.searchQuery;
      if (query == '') {
        ele.errorDlgIn('请输入关键字');
        return;
      }
      $.ajax({
        url: '/file/search',
        type: 'POST',
        dataType: 'JSON',
        data: {
          query: query,
        },
        success: function(res) {
          if (ele.indexPath[ele.indexPath.length-1].id == -1){
            ele.indexPath.pop();
          }
          ele.indexPath.push({id: -1, name: '搜索'+query});
          ele.searchQuery = '';
          ele.currentIndex = -1;
        },
        error: function(res, status, e) {
          if (ele.indexPath[ele.indexPath.length-1].id == -1){
            ele.indexPath.pop();
          }
          ele.indexPath.push({id: -1, name: '搜索 '+query});
          ele.errorDlgIn(res.status+' '+e);
        },
      });
    },
    createDlgIn: function() {
      var ele = this;
      if (ele.currentIndex < 0){
        return;
      }
      $('#createModal').modal('show');
    },
    createDlgOut: function() {
      $('#createModal').modal('hide');
    },
    commentDlgIn: function() {
      $('#commentModal').modal('show');
    },
    commentDlgOut: function() {
      $('#commentModal').modal('hide');
    },
    deleteDlgIn: function() {
      $('#deleteModal').modal('show');
    },
    deleteDlgOut: function() {
      $('#deleteModal').modal('hide');
    },
    uploadDlgIn: function() {
      $('#uploadModal').modal('show');
    },
    uploadDlgOut: function() {
      $('#uploadModal').modal('hide');
    },
    errorDlgIn: function(e) {
      var ele = this;
      ele.lastError = e;
      $('#errorModal').modal('show', function() {
      });
    },
    errorDlgOut: function() {
      $('#errorModal').modal('hide');
    },
    getChildIndex: function(pid, callback){
      var ele = this;
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
        500: [],
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
      $.ajax({
        url: ele.userType==0? ele.prefixUrl + '/Index/homeworkinfo':ele.prefixUrl + '/Teacher/homeworkinfo',
        type: 'POST',
        dataType: 'JSON',
        data: {
          fid: pid, 
        },
        success: function(res) {
          if(res){
            ele.data = res;
          }
          else{
            ele.data = [];
          }
          for (var i = 0; i < ele.data.length; i++) {
            ele.generatePic(ele.data[i]);
          }
          callback();
        },
        error: function(res, status, e) {
          var result = tree[pid];
          if(result){
            ele.data = result;
            ele.downloads = [100, 1800, 100, 900];
          }
          else{
            ele.data = [];
            ele.downloads = [100, 1800, 100, 900];
          }
          for (var i = 0; i < ele.data.length; i++) {
            ele.generatePic(ele.data[i]);
          }
          callback();
          ele.errorDlgIn(res.status+' '+e);
        },
      });   
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
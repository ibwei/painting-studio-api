//app.js
App({
  onLaunch: function () {
    var that = this;
    //  获取商城名称
    wx.request({
      url: that.globalData.apiDomain + '/store-info',
      success: function (res) {
        if (res.data.code == 200) {
          wx.setStorageSync('mallName', res.data.data.value);
        }
      }
    })
    this.login();
  },
  login: function () {
    var that = this;
    var token = that.globalData.token;
    console.log(token)
    if (!token) {
      wx.login({
        success: function (res) {
          var code = res.code; // 微信登录接口返回的 code 参数，下面注册接口需要用到
          wx.getUserInfo({
            success: function (res) {
              var iv = res.iv;
              var encryptedData = res.encryptedData;
              // 下面开始调用注册接口
              wx.request({
                url: that.globalData.apiDomain + '/login',
                data: { code: code, encryptedData: encryptedData, iv: iv, rawData: res.rawData }, // 设置请求的 参数
                method:'POST',
                dataType:'json',
                success: (res) => {
                  if (res.data.code != 200) {
                    // 登录错误
                    wx.hideLoading();
                    wx.showModal({
                      title: '提示',
                      content: '无法登录，请重试',
                      showCancel: false
                    })
                    return;
                  }
                  that.globalData.token = res.data.data.token;
                  that.globalData.uid = res.data.data.uid;
                }
              })
            }
          })
        }
      })
    }

  },




  sendTempleMsg: function (orderId, trigger, template_id, form_id, page, postJsonString) {
    var that = this;
    wx.request({
      url: 'https://api.it120.cc/' + that.globalData.subDomain + '/template-msg/put',
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      data: {
        token: that.globalData.token,
        type: 0,
        module: 'order',
        business_id: orderId,
        trigger: trigger,
        template_id: template_id,
        form_id: form_id,
        url: page,
        postJsonString: postJsonString
      },
      success: (res) => {
        //console.log('*********************');
        //console.log(res.data);
        //console.log('*********************');
      }
    })
  },


  getUserInfo: function (cb) {
    var that = this
    if (this.globalData.userInfo) {
      typeof cb == "function" && cb(this.globalData.userInfo)
    } else {
      //调用登陆接口
      wx.login({
        success: function () {
          wx.getUserInfo({
            success: function (res) {
              that.globalData.userInfo = res.userInfo
              typeof cb == "function" && cb(that.globalData.userInfo)
            }
          })
        }
      })
    }

  },


  globalData: {
    userInfo: null,
    apiDomain: 'https://xiaocheng.xuezhangbang.me/api',//"http://www.shiqc_papershop.com/api",
    subDomain: "tz", // 如果你的域名是： https://api.it120.cc/abcd 那么这里只要填写 abcd
    version: "1.8",
    shareProfile: '百款精品商品，总有一款适合您' // 首页转发的时候话术
  }
  // 根据自己需要修改下单时候的模板消息内容设置，可增加关闭订单、收货时候模板消息提醒
})

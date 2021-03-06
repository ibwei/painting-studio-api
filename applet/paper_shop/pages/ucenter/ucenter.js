var util = require('../../common/common.js');
let URLINDEX=util.prefix();
Page({
  data:{
    userInfo:{},
    img_bg:URLINDEX+"/index/bd@2x.png",
    order_gaid:[
      {
        state:"待付款",
        img:URLINDEX+"/index/payment.png",
        id:1
      },
      {
        state:"待发货",
        img:URLINDEX+"/index/Waitingdelivery.png",
        id:2
      },
      {
        state:"待收货",
        img:URLINDEX+"/index/Forthegoods.png",
        id:3
      },
      {
        state:"已完成",
        img:URLINDEX+"/index/completed.png",
        id:4
      },
    ],
    line1:[
      {
        name:"我的优惠券",
        img:URLINDEX+"/index/youhuijuan.png",
        id:1
      },
      {
        name:"积分商城",
        img:URLINDEX+"/index/integral.png",
        id:2
      },
      {
        name:"客户与反馈",
        img:URLINDEX+"/index/CustomerService.png",
        id:3
      },
      {
        name:"收货地址",
        img:URLINDEX+"/index/positioning.png",
        id:4
      }
    ],
    line2:[
       {
        name:"实名认证",
        img:URLINDEX+"/index/Idcertification.png",
        id:1
      },
      {
        name:"关于九猫家",
        img:URLINDEX+"/index/Aboutninecatshome.png",
        id:2
      },
      {
        name:"关注公众号",
        img:URLINDEX+"/index/public.png",
        id:3
      },
      {
        name:"好货推荐",
        img:URLINDEX+"/index/Goodrecommendation.png",
        id:4
      }
    ]
  },
  onLoad:function(options){
    var that = this;
     wx.getUserInfo({
      success: function(res) {
        that.setData({
          userInfo:res.userInfo
        })
      }
    })
  },
  onReady:function(){
    // 页面渲染完成
  },
  onShow:function(){
    // 页面显示
    console.log(this.data.userInfo)
  },
  onHide:function(){
    // 页面隐藏
  },
  onUnload:function(){
    // 页面关闭
  }
})
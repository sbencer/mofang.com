define("luckydraw",function(require, exports, module){
    
    var $ = require("jquery");

    /**
     * @example
     * var lottery=new squareDraw({
     *     "id_dom":"lottery_gift",
     *     "prize_arr":['a','b','c','d','e','f','g','h'],
     *     "round_count":2,
     *     "normal_speed":400,
     *     "up_speed":100,
     *     "start_point":6,
     *     "end_point":38,
     *     "show_result":function(prize_name){
     *          console.log("恭喜你中了"+prize_name);
     *   }
     * })
     */

    function squareDraw(){
        this.initialize.apply(this, arguments)
    }

    squareDraw.prototype={
        /**
         * 抽奖组件初始化函数
         */
        initialize:function(obj){
            //整个转盘的ID节点
            this.id_dom=$(obj.id_dom)[0];
            //随机的点的class的名字
            this.suiji=$(".suiji")[0];
            //具体有那些奖品
            this.prize_arr=obj.prize_arr;
            //奖品数量
            this.award_count = obj.prize_arr.length;
            //旋转圈数
            this.round_count = obj.round_count || 2;
            //默认旋转速度
            this.normal_speed = obj.normal_speed || 400;
            //中途加速
            this.up_speed = obj.up_speed || 100;
            //起始点
            this.start_point=obj.start_point || 6;
            //结束点
            this.end_point=obj.end_point || 20,
            //展示结果的方法
            this.show_result=obj.show_result || function(){};

            //定时器_执行连接
            this.timer_link=null;

        },
        /**
         * 设置奖品
         */
        set_prize:function(prize){
            this.award_index = 1;
            this.round_index = 0;
            this.prize=prize;
            this.suiji.style.display="block";
            var prize_index=this.find_prize_index(prize);
            prize_index!=-1 && this.run_fn(++prize_index);

        },
        /**
         * 寻找获得奖品在数组中的索引
         */
        find_prize_index:function(prize){
            for(var i=0; i<this.award_count;i++) if(this.prize_arr[i]==prize) return i;
            return -1;
        },
        /**
         * 转动
         */
        run_fn:function(prize_index){
            this.suiji.className="suiji suiji_"+this.award_index;
            //达到旋转圈数，且当前指针是用户奖励时停止
            if(this.round_index >= this.round_count && this.award_index == prize_index){
                this.show_result(this.prize);
                return false;
            }
            //调整速度
            var k = parseInt(this.award_index+(this.round_index*this.award_count));
            var speed = (k < this.start_point || k > this.end_point) ? this.normal_speed : this.up_speed;

            //索引切换
            if(this.award_index < this.award_count){
                this.award_index++;
            }else{
                this.award_index = 1;
                this.round_index++;
            }

            //定时执行
            var _this = this;
            this.timer_link = setTimeout(function(){_this.run_fn(prize_index);}, speed);
        },
    }

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = squareDraw;
    }
});

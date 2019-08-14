<template>
    <div class="schedule">
        <div class="time-ground">
            <ul style="list-style-type: none;">
                <li v-for="(time, index) in timeGround" :key="index">
                    <span>
                        {{ time }}
                    </span>
                    <p :style="timeListSty"></p>
                </li>
            </ul>
        </div>
        <div class="task-ground">
            <ul style="list-style-type: none;">
                <li 
                    v-for="(week, index) in weekGround" 
                    class="task-list"
                    :key="index"
                    >
                    <p> 
                        {{ week }} 
                    </p>
                    <ul :style="taskListSty">
                        <template
                            v-for="detail in tasksList[index]"
                            >
                            <li class="task-list-item"
                                :style="detail.styleObj"
                                v-if="detail.hasOwnProperty('styleObj')"
                                >
                                <p> {{ detail.dateStart }} - {{ detail.dateEnd }}</p>
                                <h5> {{ detail.title }} </h5>
                            </li>
                        </template>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    import moment from 'moment';
    export default {
        props: {
            timeGround: {
                coerce(value) {
                    if (value && value.length == 2) {
                        const startTime   = value[0].split(":")[0] * 1,
                              endTime     = value[1].split(":")[0] * 1;
                        value = [];
                        for (let i = startTime; i <= endTime; i++) {
                            const hour = i < 10 ? "0" + i : "" + i;
                            value.push(hour + ":00");
                        }
                    } else {
                        value = [ "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00",
                            "18:00", "19:00", "20:00", "21:00" ]
                    }
                    return value;
                }
            },
            weekGround: {
                type:       Array,
                default:    [ 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche' ]
            },

            color: {
                type:       Array,
                default()   { return [ "#ff8000", "#00ff40", "#0080ff", "#8000ff", "#ff00bf", "#6e1a12", "#004f3a", "#6666ff", "#0066cc", "#134d00", "#ffa111", "#b200a4" ] }
            },
            taskDetail: {
                type:       Array,
                default:    []
            }
        },
        data() {
            return {
                showModal:          false,
                showModalDetail:    {
                    dateStart:  '09:30',
                    dateEnd:    '10:30',
                    title:      'Metting',
                    week:       'Lundi',
                    styleObj: {
                        backgroundColor: "#903749"
                    },
                    detail: 'Metting (German: Mettingen) is a commune in the Moselle department in Grand Est in north-eastern France.'
                },
                taskListSty:        {
                    height: '800px',
                    paddingLeft: 0
                },
                timeListSty:        {
                    width: '100%'
                },
                tasksList:          [],
                taskIndex:          0
            }
        },
        mounted () {
            this.$nextTick(function() {
                const _self = this;
                _self.taskListSty.height = (_self.timeGround.length - 1) * 101 + 'px';
                _self.timeListSty.width  = _self.weekGround.length * 14.28 + '%';
                _self.init();
            });
        },
        methods: {
            init: function() {
                const _self   = this,
                      maxTime = _self.timeGround[_self.timeGround.length - 1],
                      minTime = _self.timeGround[0],
                      maxMin  = maxTime.split(':')[0] * 60 + maxTime.split(':')[1] * 1,
                      minMin  = minTime.split(':')[0] * 60 + minTime.split(':')[1] * 1;

                for (let i = 0; i < _self.taskDetail.length; i++) {
                    _self.tasksList[i] = [];
                    _self.taskIndex = 0;
                    _self.setTaskDay(i, maxMin, minMin);
                }
            },
            setTaskDay(i, maxMin, minMin) {
                const _self   = this;
                for (let j = 0; j < _self.taskDetail[i].length; j++) {
                    _self.tasksList[i][_self.taskIndex] = {};
                    if (_self.taskDetail[i][j].hasOwnProperty('dateStart')) {
                        const startMin = _self.taskDetail[i][j].dateStart.split(':')[0] * 60 + _self.taskDetail[i][j].dateStart.split(':')[1] * 1,
                              endMin   = _self.taskDetail[i][j].dateEnd.split(':')[0] * 60 + _self.taskDetail[i][j].dateEnd.split(':')[1] * 1;
                        if (startMin < minMin || endMin > maxMin) {
                            _self.taskIndex--;
                            continue;
                        }
                        const difMin  = endMin - startMin,
                              startAt = _self.taskDetail[i][j].dateStart.split(":"),
                              endAt   = _self.taskDetail[i][j].dateEnd.split(":");
                        _self.tasksList[i][_self.taskIndex].dateStart = startAt[0] + ':' + startAt[1];
                        _self.tasksList[i][_self.taskIndex].dateEnd   = endAt[0] + ':' + endAt[1];
                        _self.tasksList[i][_self.taskIndex].title     = _self.taskDetail[i][j].title;
                        _self.tasksList[i][_self.taskIndex].styleObj  = {
                            height: difMin * 100 / 60 + 'px',
                            top: ((startMin - (_self.timeGround[0].split(":")[0] * 60 + _self.timeGround[0].split(":")[1] * 1)) * 100 / 60) + 65 + 'px',
                            backgroundColor: _self.taskDetail[i][j].color
                        };
                        _self.taskIndex++;
                    }
                }
            }
        },
        watch: {
            taskDetail: function() {
                const _self = this;
                _self.init();
            }
        }
    }
</script>
<style>
.schedule{
	width: 80%;
	max-width: 1400px;
	margin: 0 auto;
	position: relative;
}
.time-ground{
	display: block;
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
}
.time-ground ul {
    padding-left: -1vw;
}
.time-ground ul li{
	margin-top: 50px;
	font-size: 1rem;
	height: 50px;
}
.time-ground ul li span{
	position: absolute;
	left: -60px;
	
}
.time-ground ul li p{
	position:absolute;
	left: 0;
	height: 1px;
	background-color: #EAEAEA;
}
.task-ground{
	width: 100%;
}
.task-list{
	float: left;
	width: 14.28%;
	box-sizing:border-box;
	border:1px solid #EAEAEA;
}
.task-list p{
	text-align: center;
	font-size: 1rem;
	padding: 1rem;
}
.task-list-item{
	position: absolute;
	background-color: #577F92;
	width: 14.00%;
	height: 50px;
	cursor: pointer;
    list-style-type: none;
    box-shadow: 0px 1px 50px #5E5E5E;
}
.task-list-item p{
	text-align: left;
	padding: 0;
	margin: 1rem 0 0 1rem;
	font-size: 0.8rem;
	color: #EDF2F6;
}
.task-list-item h5{
	color: #E0E7E9;
	margin: 1rem 0 0 1rem;
}

.task-list-item-phone-p{
	text-align: left;
	padding: 0;
	margin: 1rem 0 0 1rem;
	font-size: 0.8rem;
	color: #EDF2F6;
}

.task-list-item-phone-h {
    color: #E0E7E9;
	margin: 1rem 0 0 1rem;
}
</style>